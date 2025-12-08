<?php

use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Support parsing DATABASE_URL (Railway / external providers)
|--------------------------------------------------------------------------
|
| If a `DATABASE_URL` (or `DB_URL`) is provided by the platform (Railway
| often provides a database URL), parse it here and use its components to
| populate the Laravel DB connection values. This allows you to set a single
| `DATABASE_URL` env var in Render rather than individual DB_HOST/DB_USER
| vars. Secondary connections (like `DB_DUTY_URL`) are supported similarly.
|
*/

$parsedDb = [];
$databaseUrl = env('DATABASE_URL') ?: env('DB_URL');
if ($databaseUrl) {
    $parts = parse_url($databaseUrl);
    if ($parts !== false) {
        $parsedDb['host'] = $parts['host'] ?? null;
        $parsedDb['port'] = isset($parts['port']) ? (string) $parts['port'] : null;
        $parsedDb['database'] = isset($parts['path']) ? ltrim($parts['path'], '/') : null;
        $parsedDb['username'] = $parts['user'] ?? null;
        $parsedDb['password'] = $parts['pass'] ?? null;
    }
}

$parsedDutyDb = [];
$dutyDatabaseUrl = env('DB_DUTY_URL');
if ($dutyDatabaseUrl) {
    $parts = parse_url($dutyDatabaseUrl);
    if ($parts !== false) {
        $parsedDutyDb['host'] = $parts['host'] ?? null;
        $parsedDutyDb['port'] = isset($parts['port']) ? (string) $parts['port'] : null;
        $parsedDutyDb['database'] = isset($parts['path']) ? ltrim($parts['path'], '/') : null;
        $parsedDutyDb['username'] = $parts['user'] ?? null;
        $parsedDutyDb['password'] = $parts['pass'] ?? null;
    }
}

return [

    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the database connections below you wish
    | to use as your default connection for database operations. This is
    | the connection which will be utilized unless another connection
    | is explicitly specified when you execute a query / statement.
    |
    */

    'default' => env('DB_CONNECTION', 'sqlite'),

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Below are all of the database connections defined for your application.
    | An example configuration is provided for each database system which
    | is supported by Laravel. You're free to add / remove connections.
    |
    */

    'connections' => [
        'mysql' => [
            'driver' => 'mysql',
            'url' => env('DB_URL') ?: env('DATABASE_URL'),
            'host' => $parsedDb['host'] ?? env('DB_HOST', '127.0.0.1'),
            'port' => $parsedDb['port'] ?? env('DB_PORT', '3306'),
            'database' => $parsedDb['database'] ?? env('DB_DATABASE', 'forge'),
            'username' => $parsedDb['username'] ?? env('DB_USERNAME', 'forge'),
            'password' => $parsedDb['password'] ?? env('DB_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : []
        ],

        'duty' => [
            'driver' => 'mysql',
            'url' => env('DB_DUTY_URL'),
            'host' => $parsedDutyDb['host'] ?? env('DB_DUTY_HOST', '127.0.0.1'),
            'port' => $parsedDutyDb['port'] ?? env('DB_DUTY_PORT', '3306'),
            'database' => $parsedDutyDb['database'] ?? env('DB_DUTY_DATABASE', 'plvshield_duty'),
            'username' => $parsedDutyDb['username'] ?? env('DB_DUTY_USERNAME', 'forge'),
            'password' => $parsedDutyDb['password'] ?? env('DB_DUTY_PASSWORD', ''),
            'unix_socket' => env('DB_DUTY_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : []
        ],
        
        'mariadb' => [
            'driver' => 'mariadb',
            'url' => env('DB_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'laravel'),
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => env('DB_CHARSET', 'utf8mb4'),
            'collation' => env('DB_COLLATION', 'utf8mb4_unicode_ci'),
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'pgsql' => [
            'driver' => 'pgsql',
            'url' => env('DB_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '5432'),
            'database' => env('DB_DATABASE', 'laravel'),
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => env('DB_CHARSET', 'utf8'),
            'prefix' => '',
            'prefix_indexes' => true,
            'search_path' => 'public',
            'sslmode' => 'prefer',
        ],

        'sqlsrv' => [
            'driver' => 'sqlsrv',
            'url' => env('DB_URL'),
            'host' => env('DB_HOST', 'localhost'),
            'port' => env('DB_PORT', '1433'),
            'database' => env('DB_DATABASE', 'laravel'),
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => env('DB_CHARSET', 'utf8'),
            'prefix' => '',
            'prefix_indexes' => true
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    |
    | This table keeps track of all the migrations that have already run for
    | your application. Using this information, we can determine which of
    | the migrations on disk haven't actually been run on the database.
    |
    */

    'migrations' => [
        'table' => 'migrations',
        'update_date_on_publish' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Redis Databases
    |--------------------------------------------------------------------------
    |
    | Redis is an open source, fast, and advanced key-value store that also
    | provides a richer body of commands than a typical key-value system
    | such as Memcached. You may define your connection settings here.
    |
    */

    'redis' => [

        'client' => env('REDIS_CLIENT', 'phpredis'),

        'options' => [
            'cluster' => env('REDIS_CLUSTER', 'redis'),
            'prefix' => env('REDIS_PREFIX', Str::slug((string) env('APP_NAME', 'laravel')).'-database-'),
            'persistent' => env('REDIS_PERSISTENT', false),
        ],

        'default' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'username' => env('REDIS_USERNAME'),
            'password' => env('REDIS_PASSWORD'),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_DB', '0'),
            'max_retries' => env('REDIS_MAX_RETRIES', 3),
            'backoff_algorithm' => env('REDIS_BACKOFF_ALGORITHM', 'decorrelated_jitter'),
            'backoff_base' => env('REDIS_BACKOFF_BASE', 100),
            'backoff_cap' => env('REDIS_BACKOFF_CAP', 1000),
        ],

        'cache' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'username' => env('REDIS_USERNAME'),
            'password' => env('REDIS_PASSWORD'),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_CACHE_DB', '1'),
            'max_retries' => env('REDIS_MAX_RETRIES', 3),
            'backoff_algorithm' => env('REDIS_BACKOFF_ALGORITHM', 'decorrelated_jitter'),
            'backoff_base' => env('REDIS_BACKOFF_BASE', 100),
            'backoff_cap' => env('REDIS_BACKOFF_CAP', 1000),
        ],

    ],

];
