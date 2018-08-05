<?php
/**
 * Created by PhpStorm.
 * User: 35482
 * Date: 2018/6/2
 * Time: 13:12
 */

namespace Application\Controller\Admin;


use Application\Model\HistoriesModel;
use Framework\Controller;
use Framework\Tools\PageTool;
use Framework\Tools\PlatformController;

class HistoriesController extends PlatformController
{   public  function  __construct()
{ $this->yanzhengdenglu();
}

    public function index(){
        @session_start();
        $conditions=[];
        //判断搜索条件是否为空
//        用户名 姓名 性别 手机号
        if (!empty($_REQUEST['username'])){
            $conditions[]="(username like '%{$_REQUEST['username']}%' )";
        }
        if (!empty($_REQUEST['membername'])) {
            $conditions[] = "(membername like '%{$_REQUEST['realname']}%')";
        }

        //分页
        $page=$_GET['page']??1;

        /**sss**/
        $HistoriesModel=new HistoriesModel();
        $all_msg=$HistoriesModel->getall($conditions,$page);
        $list=$all_msg['list'];
        $count=$all_msg['count'];
        $page=$all_msg['page'];
        $leng=$all_msg['leng'];
        $page_html=PageTool::show($count,$page,$leng);//获取分页条
        $this->assign('list',$list);
        $this->assign('page_html',$page_html);
        $this->display('index');

    }
}