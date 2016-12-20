<?php

namespace think\one\controller;

use think\angular\Angular;
use think\App;
use think\Request;

class BaseController
{

    /**
     * @var Angular
     */
    private static $_view = null;

    /**
     * @var Request
     */
    protected $request = null;

    protected $title = '';

    public function __construct(Request $request)
    {
        $this->request = $request;
        // parent::__construct($request);
        include THINK_ONE_SRC . 'function.php';
        $configFile = THINK_ONE_SRC . 'config.php';
        \think\Config::load($configFile, '', 'think.one');

    }

    protected function view()
    {
        self::$_view = self::$_view ?: new Angular([
            'debug'            => App::$debug, // 是否开启调试
            'tpl_path'         => THINK_ONE_VIEW, // 模板根目录
            'tpl_suffix'       => '.html', // 模板后缀
            'tpl_cache_path'   => './cache/', // 模板缓存目录
            'tpl_cache_suffix' => '.php', // 模板缓存后缀
            'directive_prefix' => 'php-', // 指令前缀
            'directive_max'    => 10000, // 指令的最大解析次数
        ]);
        return self::$_view;
    }

    protected function assign($key, $val = null)
    {
        $this->view()->assign($key, $val);
    }

    protected function fetch($template = '', $vars = [])
    {
        $this->assign('title', $this->title);
        if ($vars) {
            $this->assign($vars);
        }
        $template = $this->parseTemplatePath($template);
        return $this->view()->fetch($template, $vars);
    }

    protected function parseTemplatePath($template = '')
    {
        $controller = $this->request->param('controller', 'index');
        $action     = $this->request->param('action', 'index');
        if (!$template) {
            // 没有传模版名
            $template = $controller . '/' . $action;
            $template = str_replace('.', DS, $template);
        } elseif (strpos($template, '/') === false) {
            // 只传了操作名
            $template = $controller . '/' . $template;
            $template = str_replace('.', '/', $template);
        }
        // 默认原样返回
        return strtolower($template);
    }

}
