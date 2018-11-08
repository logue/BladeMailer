<?php
/**
 * 初期クラス.
 *
 * @author    Logue <logue@hotmail.co.jp>
 * @copyright 2018 Logue
 * @license   MIT
 */
use Illuminate\Filesystem\Filesystem;
use Illuminate\Translation\FileLoader;
use Illuminate\Translation\Translator;
use Interop\Container\ContainerInterface;
use Slim\App;
use Slim\Views\Blade;

$config = [
    'settings' => [
        'debug'               => true,
        'displayErrorDetails' => true,
        'renderer'            => [
            'blade_template_path' => __DIR__.'/views',
            'blade_cache_path'    => __DIR__.'/cache',
        ],
        'translations_path' => __DIR__.'/lang',
        'allowed_locales'   => ['en', 'ja'],
        'default_locale'    => 'ja',
    ],
];

$app = new App($config);

// コンテナ設定
$container = $app->getContainer();
// CSRF対策
$container['csrf'] = function (ContainerInterface $container) {
    return new \Slim\Csrf\Guard();
};
// Blade設定
$container['view'] = function (ContainerInterface $container) {
    return new Blade(
        $container['settings']['renderer']['blade_template_path'],
        $container['settings']['renderer']['blade_cache_path']
    );
};
// フラッシュメッセージ
$container['flash'] = function (ContainerInterface $container) {
    return new \Slim\Flash\Messages();
};
// 多言語化
$container['translator'] = function (ContainerInterface $container) {
    $loader = new FileLoader(new Filesystem(), $container->get('settings')['translations_path']);
    $settings = $container->get('settings');
    $translator = new Translator($loader, $settings['default_locale']);

    return $translator;
};
// エラーハンドリング
if ($container->get('settings')['debug']) {
    // ob_start前のエラーをハンドルする
    $whoops = new Whoops\Run();
    $whoops->pushHandler(new Whoops\Handler\PrettyPageHandler());
    $whoops->register();
    // ob_start以降のエラーをハンドルする
    $container['phpErrorHandler'] = $container['errorHandler'] = function ($c) {
        return new Dopesong\Slim\Error\Whoops($c->get('settings')['displayErrorDetails']);
    };
}

// ルーター設定
$app->get('/', Controller::class.':input');
$app->post('/', Controller::class.':input');

// 処理開始
session_start();
$app->run();
