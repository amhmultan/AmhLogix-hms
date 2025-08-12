<?php

return [

    'backup' => [

        /*
         * Application name for backup identification.
         */
        'name' => env('APP_NAME', 'laravel-backup'),

        'source' => [

            'files' => [
                /*
                 * Directories/files to include in the backup.
                 */
                'include' => [
                    base_path(),
                ],

                /*
                 * Directories/files to exclude from the backup.
                 */
                'exclude' => [
                    base_path('vendor'),
                    base_path('node_modules'),
                ],

                'follow_links' => false,
                'ignore_unreadable_directories' => false,
                'relative_path' => null,
            ],

            /*
             * Database connections to back up.
             */
            'databases' => [
                'mysql',
            ],
        ],

        /*
         * Path to the folder where the mysqldump executable is located.
         * Note: This should be a folder path, NOT the executable itself.
         * Use double backslashes \\ on Windows.
         */
        'database_dump_command_path' => 'C:\\laragon\\bin\\mysql\\mysql-8.4.3-winx64\\bin',

        /*
         * Database dump compressor (null disables compression).
         */
        'database_dump_compressor' => null,

        /*
         * File extension for the database dump files.
         */
        'database_dump_file_extension' => '',

        /*
         * Destination disk and filename prefix.
         */
        'destination' => [
            'filename_prefix' => '',
            'disks' => [
                'local',
            ],
        ],

        /*
         * Temporary directory used during backup.
         */
        'temporary_directory' => storage_path('app/backup-temp'),

        /*
         * Password for archive encryption, null disables encryption.
         */
        'password' => env('BACKUP_ARCHIVE_PASSWORD'),

        /*
         * Encryption algorithm to use for archives.
         */
        'encryption' => 'default',
    ],

    'notifications' => [

        'notifications' => [
            \Spatie\Backup\Notifications\Notifications\BackupHasFailedNotification::class => ['mail'],
            \Spatie\Backup\Notifications\Notifications\UnhealthyBackupWasFoundNotification::class => ['mail'],
            \Spatie\Backup\Notifications\Notifications\CleanupHasFailedNotification::class => ['mail'],
            \Spatie\Backup\Notifications\Notifications\BackupWasSuccessfulNotification::class => ['mail'],
            \Spatie\Backup\Notifications\Notifications\HealthyBackupWasFoundNotification::class => ['mail'],
            \Spatie\Backup\Notifications\Notifications\CleanupWasSuccessfulNotification::class => ['mail'],
        ],

        'notifiable' => \Spatie\Backup\Notifications\Notifiable::class,

        'mail' => [
            'to' => env('BACKUP_NOTIFICATION_MAIL_TO', 'your-email@example.com'),

            'from' => [
                'address' => env('MAIL_FROM_ADDRESS', 'hello@example.com'),
                'name' => env('MAIL_FROM_NAME', 'Example'),
            ],
        ],

        'slack' => [
            'webhook_url' => '',
            'channel' => null,
            'username' => null,
            'icon' => null,
        ],

        'discord' => [
            'webhook_url' => '',
            'username' => null,
            'avatar_url' => null,
        ],
    ],

    'monitor_backups' => [
        [
            'name' => env('APP_NAME', 'laravel-backup'),
            'disks' => ['local'],
            'health_checks' => [
                \Spatie\Backup\Tasks\Monitor\HealthChecks\MaximumAgeInDays::class => 1,
                \Spatie\Backup\Tasks\Monitor\HealthChecks\MaximumStorageInMegabytes::class => 5000,
            ],
        ],
    ],

    'cleanup' => [
        'strategy' => \Spatie\Backup\Tasks\Cleanup\Strategies\DefaultStrategy::class,

        'default_strategy' => [
            'keep_all_backups_for_days' => 7,
            'keep_daily_backups_for_days' => 16,
            'keep_weekly_backups_for_weeks' => 8,
            'keep_monthly_backups_for_months' => 4,
            'keep_yearly_backups_for_years' => 2,
            'delete_oldest_backups_when_using_more_megabytes_than' => 5000,
        ],
    ],

];
