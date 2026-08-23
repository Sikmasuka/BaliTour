<?php

namespace Tests\Feature;

use App\Console\Commands\BackupDatabase;
use App\Http\Middleware\CheckAutoDatabaseBackup;
use App\Jobs\RunAutoBackup;
use App\Services\BackupService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class BackupDatabaseTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->app->instance('test.auto_backup_enabled', true);
        Storage::fake('local');
        Cache::flush();
    }

    public function test_backup_service_creates_compressed_backup_in_target_directory(): void
    {
        $backupService = new BackupService('local', 'backups/db');
        $result = $backupService->runBackup(5);

        $this->assertTrue($result['success']);
        $this->assertStringEndsWith('.sql.gz', $result['filename']);
        $this->assertEquals('backups/db/' . $result['filename'], $result['relative_path']);
        
        Storage::disk('local')->assertExists($result['relative_path']);
        $content = Storage::disk('local')->get($result['relative_path']);
        $this->assertNotEmpty($content);
        
        // Decompress and verify SQL content
        $decompressed = gzdecode($content);
        $this->assertNotFalse($decompressed);
        $this->assertStringContainsString('BaliTour Database Backup', $decompressed);
    }

    public function test_backup_service_enforces_limit_of_5_and_deletes_oldest(): void
    {
        $backupService = new BackupService('local', 'backups/db');

        // Create 6 fake backup files with distinct timestamps
        for ($i = 1; $i <= 6; $i++) {
            $time = Carbon::now()->subMinutes(60 - ($i * 5))->timestamp;
            $filename = "backup_test_2026-08-23_00000{$i}.sql.gz";
            $path = "backups/db/{$filename}";
            
            Storage::disk('local')->put($path, gzencode("-- dump {$i}", 9));
            touch(Storage::disk('local')->path($path), $time);
        }

        $allBackupsBefore = $backupService->getBackups();
        $this->assertCount(6, $allBackupsBefore);

        // Prune with limit 5
        $deleted = $backupService->cleanOldBackups(5);

        $this->assertCount(1, $deleted);
        $this->assertEquals('backup_test_2026-08-23_000001.sql.gz', $deleted[0]);

        $remainingBackups = $backupService->getBackups();
        $this->assertCount(5, $remainingBackups);
        $this->assertEquals('backup_test_2026-08-23_000006.sql.gz', $remainingBackups[0]['filename']);
    }

    public function test_run_auto_backup_job_executes_backup_service_and_sets_cache(): void
    {
        $job = new RunAutoBackup(5);
        $backupService = new BackupService('local', 'backups/db');

        $job->handle($backupService);

        $this->assertNotNull(Cache::get('auto_backup:last_run_at'));
        $backups = $backupService->getBackups();
        $this->assertCount(1, $backups);
    }

    public function test_backup_database_artisan_command(): void
    {
        $this->artisan('backup:database --limit=5')
            ->expectsOutputToContain('Initiating database backup')
            ->expectsOutputToContain('Backup completed successfully!')
            ->assertExitCode(0);

        $this->assertNotNull(Cache::get('auto_backup:last_run_at'));
    }

    public function test_middleware_dispatches_job_when_backup_is_due(): void
    {
        Queue::fake();

        // No previous backup in cache -> backup is due
        $middleware = new CheckAutoDatabaseBackup();
        $request = Request::create('/admin/dashboard', 'GET');

        $response = $middleware->handle($request, function ($req) {
            return new Response('OK');
        });

        $this->assertEquals(200, $response->getStatusCode());
        Queue::assertPushed(RunAutoBackup::class, function ($job) {
            return $job->limit === 5;
        });
    }

    public function test_middleware_does_not_dispatch_job_when_backup_was_recently_created(): void
    {
        Queue::fake();

        // Set last backup to 2 hours ago (within 24 hours)
        Cache::put('auto_backup:last_run_at', Carbon::now()->subHours(2)->toDateTimeString());

        $middleware = new CheckAutoDatabaseBackup();
        $request = Request::create('/admin/dashboard', 'GET');

        $middleware->handle($request, function ($req) {
            return new Response('OK');
        });

        Queue::assertNotPushed(RunAutoBackup::class);
    }
}
