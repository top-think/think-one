<?php

namespace think\one\controller;

class CacheController extends BaseController
{

    public function index()
    {
        return $this->fetch();
    }

    public function watch()
    {
        return $this->fetch();
    }

}
