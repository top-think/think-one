<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 翟帅干 <zhaishuaigan@qq.com>
// +----------------------------------------------------------------------
namespace think\one\controller;

class ServerController extends BaseController
{

    public function index()
    {
        return $this->fetch();
    }

}
