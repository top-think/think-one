<?php

namespace think\one\controller;

class AssetsController extends BaseController
{

    public function index($filename = '')
    {
        $filename = THINK_ONE_ASSETS . $filename;
        $file_info = pathinfo($filename);
        $ext       = isset($file_info['extension'])
            ? $file_info['extension']
            : '';
        switch ($ext) {
            case 'css':
                header('Content-Type: text/css');
                break;
        }
        if (is_file($filename)) {
            readfile($filename);
            die;
        } else {
            return '静态资源文件不存在: ' . $filename;
        }
    }

}
