<?php
/*
 * Local configuration file to provide any overrides to your app.php configuration.
 * Copy and save this file as app_local.php and make changes as required.
 * Note: It is not recommended to commit files with credentials such as app_local.php
 * into source code version control.
 */
return [
    /*
     * Debug Level:
     *
     * Production Mode:
     * false: No error messages, errors, or warnings shown.
     *
     * Development Mode:
     * true: Errors and warnings shown.
     */
    'debug' => filter_var(env('DEBUG', true), FILTER_VALIDATE_BOOLEAN),

    /*
     * Security and encryption configuration
     *
     * - salt - A random string used in security hashing methods.
     *   The salt value is also used as the encryption key.
     *   You should treat it as extremely sensitive data.
     */
    'Security' => [
        'salt' => env('SECURITY_SALT', '__SALT__'),
    ],

    /*
     * Connection information used by the ORM to connect
     * to your application's datastores.
     *
     * See app.php for more configuration options.
     */
    'Datasources' => [
        'default' => [
            'host' => 'localhost',
            'username' => getenv('DB_USERNAME'),
            'password' => getenv('DB_PASSWORD'),
            'database' => 'webapp_cake',
            'driver' => 'Cake\Database\Driver\Mysql',
            'port' => '3306'
        ],

        /*
         * The test connection is used during the test suite.
         */
        'test' => [
            'host' => 'localhost',
            //'port' => 'non_standard_port_number',
            'username' => 'my_app',
            'password' => 'secret',
            'database' => 'test_myapp',
            //'schema' => 'myapp',
            'url' => env('DATABASE_TEST_URL', 'sqlite://127.0.0.1/tmp/tests.sqlite'),
        ],
    ],

    /*
     * Email configuration.
     *
     * Host and credential configuration in case you are using SmtpTransport
     *
     * See app.php for more configuration options.
     */
    'EmailTransport' => [
        'default' => [
            'className' => 'Smtp',
            'host' => 'smtp.mailgun.org',
            'port' => 587,
            'username' => 'postmaster@sandboxb7fe04c41fb94359a12af4667e209fb3.mailgun.org',
            'password' => '2761449a9d3a732c91e6b1f30a46784e-f55d7446-42fe8ecd',
            'tls' => true,
            'client' => null,
        ],
    ],
    'Email' => [
        'default' => [
            'transport' => 'default',
            'from' => ['postmaster@sandboxb7fe04c41fb94359a12af4667e209fb3.mailgun.org' => 'WebAPP'],
        ],
    ],
];
