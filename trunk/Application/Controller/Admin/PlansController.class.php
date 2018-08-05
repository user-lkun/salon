<?php

namespace  Application\Controller\Admin;
use Application\Model\PlansModel;
use Framework\Controller;
use Framework\Tools\PageTool;
use Framework\Tools\PlatformController;

class PlansController  extends PlatformController
{  public  function  __construct()
{$this->yanzhengdenglu();
}

    public function index(){
        @session_start();
        //搜索条件
        //准备空数组来保存搜索条件
        $conditions=[];
        //判断搜索条件是否为空
        if (!empty($_REQUEST['name'])){//传了姓名
            $conditions[]="(name like '%{$_REQUEST['name']}%' )";
        }
        if (!empty($_REQUEST['money'])) {//传了邮箱
            $conditions[] = "(money like '%{$_REQUEST['money']}%')";
        }
        //分页
        $page=$_GET['page']??1;

        $plansModel = new PlansModel();
        $all_msg = $plansModel->getList($conditions,$page);
        $rows=$all_msg['rows'];
        $count=$all_msg['count'];
        $page=$all_msg['page'];
        $leng=$all_msg['leng'];
        $page_html=PageTool::show($count,$page,$leng);//获取分页条

        $this->assign('rows',$rows);
        $this->assign('page_html',$page_html);
        $this->display("index");
    }
    public function add(){
        @session_start();
        if ($_SERVER['REQUEST_METHOD']=='GET'){
            $this->display('add');
        }else{
            $data = $_POST;
            $plansModel = new PlansModel();
            $res = $plansModel->insert($data);
            if ($res===false){
                $this->redirect('?p=Admin&c=Plans&a=add','添加失败!'.$plansModel->getError(),2);
            }
            $this->redirect('?p=Admin&c=Plans&a=index','添加成功!',2);
        }
    }
    public function edit(){
        @session_start();
        if ($_SERVER['REQUEST_METHOD']=='GET'){
            $plan_id=$_GET['plan_id'];
            $plansModel = new PlansModel();
            $res = $plansModel->getOne($plan_id);
            $this->assign($res);
            $this->display('edit');
        }else{
            $data = $_POST;
            $plansModel = new PlansModel();
            $res = $plansModel->update($data);
            if ($res===false){
                $this->redirect("?p=Admin&c=Plans&a=edit&plan_id='{$data['plan_id']}'",'修改失败!'.$plansModel->getError(),2);
            }
            $this->redirect('?p=Admin&c=Plans&a=index','修改成功!',2);
        }
    }
    public function delete(){
        @session_start();
        $plan_id=$_GET['plan_id'];
        $plansModel = new PlansModel();
        $res = $plansModel->delete($plan_id);
        $this->redirect('?p=Admin&c=Plans&a=index','删除成功!',2);
    }
}