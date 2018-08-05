<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/3 0003
 * Time: 上午 12:35
 */

namespace Application\Controller\Admin;


use Application\Model\OrderModel;
use Framework\Tools\PlatformController;

class OrderController extends PlatformController
{
    private $model;

    public function __construct()
    {   $this->yanzhengdenglu();
        $this->model=new OrderModel();
    }
    //显示预约信息
    public  function  Admin(){
        //设置分页,给定当前页一个初始值$page为当前页
        $page = $_REQUEST['page']??1;
        //调用model方法,完成查询数据库的功能
        $c= $this->model->admin($page);
        $cc = $c['result'];
        $page = $c['page'];//当前页
        $count = $c['count'];//总条数
        $zongyeshu = $c['zongyeshu'];//总页数
        $pagesize = $c['pagesize'];//每页显示条数
        //将$request的值作为分页与搜索链接条件,
        //有page需要删除$request的page
        unset($_REQUEST['page']);
        $c = http_build_query($_REQUEST);
        $ur = 'index.php?';
        $url = $ur . $c;
        //调用工具条模型
        $a = $this->fenye($url, $count, $zongyeshu, $page, $pagesize);
        //分配数据
        $this->assign('a', $a);
        $this->assign('c', $cc);
        @session_start();
        //加载视图
        $this->display('index');
    }
    //接收审核传递的值
    public function shenhe()
    {
        $data['id'] = $_GET['id'];
        $data['status'] = $_GET['status'];
        $this->model->shenhe($data);
//跳转显示页面
        $this->redirect("?p=Admin&c=Order&a=Admin", 0);
    }
//回复预约
    public function  huifu()
    {
        if ($_SERVER['REQUEST_METHOD'] == "GET") {
            $id=$_GET['id'];
            //将id传值给回复界面方便保存回复
            $this->assign('id',$id);
            @session_start();
            $this->display('huifu');
        }else{//为post传值时保存回复信息
            $data=$_POST;
            //保存回复信息
            $result= $this->model->huifu($data);
            if ($result===false){
                $this->redirect('index.php?p=Admin&c=Order&a=huifu','回复失败!',1);
            }
            $this->redirect('index.php?p=Admin&c=Order&a=admin','',0);
        }

    }


}
