<?php

namespace App\Jobs;

use App\Services\BackupService;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class RunAutoBackup implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Maximum number of retries for the job.
     */
    public int $tries = 2;

    /**
     * The number of seconds the job can run before timing out.
     */
    public int $timeout = 300;

    /**
     * The maximum number of backup files to retain.
     */
    public int $limit;

    /**
     * Create a new job instance.
     */
    public function __construct(int $limit = 5)
    {
        $this->limit = $limit;
    }

    /**
     * Execute the backup job asynchronously.
     */
    public function handle(BackupService $backupService): void
    {
        try {
            Log::info("AutoBackup job started. Retention limit: {$this->limit} backups.");

            $result = $backupService->runBackup($this->limit);

            // Record successful completion timestamp
            Cache::forever('auto_backup:last_run_at', now()->toDateTimeString());

            Log::info("AutoBackup job completed successfully. File: {$result['filename']} ({$result['size_formatted']}).");
        } catch (Exception $e) {
            Log::error('AutoBackup job failed: '.$e->getMessage(), [
                'exception' => $e,
            ]);

            throw $e;
        }
    }
}
