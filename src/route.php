<?php

\think\Route::any('think/one/[:controller]/[:action]', function ($controller = '', $action = '') {
    include __DIR__ . DS . 'function.php';
    $config_file = __DIR__ . DS . 'config.php';
    \think\Config::load($config_file, '', 'think.one');

    \think\App::$modulePath = __DIR__ . DS;

    define('THINK_ONE_PATH', dirname(__DIR__) . DS);
    define('THINK_ONE_ASSETS', dirname(__DIR__) . DS . 'assets' . DS);

    \think\Config::set('url_common_param', true);

    $controller = $controller ? : 'Index';
    $action     = $action ? : 'index';

    \think\Config::set('controller', $controller, 'think.one');
    \think\Config::set('action', $action, 'think.one');

    think_one_check_install();

    $class_name = '\\think\\one\\controller\\' . $controller;
    return \think\App::invokeMethod([$class_name, $action]);
});
