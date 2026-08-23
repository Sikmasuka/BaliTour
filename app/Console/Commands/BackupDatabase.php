<?php

namespace App\Console\Commands;

use App\Services\BackupService;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class BackupDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup:database
                            {--limit=5 : Maximum number of backup files to retain}
                            {--force : Force backup execution regardless of cache interval}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a compressed database backup and prune backups exceeding the limit (default: 5)';

    /**
     * Execute the console command.
     */
    public function handle(BackupService $backupService): int
    {
        $limit = (int) $this->option('limit');
        if ($limit < 1) {
            $limit = 5;
        }

        $this->info("Initiating database backup (Retention limit: {$limit} backups)...");

        try {
            $result = $backupService->runBackup($limit);

            // Update last backup timestamp
            Cache::forever('auto_backup:last_run_at', now()->toDateTimeString());

            $this->newLine();
            $this->info('✔ Backup completed successfully!');
            $this->table(
                ['Attribute', 'Details'],
                [
                    ['Database', $result['database']],
                    ['Connection', $result['connection']],
                    ['Filename', $result['filename']],
                    ['Relative Path', $result['relative_path']],
                    ['Size', $result['size_formatted']],
                    ['Created At', $result['created_at']],
                    ['Pruned Backups', $result['pruned_count']],
                ]
            );

            // Display current backup list
            $existingBackups = $backupService->getBackups();
            if (! empty($existingBackups)) {
                $this->newLine();
                $this->info('Current Retained Backups ('.count($existingBackups)."/{$limit}):");

                $rows = array_map(function ($backup, $index) {
                    return [
                        $index + 1,
                        $backup['filename'],
                        $backup['size_formatted'],
                        $backup['date'],
                    ];
                }, $existingBackups, array_keys($existingBackups));

                $this->table(['#', 'Filename', 'Size', 'Date Created'], $rows);
            }

            return Command::SUCCESS;
        } catch (Exception $e) {
            $this->error('✘ Backup failed: '.$e->getMessage());

            return Command::FAILURE;
        }
    }
}
