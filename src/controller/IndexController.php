<?php

namespace think\one\controller;

use think\Config;

class IndexController extends BaseController
{

    public function index()
    {
        // Config::get('version', 'think.one')
        return $this->fetch();
    }

}
