<?php

require __DIR__ . '/../vendor/autoload.php';

try {
    (new Dotenv\Dotenv(__DIR__ . '/../'))->load();
} catch (Dotenv\Exception\InvalidPathException $e) {
    //
}

$app = new \Slim\App([
    'settings' => [
        'displayErrorDetails' => getenv('APP_DEBUG') === 'true',
        'determineRouteBeforeAppMiddleware' => false,
        'app' => [
            'name' => getenv('APP_NAME')
        ],
        'views' => [
            'cache' => getenv('VIEW_CACHE_DISABLED') === 'true' ? false : __DIR__ . '/../storage/views'
        ],
        'mail' => [
            'host' => getenv('MAIL_HOST'),
            'port' => getenv('MAIL_PORT'),
            'from' => [
                'name' => getenv('MAIL_FROM_NAME'),
                'address' => getenv('MAIL_FROM_ADDRESS')
            ],
            'username' => getenv('MAIL_USERNAME'),
            'password' => getenv('MAIL_PASSWORD')
        ],
        'db' => [
            'driver' => getenv('DB_DRIVER'),
            'host' => getenv('DB_HOST'),
            'database' => getenv('DB_NAME'),
            'username' => getenv('DB_USER'),
            'password' => getenv('DB_PASSWORD'),
            'charset'   => getenv('DB_CHARSET', 'utf8'),
            'collation' => getenv('DB_COLLATION', 'utf8_unicode_ci'),
            'prefix'    => getenv('DB_PREFIX', ''),
        ]
    ]
]);

require __DIR__ . '/container.php';

$kernel = new \App\Http\Kernel($app);
$kernel->boot();
