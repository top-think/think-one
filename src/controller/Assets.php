<?php

namespace think\one\controller;

class Assets extends Base
{

    public function index($filename = '')
    {
        $filename  = THINK_ONE_ASSETS . $filename;
        $file_info = pathinfo($filename);
        switch ($file_info['extension']) {
            case 'css':
                header('Content-Type: text/css');
                break;
        }
        if (is_file($filename)) {
            readfile($filename);
        } else {
            return '文件不存在!';
        }
    }

}
