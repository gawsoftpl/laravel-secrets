# Laravel Secrets
A Laravel package for:
- Load kubernetes/docker secrets from file
- Remove secrets from Logs. Prevent from secrets being leaked in logs.

# Installation
```sh
composer require gawsoft/laravel-secrets
```

Install package assets
```
php artisan vendor:publish --provider="Gawsoft\LaravelSecrets\LaravelSecretsServiceProvider"
```

# Configuration
```php
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
        // Do not redacted below values
        'blacklist' => [
            'app.name',
            'logging.level',
        ],
    ]
];
```

# Usage
```php
return [
    'connections' => [
        'mysql' => [
            'driver' => 'mysql',
            'port' => env('DB_PORT', '3306'),
            'username' => laravel_secrets('db/username', env('DB_USERNAME')),
            'password' => laravel_secrets('db/password', env('DB_PASSWORD')),
        ],
]
```

## 1. Read secrets from file
When you install laravel in docker or kubernetes for security reason your devops team inject secrets to file in the container. 
This package will read this secret with function laravel_secrets. 

```php
laravel_secrets('<PATH-TO-FILE>', '<DEFAULT-VALUE>');
```
## 2. Read encrypted secrets from file
You can also encrypt secrets with Laravel App key and encrypt during run
```sh
# Encrypt password
echo "abc" > /tmp/password
cat /tmp/password | php artisan laravel-secret:encrypt

# Decrypt password
php artisan laravel-secret:decrypt encrypted:eyJpdiI6InhQbEhUREJQa21mcW85M0tYSEhhOUE9PSIsInZhbHVlIjoiY2pXZ0lqUlY4YVoydDdyZzVHak9XUT09IiwibWFjIjoiMWFlZjA4MGIyN2Q2YmEwMzc4ZGNjNTYzYTgyOTNiMzFiOWM0OTVmZWFkNGYzZTFiNDAwM2Y1NzgyYWJlMDEwMCIsInRhZyI6IiJ9
```

## 3. Remove secrets from Logs
During process logs in Laravel my package will remove sensitive data from log message. 
**Default will remove all values saved in all configs**.
You can change this options in config/secrets.php.

```php
#config/secrets.php
return [
    // Remove sensitive keys from logs 
    'logs' => [
        // When set empty whitelist array, all config values will be redacted.
        // When set min one value only this value will be redacted.
        'whitelist' => [
          //  'app.key',
          //  'mail.mailers.smtp.password',
          //       'database.connections.mysql.password'
        ],
        'blacklist' => [
            'app.name',
            'logging.level',
        ],
    ]
];


```
# Tests
```sh
composer test
```