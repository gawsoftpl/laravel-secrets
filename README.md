# Laravel Secrets
A Laravel package with 2 main functions:
1. Remove secrets from Logs. Prevent from secrets being leaked in logs.
2. Load kubernetes/docker secrets from file


# Demo & Usage

### 1. Remove secrets from Logs
Without laravel-secrets. secretpassword leaked in log
```
[2022-07-20 16:11:34] local.NOTICE: This is a notice level message.
[2022-07-20 16:11:34] local.ALERT: Can't connect with https://login:secretpassword@example.com
```
With laravel-secrets, secretpassword is redacted before send log
```
[2022-07-20 16:11:34] local.NOTICE: This is a notice level message.
[2022-07-20 16:11:34] local.ALERT: Can't connect with https://login:[redacted]@example.com
```

### 2. Read secret from file.
```php
return [
    'connections' => [
        'mysql' => [
            'driver' => 'mysql',
            'port' => env('DB_PORT', '3306'),
            'username' => laravel_secrets('/run/secrets/db/username', env('DB_USERNAME')),
            'password' => laravel_secrets('db/password', env('DB_PASSWORD')),
        ],
]
```

# Minimum requirements
- PHP 8.0
- Laravel 8.0

# Installation
```sh
composer require gawsoft/laravel-secrets
```

Install package assets
```
php artisan vendor:publish --provider="Gawsoft\LaravelSecrets\LaravelSecretsServiceProvider"
```

# Configuration

Example config/secrets.php:

```php
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
            # - when you run laravel_secrets('/secrets/db/password') -> Ignore default path and check /secrets/db/password
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
        'blacklist' => [
            'app.name',
            'logging.level',
        ],
    ]
];
```


## 1. Read secrets from file
When you install laravel in docker or kubernetes for security reason your devops team inject secrets to file in the container. 
This package will read this secret with function laravel_secrets. 

```php
laravel_secrets('<PATH-TO-FILE>', '<DEFAULT-VALUE>');
```
## 2. Read encrypted secrets from file
You can also encrypt secrets with Laravel App Key and auto encrypt after loaded encrypted string to Laravel config.
```sh
# Encrypt password by artisan command
echo "abc" > /tmp/password
cat /tmp/password | php artisan laravel-secrets:encrypt --stdin

# Decrypt password
echo "encrypted:eyJpdiI6InhQbEhUREJQa21mcW85M0tYSEhhOUE9PSIsInZhbHVlIjoiY2pXZ0lqUlY4YVoydDdyZzVHak9XUT09IiwibWFjIjoiMWFlZjA4MGIyN2Q2YmEwMzc4ZGNjNTYzYTgyOTNiMzFiOWM0OTVmZWFkNGYzZTFiNDAwM2Y1NzgyYWJlMDEwMCIsInRhZyI6IiJ9" > /tmp/encrypted
cat /tmp/encrypted | php artisan laravel-secrets:decrypt --stdin
```

## 3. Remove secrets from Logs
During logs process in Laravel my package will remove sensitive data from log message. 
**Default will remove all values saved in all configs**.
You can change this options in config/secrets.php via set whitelist and blacklist.

```php
#config/secrets.php
return [
    // Remove sensitive keys from logs 
    'logs' => [
        // When set empty whitelist array, all config values will be redacted.
        // When set min one value only this value will be redacted.
        'whitelist' => [
          //  'app.key',
          //  'mail.mailers', # Alle mailers secrets will be redacted
          //  'database.connections.mysql.password'
        ],
        // Do not redact values from blacklist. Those values will show in logs
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

# RoadMap
- Add Strategy for AWS Secret Manager
- Add Strategy for Hashicorp Vault

# How to write new strategy
1. Create new file LaravelSecrets\Secrets\Providers\MySecretProvider.php
2. Write your driver
```php
<?php

namespace MyCompany\MyPackage\LaravelSecrets\Secrets\Providers\MySecretProvider;

use Gawsoft\LaravelSecrets\Abstracts\SecretsProviderAbstract;
use Gawsoft\LaravelSecrets\Interfaces\SecretProviderInterface;


class ContainerStrategy extends SecretsProviderAbstract implements SecretProviderInterface
{
    function getSecret(string $name): string | null
    {
        // Get secret from your source
    }

}
```
3. Register as default strategy in configs/secrets.php
```php
return [
    'strategy' => [
        ...
        'handler' => \MyCompany\MyPackage\LaravelSecrets\Secrets\Providers\MySecretProvider::class,
        ...
    ]
```

# License
MIT

