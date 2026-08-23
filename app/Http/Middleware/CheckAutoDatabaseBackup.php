<?php

namespace App\Http\Middleware;

use App\Jobs\RunAutoBackup;
use Carbon\Carbon;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class CheckAutoDatabaseBackup
{
    /**
     * Cache key storing the last successful or initiated backup datetime.
     */
    public const LAST_BACKUP_CACHE_KEY = 'auto_backup:last_run_at';

    /**
     * Cache lock key preventing duplicate job dispatches.
     */
    public const BACKUP_LOCK_KEY = 'auto_backup:lock';

    /**
     * Backup retention limit (default: 5).
     */
    public const BACKUP_LIMIT = 5;

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $this->checkAndTriggerAutoBackup();

        return $next($request);
    }

    /**
     * Check if a backup is due (e.g. once per day) and trigger the async job atomically.
     */
    protected function checkAndTriggerAutoBackup(): void
    {
        // Avoid background job execution during unrelated test suites unless explicitly enabled
        if (app()->runningUnitTests() && !app()->bound('test.auto_backup_enabled')) {
            return;
        }

        try {
            $lastBackup = Cache::get(self::LAST_BACKUP_CACHE_KEY);

            $isDue = false;

            if (empty($lastBackup)) {
                $isDue = true;
            } else {
                try {
                    $lastBackupTime = Carbon::parse($lastBackup);
                    // Due if last backup is older than 1 day (24 hours)
                    $isDue = $lastBackupTime->addDay()->isPast();
                } catch (Exception) {
                    $isDue = true;
                }
            }

            if ($isDue) {
                // Acquire an atomic cache lock for 10 minutes to prevent race conditions during concurrent requests
                $lock = Cache::lock(self::BACKUP_LOCK_KEY, 600);

                if ($lock->get()) {
                    // Update cache placeholder temporarily so concurrent workers/requests don't queue multiple jobs
                    Cache::put(self::LAST_BACKUP_CACHE_KEY, now()->toDateTimeString(), now()->addHours(24));

                    // Dispatch async backup job with 5-backup retention limit
                    RunAutoBackup::dispatch(self::BACKUP_LIMIT);
                }
            }
        } catch (Exception) {
            // Silently ignore check errors during request lifecycle
        }
    }
}
