<?php

return [
    'strategy' => [
        # String with which secrets value will be replaced
        'redaction' => '[redacted]',
        # Default strategy to load secrets
        'handler' => \Gawsoft\LaravelSecrets\Secrets\Providers\ContainerStrategy::class,

        # Config for strategy
        'config' => [
            # Default path to your secrets
            # - when you run laravel_secrets('db/password') -> Will check path /run/secrets/db/password
            # - when you run laravel_secrets('/secrets/db/password') -> Ignore default path and check /secrets/db/password and wi
            'path' => '/run/secrets/',
            # If you encrypt secret all encrypted string will start with this string.
            # This string cannot be empty!
            'encrypted_prefix' => 'encrypted:',
        ]
    ],
    // Remove from logs sensitive keys
    'logs' => [
        // When set empty whitelist array, all config values will be redacted.
        // When set min one value only this value will be redacted.
        'whitelist' => [
          //  'app.key',
          //  'mail.mailers.smtp.password',
          //  'database.connections.mysql.password'
        ],
        // Do not redact values from blacklist. Those values will show in logs
        'blacklist' => [
            'app.name',
            'logging.level',
        ],
    ]
];