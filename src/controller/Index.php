<?php

namespace think\one\controller;

use think\Config;

class Index extends Base
{

    public function index()
    {
        // Config::get('version', 'think.one')
        return $this->fetch();
    }

}
