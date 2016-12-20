<?php

function think_one_init()
{

}

\think\Route::any('think/one/[:controller]/[:action]', function ($controller = '', $action = '') {
    define('THINK_ONE_PATH', dirname(__DIR__) . '/');
    define('THINK_ONE_ASSETS', THINK_ONE_PATH . 'assets/');
    define('THINK_ONE_SRC', THINK_ONE_PATH . 'src/');
    define('THINK_ONE_CONTROLLER', THINK_ONE_SRC . 'controller/');
    define('THINK_ONE_MODEL', THINK_ONE_SRC . 'model/');
    define('THINK_ONE_VIEW', THINK_ONE_SRC . 'view/');
    $controller = \think\Loader::parseName($controller, 1) ?: 'Index';
    $action     = $action ?: 'index';
    $className  = '\\think\\one\\controller\\' . $controller . 'Controller';
    if ($controller == 'Assets') {
        \think\Config::set('url_common_param', true);
        return \think\App::invokeMethod([$className, 'index'], [
            'filename' => $action
        ]);
    }
    try {
        return \think\App::invokeMethod([$className, $action]);
    } catch (\Exception $e) {
        $className = '\\think\\one\\controller\\EmptyController';
        return \think\App::invokeMethod([$className, 'index'], [
            'controller' => $controller,
            'action'     => $action,
        ]);
    }

}, [
    'merge_extra_vars' => true
]);
