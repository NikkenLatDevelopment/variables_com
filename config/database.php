<?php

use Illuminate\Support\Str;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the database connections below you wish
    | to use as your default connection for all database work. Of course
    | you may use many connections at once using the Database library.
    |
    */

    'default' => env('DB_CONNECTION', 'mysql'),

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the database connections setup for your application.
    | Of course, examples of configuring each database platform that is
    | supported by Laravel is shown below to make development simple.
    |
    |
    | All database work in Laravel is done through the PHP PDO facilities
    | so make sure you have the driver for your particular database of
    | choice installed on your machine before you begin development.
    |
    */

    'connections' => [

        'sqlite' => [
            'driver' => 'sqlite',
            'url' => env('DATABASE_URL'),
            'database' => env('DB_DATABASE', database_path('database.sqlite')),
            'prefix' => '',
            'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),
        ],

        'mysql' => [
            'driver' => 'mysql',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
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
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '5432'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'search_path' => 'public',
            'sslmode' => 'prefer',
        ],

        'sqlsrv' => [
            'driver' => 'sqlsrv',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', 'localhost'),
            'port' => env('DB_PORT', '1433'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            // 'encrypt' => env('DB_ENCRYPT', 'yes'),
            // 'trust_server_certificate' => env('DB_TRUST_SERVER_CERTIFICATE', 'false'),
        ],

        'nikkenla_office' => [
            'driver' => 'mysql',
            'url' => env('DATABASE_URL_OFFICE'),
            'host' => env('DB_HOST_OFFICE', '127.0.0.1'),
            'port' => env('DB_PORT_OFFICE', '3306'),
            'database' => env('DB_DATABASE_OFFICE', 'forge'),
            'username' => env('DB_USERNAME_OFFICE', 'forge'),
            'password' => env('DB_PASSWORD_OFFICE', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'SQL173' => [
            'driver' => 'sqlsrv',
            'host' => env('DB_HOST_SQL173', 'localhost'),
            'port' => env('DB_PORT_SQL173', '1433'),
            'database' => env('DB_DATABASE_SQL173', 'forge'),
            'username' => env('DB_USERNAME_SQL173', 'forge'),
            'password' => env('DB_PASSWORD_SQL173', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'trust_server_certificate' => true
        ],

        'SQL170' => [
            'driver' => 'sqlsrv',
            'host' => env('DB_HOST_170', 'localhost'),
            'port' => env('DB_PORT_170', '1433'),
            'database' => env('DB_DATABASE_170', 'forge'),
            'username' => env('DB_USERNAME_170', 'forge'),
            'password' => env('DB_PASSWORD_170', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'trust_server_certificate' => true
        ],

        'SQL165' => [
            'driver' => 'sqlsrv',
            'host' => env('DB_HOST_165', 'localhost'),
            'port' => env('DB_PORT_165', '1433'),
            'database' => env('DB_DATABASE_165', 'forge'),
            'username' => env('DB_USERNAME_165', 'forge'),
            'password' => env('DB_PASSWORD_165', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'trust_server_certificate' => true
        ],

        'SQL167' => [
            'driver' => 'sqlsrv',
            'host' => env('DB_HOST_167', 'localhost'),
            'port' => env('DB_PORT_167', '1433'),
            'database' => env('DB_DATABASE_167', 'forge'),
            'username' => env('DB_USERNAME_167', 'forge'),
            'password' => env('DB_PASSWORD_167', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'trust_server_certificate' => true
        ],

        'SQL164' => [
            'driver' => 'sqlsrv',
            'host' => env('DB_HOST_164', 'localhost'),
            'port' => env('DB_PORT_164', '1433'),
            'database' => env('DB_DATABASE_164', 'forge'),
            'username' => env('DB_USERNAME_164', 'forge'),
            'password' => env('DB_PASSWORD_164', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'trust_server_certificate' => true
        ],

        'SQLPAN' => [
            'driver' => 'sqlsrv',
            'host' => env('DB_HOST_PAN', 'localhost'),
            'port' => env('DB_PORT_PAN', '1433'),
            'database' => env('DB_DATABASE_PAN', 'forge'),
            'username' => env('DB_USERNAME_PAN', 'forge'),
            'password' => env('DB_PASSWORD_PAN', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'trust_server_certificate' => true
        ],

        'SQL166' => [
            'driver' => 'sqlsrv',
            'host' => env('DB_HOST_166', 'localhost'),
            'port' => env('DB_PORT_166', '1433'),
            'database' => env('DB_DATABASE_166', 'forge'),
            'username' => env('DB_USERNAME_166', 'forge'),
            'password' => env('DB_PASSWORD_166', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'trust_server_certificate' => true
        ],

        'SQLGTM' => [
            'driver' => 'sqlsrv',
            'host' => env('DB_HOST_GTM', 'localhost'),
            'port' => env('DB_PORT_GTM', '1433'),
            'database' => env('DB_DATABASE_GTM', 'forge'),
            'username' => env('DB_USERNAME_GTM', 'forge'),
            'password' => env('DB_PASSWORD_GTM', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'trust_server_certificate' => true
        ],

        'SQLSLV' => [
            'driver' => 'sqlsrv',
            'host' => env('DB_HOST_SLV', 'localhost'),
            'port' => env('DB_PORT_SLV', '1433'),
            'database' => env('DB_DATABASE_SLV', 'forge'),
            'username' => env('DB_USERNAME_SLV', 'forge'),
            'password' => env('DB_PASSWORD_SLV', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'trust_server_certificate' => true
        ],
        
        'SQLPER' => [
            'driver' => 'sqlsrv',
            'host' => env('DB_HOST_163', 'localhost'),
            'port' => env('DB_PORT_163', '1433'),
            'database' => env('DB_DATABASE_163', 'forge'),
            'username' => env('DB_USERNAME_163', 'forge'),
            'password' => env('DB_PASSWORD_163', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'trust_server_certificate' => true
        ],
        
        'SQLCHL' => [
            'driver' => 'sqlsrv',
            'host' => env('DB_HOST_CHL', 'localhost'),
            'port' => env('DB_PORT_CHL', '1433'),
            'database' => env('DB_DATABASE_CHL', 'forge'),
            'username' => env('DB_USERNAME_CHL', 'forge'),
            'password' => env('DB_PASSWORD_CHL', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'trust_server_certificate' => true
        ],
        
        'SQL163' => [
            'driver' => 'sqlsrv',
            'host' => env('DB_HOST_163', 'localhost'),
            'port' => env('DB_PORT_163', '1433'),
            'database' => env('DB_DATABASE_163', 'forge'),
            'username' => env('DB_USERNAME_163', 'forge'),
            'password' => env('DB_PASSWORD_163', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'trust_server_certificate' => true
        ],
        
        'SQL164' => [
            'driver' => 'sqlsrv',
            'host' => env('DB_HOST_164', 'localhost'),
            'port' => env('DB_PORT_164', '1433'),
            'database' => env('DB_DATABASE_164', 'forge'),
            'username' => env('DB_USERNAME_164', 'forge'),
            'password' => env('DB_PASSWORD_164', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'trust_server_certificate' => true
        ],

        'SQL73' => [
            'driver' => 'sqlsrv',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST_SQL73', 'localhost'),
            'port' => env('DB_PORT_SQL73', '1433'),
            'database' => env('DB_DATABASE_SQL73', 'forge'),
            'username' => env('DB_USERNAME_SQL73', 'forge'),
            'password' => env('DB_PASSWORD_SQL73', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'trust_server_certificate' => true,
            'options' => [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_SILENT,
            ]
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    |
    | This table keeps track of all the migrations that have already run for
    | your application. Using this information, we can determine which of
    | the migrations on disk haven't actually been run in the database.
    |
    */

    'migrations' => 'migrations',

    /*
    |--------------------------------------------------------------------------
    | Redis Databases
    |--------------------------------------------------------------------------
    |
    | Redis is an open source, fast, and advanced key-value store that also
    | provides a richer body of commands than a typical key-value system
    | such as APC or Memcached. Laravel makes it easy to dig right in.
    |
    */

    'redis' => [

        'client' => env('REDIS_CLIENT', 'phpredis'),

        'options' => [
            'cluster' => env('REDIS_CLUSTER', 'redis'),
            'prefix' => env('REDIS_PREFIX', Str::slug(env('APP_NAME', 'laravel'), '_').'_database_'),
        ],

        'default' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'username' => env('REDIS_USERNAME'),
            'password' => env('REDIS_PASSWORD'),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_DB', '0'),
        ],

        'cache' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'username' => env('REDIS_USERNAME'),
            'password' => env('REDIS_PASSWORD'),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_CACHE_DB', '1'),
        ],

    ],

];
