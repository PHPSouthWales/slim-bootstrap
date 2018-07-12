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

$container = $app->getContainer();

$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig(__DIR__ . '/../resources/views', [
        'cache' => $container->settings['views']['cache']
    ]);
    $basePath = rtrim(str_ireplace('index.php', '', $container['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new Slim\Views\TwigExtension($container['router'], $basePath));

    return $view;
};

$container['mail'] = function ($container) {
    $config = $container->settings['mail'];

    $transport = (new Swift_SmtpTransport($config['host'], $config['port']))
        ->setUsername($config['username'])
        ->setPassword($config['password']);

    $swift = new Swift_Mailer($transport);

    return (new \App\Mail\Mailer\Mailer($swift, $container->view))
        ->alwaysFrom($config['from']['address'], $config['from']['name']);
};

$container['db'] = function ($container) {
    $capsule = new \Illuminate\Database\Capsule\Manager;
    $capsule->addConnection($container['settings']['db']);

    $capsule->setAsGlobal();
    $capsule->bootEloquent();

    return $capsule;
};
