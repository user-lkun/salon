<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/1 0001
 * Time: 上午 11:21
 */

namespace Application\Controller\Admin;

use Framework\Controller;
use  Framework\Tools\PlatformController;
class IndexController extends  PlatformController
{
    //自动验证登录
    public function  __construct()
    {$this->yanzhengdenglu();
    }

//显示后台首页
    public function index()
    {
        //加载后台首页
        @session_start();

        $this->display('index');
    }
}
