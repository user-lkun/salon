<?php
/**
 * Created by PhpStorm.
 * User: 35482
 * Date: 2018/6/3
 * Time: 13:19
 */

namespace Application\Controller\Admin;


use Application\Model\FullModel;
use Framework\Controller;

class FullController extends Controller
{
    public function index(){
        @session_start();
         $FullModel=new FullModel();
         $Fulllist=$FullModel->getall();
         $this->assign('Fulllist',$Fulllist);
         $this->display('index');
    }
    public function add(){
        if($_SERVER['REQUEST_METHOD']=='POST'){
            $data=$_POST;
            $FullModel=new FullModel();
            $Fullres=$FullModel->insert($data);
            if($Fullres===false){
                $this->redirect('index.php?p=Admin&c=Full&a=add',$FullModel->getError(),1);
            }
            $this->redirect('index.php?p=Admin&c=Full&a=index');
        }else{
            $FullModel=new FullModel();
            $getuser=$FullModel->getuser();
            $this->assign('getuser',$getuser);
            $this->display('add');
        }

    }
    public function edit(){
        if($_SERVER['REQUEST_METHOD']=='POST'){
            $data=$_POST;
            $FullModel=new FullModel();
            $Fullres=$FullModel->update($data);
            if($Fullres===false){
                $this->redirect('index.php?p=Admin&c=Full&a=index',$FullModel->getError(),1);
            }
            $this->redirect('index.php?p=Admin&c=Full&a=index','修改成功',0.5);
        }else{
            $id=$_GET['id'];
            $FullModel=new FullModel();
            $Fulledit=$FullModel->getone($id);
            $userid=$Fulledit['user_id'];
            $Fulluser=$FullModel->getiduser($userid);

            $this->assign('Fulluser',$Fulluser);
            $this->assign('Fulledit',$Fulledit);
            $this->display('edit');

        }
    }
    public function delete(){
        $id=$_GET['id'];
        $FullModel=new FullModel();
        $Fulldelete=$FullModel->getout($id);
        if($Fulldelete===false){
            $this->redirect('index.php?p=Admin&c=Full&a=index','删除失败');
        }
        $this->redirect('index.php?p=Admin&c=Full&a=index','删除成功',0.5);
    }
}