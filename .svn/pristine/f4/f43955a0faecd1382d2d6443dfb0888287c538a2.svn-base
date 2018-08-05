<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2018/6/4
 * Time: 23:16
 */

namespace Application\Controller\Home;


use Application\Model\XiaofeiModel;
use Framework\Controller;

class XiaofeiController  extends Controller
{
    public function getlist()
    {
        @session_start();
        if (!empty($_SESSION['user'])){
            $xiaofei = new XiaofeiModel();
            $rows = $xiaofei->getall();
            $this->assign('rows', $rows);
            $this->display('index');
        }else{
            $this->redirect("?p=Home&c=Index&a=index",'请先登录!',2);
        }

    }
}