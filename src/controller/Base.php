<?php

namespace think\one\controller;

class Base extends \think\Controller
{

    protected $title = '';

    protected function fetch($template = '', $vars = [], $replace = [], $config = [])
    {
        $this->assign('title', $this->title);
        $template = $this->parseTemplatePath($template);
        return parent::fetch($template, $vars, $replace, $config);
    }

    protected function parseTemplatePath($template = '')
    {
        $controller = \think\Config::get('controller', 'think.one');
        $action     = \think\Config::get('action', 'think.one');
        if (!$template) {
            // 没有传模版名
            $template = $controller . DS . $action;
            $template = str_replace('.', DS, $template);
            return $template;
        } elseif (strpos($template, '/') === false) {
            // 只传了操作名
            $template = $controller . DS . $template;
            $template = str_replace('.', DS, $template);
            return $template;
        }
        // 默认原样返回
        return $template;
    }

}
