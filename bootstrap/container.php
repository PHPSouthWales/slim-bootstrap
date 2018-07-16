<?php

$container = $app->getContainer();

$container['config'] = function () {
    return new \Noodlehaus\Config(__DIR__ . '/../config');
};

$container['translator'] = function ($container) {
    $config = $container->config;

    $translator = new \Symfony\Component\Translation\Translator(
        $config->get('app.locale')
    );
    $translator->setFallbackLocales([$config->get('app.default_locale')]);
    $translator->addLoader('array', new \Symfony\Component\Translation\Loader\ArrayLoader);

    $finder = new \Symfony\Component\Finder\Finder;
    $langDirs = $finder->directories()->ignoreUnreadableDirs()->in(__DIR__ . '/../resources/lang');

    array_map(function ($dir) {
        $translator->addResource(
            'array',
            (new \Noodlehaus\Config($dir))->all(),
            $dir->getRelativePathName()
        );
    }, $langDirs);

    return $translator;
};

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
