<?php

namespace App\Services;

use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use PDO;

class BackupService
{
    /**
     * Storage disk for backup files.
     */
    protected string $disk = 'local';

    /**
     * Relative directory within the storage disk.
     */
    protected string $directory = 'backups/db';

    /**
     * Default maximum number of backup files to retain.
     */
    protected int $defaultMaxBackups = 5;

    public function __construct(?string $disk = null, ?string $directory = null)
    {
        if ($disk) {
            $this->disk = $disk;
        }
        if ($directory) {
            $this->directory = trim($directory, '/');
        }
    }

    /**
     * Run the full backup workflow: dump, compress, store, and prune old files.
     *
     * @param  int|null  $maxBackups  Maximum number of backup files to keep (default: 5)
     * @return array Metadata about the completed backup
     *
     * @throws Exception
     */
    public function runBackup(?int $maxBackups = null): array
    {
        $limit = $maxBackups ?? $this->defaultMaxBackups;
        $connection = config('database.default', 'mysql');
        $timestamp = Carbon::now()->format('Y-m-d_His');
        $databaseName = config("database.connections.{$connection}.database", 'database');

        // Clean database name for safe filename
        $safeDbName = preg_replace('/[^a-zA-Z0-9_-]/', '_', (string) $databaseName);
        $filename = "backup_{$safeDbName}_{$timestamp}.sql.gz";
        $relativeFilePath = "{$this->directory}/{$filename}";

        Log::info("Starting automated database backup for [{$databaseName}] ({$connection})...");

        // 1. Generate SQL Dump
        $sqlContent = $this->generateSqlDump($connection);

        // 2. Compress using GZIP
        $compressedContent = gzencode($sqlContent, 9);
        if ($compressedContent === false) {
            throw new Exception('Failed to compress database dump using gzip.');
        }

        // 3. Ensure directory exists and store file
        Storage::disk($this->disk)->makeDirectory($this->directory);
        Storage::disk($this->disk)->put($relativeFilePath, $compressedContent);

        $fileSizeBytes = strlen($compressedContent);
        $absolutePath = Storage::disk($this->disk)->path($relativeFilePath);

        Log::info("Database backup created successfully: [{$relativeFilePath}] ({$this->formatBytes($fileSizeBytes)}).");

        // 4. Prune old backups to maintain the limit of 5 files
        $prunedFiles = $this->cleanOldBackups($limit);

        return [
            'success' => true,
            'filename' => $filename,
            'relative_path' => $relativeFilePath,
            'absolute_path' => $absolutePath,
            'size_bytes' => $fileSizeBytes,
            'size_formatted' => $this->formatBytes($fileSizeBytes),
            'database' => $databaseName,
            'connection' => $connection,
            'created_at' => Carbon::now()->toIso8601String(),
            'pruned_count' => count($prunedFiles),
            'pruned_files' => $prunedFiles,
        ];
    }

    /**
     * Generate SQL dump content according to database connection type.
     */
    protected function generateSqlDump(string $connection): string
    {
        $driver = config("database.connections.{$connection}.driver", 'mysql');

        return match ($driver) {
            'sqlite' => $this->dumpSqliteDatabase($connection),
            'mysql', 'mariadb' => $this->dumpMysqlDatabase($connection),
            default => $this->dumpViaPdo($connection),
        };
    }

    /**
     * Dump a MySQL / MariaDB database using mysqldump CLI binary if available,
     * or fallback seamlessly to native PDO SQL generator.
     */
    protected function dumpMysqlDatabase(string $connection): string
    {
        $config = config("database.connections.{$connection}");
        $host = $config['host'] ?? '127.0.0.1';
        $port = (string) ($config['port'] ?? '3306');
        $database = $config['database'] ?? '';
        $username = $config['username'] ?? 'root';
        $password = $config['password'] ?? '';

        // Attempt CLI mysqldump first if CLI binary is available
        if ($this->isCommandAvailable('mysqldump') && ! empty($database)) {
            try {
                $command = [
                    'mysqldump',
                    '--host='.$host,
                    '--port='.$port,
                    '--user='.$username,
                    '--add-drop-table',
                    '--single-transaction',
                    '--quick',
                    '--skip-comments',
                ];

                if (! empty($password)) {
                    $command[] = '--password='.$password;
                }

                $command[] = $database;

                $processResult = Process::run($command);

                if ($processResult->successful() && ! empty($processResult->output())) {
                    return $processResult->output();
                }

                Log::warning('mysqldump CLI returned error or empty output. Falling back to native PDO dumper: '.$processResult->errorOutput());
            } catch (Exception $e) {
                Log::warning('mysqldump process execution failed. Falling back to PDO dumper: '.$e->getMessage());
            }
        }

        // Reliable pure-PHP fallback
        return $this->dumpViaPdo($connection);
    }

    /**
     * Dump an SQLite database.
     */
    protected function dumpSqliteDatabase(string $connection): string
    {
        $databasePath = config("database.connections.{$connection}.database");

        if ($databasePath === ':memory:') {
            return $this->dumpViaPdo($connection);
        }

        if (file_exists($databasePath)) {
            $sqliteContent = file_get_contents($databasePath);
            if ($sqliteContent !== false) {
                return $sqliteContent;
            }
        }

        return $this->dumpViaPdo($connection);
    }

