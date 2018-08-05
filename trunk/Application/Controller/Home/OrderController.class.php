<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/2 0002
 * Time: 下午 9:34
 */

namespace Application\Controller\Home;


use Application\Model\OrderModel;
use Framework\Tools\PlatformController;

class OrderController extends PlatformController
{//预约前台控制器
    private $model;

    public function __construct()
    {
        $this->qiantaiyanzheng();
        $this->model = new OrderModel();
    }

    //展示预约界面
    public function add()
    {
        //为get传值,显示添加页面
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            //查询有哪些员工并返回值
            $res = $this->model->member();
            //查询有哪些可用套餐
            $a = $this->model->plans();
            $this->assign('a', $a);
            $this->assign('c', $res);
            $this->display('add');
        } else {//添加保存
            //>>1.接收数据
            $data = $_POST;
            //2.1 调用模型 将$data数据保存到数据库
            $rs = $this->model->add($data);
            if ($rs === false) {
                //添加失败 提示错误信息 再调转当前页面//调用错误信息,
                $this->redirect("?p=Home&c=Order&a=add", '添加失败' . $this->model->getError(), 1);
            }
            //成功 调整到首页
            $this->redirect("?p=Home&c=Order&a=index", '添加成功', 1);

        }
    }

    //显示预约信息
    public function index()
    {
        $result = $this->model->index();
        @session_start();
        $this->assign('c', $result);
        //加载视图
        $this->display('list');
    }

}