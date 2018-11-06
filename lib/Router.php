<?php

use Slim\App;
use Slim\Views\Blade;

$config = [
    'settings' => [
        'displayErrorDetails' => true, 
        'renderer'            => [
            'blade_template_path' => __DIR__ . '/views',
            'blade_cache_path'    => __DIR__ . '/cache', 
        ],
        'translations_path' => __DIR__ . '/lang', 
        'allowed_locales' => ['en', 'ja'],
        'default_locale' => 'ja'
    ],
];

$app = new App($config);

$container = $app->getContainer();

$container['csrf'] = function ($container) {
    return new \Slim\Csrf\Guard;
};

$container['view'] = function ($container) {
    return new Blade(
        $container['settings']['renderer']['blade_template_path'],
        $container['settings']['renderer']['blade_cache_path']
    );
};

$container['flash'] = function ($container) {
    return new \Slim\Flash\Messages();
};

$container['locale'] = function ($container) {
    return new \Symfony\Component\Translation\TranslatorInterface;
};

$app->get('/', Controller::class . ':input');
$app->post('/', Controller::class . ':input');

$app->run();