    /**
     * Pure-PHP PDO dumper that works universally on any host without requiring external binaries.
     */
    public function dumpViaPdo(string $connection): string
    {
        $conn = DB::connection($connection);
        $pdo = $conn->getPdo();
        $dbName = config("database.connections.{$connection}.database", 'database');

        $sql = "-- BaliTour Database Backup\n";
        $sql .= "-- Database: `{$dbName}`\n";
        $sql .= '-- Generated: '.Carbon::now()->toDateTimeString()."\n";
        $sql .= "SET FOREIGN_KEY_CHECKS=0;\n";
        $sql .= "SET SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO';\n";
        $sql .= "START TRANSACTION;\n\n";

        // Fetch all table names using Schema::getTableListing or connection
        $tables = Schema::connection($connection)->getTableListing();

        foreach ($tables as $table) {
            // Drop & Create Table DDL
            $sql .= "-- --------------------------------------------------------\n";
            $sql .= "-- Table structure for `{$table}`\n";
            $sql .= "-- --------------------------------------------------------\n";
            $sql .= "DROP TABLE IF EXISTS `{$table}`;\n";

            try {
                $createTableStmt = $pdo->query("SHOW CREATE TABLE `{$table}`")->fetch(PDO::FETCH_NUM);
                if (! empty($createTableStmt[1])) {
                    $sql .= $createTableStmt[1].";\n\n";
                }
            } catch (Exception) {
                // If SHOW CREATE TABLE is unsupported (e.g. SQLite), generate standard DDL if possible
                try {
                    $sqliteMaster = $pdo->query("SELECT sql FROM sqlite_master WHERE type='table' AND name='{$table}'")->fetch(PDO::FETCH_ASSOC);
                    if (! empty($sqliteMaster['sql'])) {
                        $sql .= $sqliteMaster['sql'].";\n\n";
                    }
                } catch (Exception) {
                    // Ignore non-standard fallback
                }
            }

            // Dump Table Records
            $rows = $conn->table($table)->get();
            if ($rows->isNotEmpty()) {
                $sql .= "-- Dumping data for table `{$table}`\n";

                $columns = array_keys((array) $rows->first());
                $columnList = implode('`, `', $columns);

                foreach ($rows->chunk(100) as $chunk) {
                    $valuesSql = [];
                    foreach ($chunk as $row) {
                        $rowValues = [];
                        foreach ((array) $row as $val) {
                            if (is_null($val)) {
                                $rowValues[] = 'NULL';
                            } elseif (is_numeric($val)) {
                                $rowValues[] = $val;
                            } else {
                                $rowValues[] = $pdo->quote((string) $val);
                            }
                        }
                        $valuesSql[] = '('.implode(', ', $rowValues).')';
                    }

                    $sql .= "INSERT INTO `{$table}` (`{$columnList}`) VALUES\n".implode(",\n", $valuesSql).";\n";
                }
                $sql .= "\n";
            }
        }

        $sql .= "SET FOREIGN_KEY_CHECKS=1;\n";
        $sql .= "COMMIT;\n";

        return $sql;
    }

    /**
     * Clean old backups and keep only the latest `$limit` files.
     *
     * @param  int  $limit  Maximum number of backup files to keep (default: 5)
     * @return array Deleted file names
     */
    public function cleanOldBackups(int $limit = 5): array
    {
        $files = $this->getBackups();
        $deleted = [];

        if (count($files) > $limit) {
            // $files is already sorted newest first
            $filesToDelete = array_slice($files, $limit);

            foreach ($filesToDelete as $file) {
                if (Storage::disk($this->disk)->exists($file['relative_path'])) {
                    Storage::disk($this->disk)->delete($file['relative_path']);
                    $deleted[] = $file['filename'];
                    Log::info("Pruned old backup file beyond limit of {$limit}: [{$file['filename']}].");
                }
            }
        }

        return $deleted;
    }

    /**
     * Retrieve all backup files sorted newest first.
     *
     * @return array<int, array{filename: string, relative_path: string, size_bytes: int, size_formatted: string, last_modified: int, date: string}>
     */
    public function getBackups(): array
    {
        if (! Storage::disk($this->disk)->exists($this->directory)) {
            return [];
        }

        $allFiles = Storage::disk($this->disk)->files($this->directory);
        $backups = [];

        foreach ($allFiles as $filePath) {
            if (str_ends_with($filePath, '.sql.gz') || str_ends_with($filePath, '.sql') || str_ends_with($filePath, '.sqlite')) {
                $lastModified = Storage::disk($this->disk)->lastModified($filePath);
                $size = Storage::disk($this->disk)->size($filePath);
                $filename = basename($filePath);

                $backups[] = [
                    'filename' => $filename,
                    'relative_path' => $filePath,
                    'size_bytes' => $size,
                    'size_formatted' => $this->formatBytes($size),
                    'last_modified' => $lastModified,
                    'date' => Carbon::createFromTimestamp($lastModified)->toDateTimeString(),
                ];
            }
        }

        // Sort descending by last modified timestamp (newest first)
        usort($backups, fn ($a, $b) => $b['last_modified'] <=> $a['last_modified']);

        return $backups;
    }

    /**
     * Check if a CLI command is accessible in the server environment.
     */
    protected function isCommandAvailable(string $command): bool
    {
        try {
            $testCmd = PHP_OS_FAMILY === 'Windows' ? "where {$command}" : "which {$command}";
            $result = Process::run($testCmd);

            return $result->successful();
        } catch (Exception) {
            return false;
        }
    }

    /**
     * Format bytes to human readable format.
     */
    protected function formatBytes(int $bytes, int $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= (1 << (10 * $pow));

        return round($bytes, $precision).' '.$units[$pow];
    }
}
