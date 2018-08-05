<?php
/**
 * Created by PhpStorm.
 * User: 35482
 * Date: 2018/6/1
 * Time: 19:32
 */

namespace Application\Controller\Admin;


use Application\Model\UserModel;
use Framework\Controller;
use Framework\Tools\ImageTool;
use Framework\Tools\PageTool;
use Framework\Tools\PlatformController;
use Framework\Tools\UploadTool;

class UserController extends PlatformController
{ public  function __construct()
{ $this->yanzhengdenglu();
}

    //展示页面
    public function index(){
        @session_start();
        $conditions=[];

        $sex="";





        if (!empty($_REQUEST['keyword'])){
            $conditions[]="(username like '%{$_REQUEST['keyword']}%' )";
        }
        if (!empty($_REQUEST['keyword'])) {
            $conditions[] = "(realname like '%{$_REQUEST['keyword']}%')";
        }
        if (!empty($_REQUEST['sex'])) {

            $sex= "( sex = '{$_REQUEST['sex']}')";
        }
        if (!empty($_REQUEST['keyword'])) {
            $conditions[] = "(telephone like '%{$_REQUEST['keyword']}%')";
        }
        //分页
        $page=$_GET['page']??1;

        $UserModel = new UserModel();
        $all_msg = $UserModel->getall($sex,$conditions,$page);
        $rows=$all_msg['rows'];
        $count=$all_msg['count'];
        $page=$all_msg['page'];
        $leng=$all_msg['leng'];
        $page_html=PageTool::show($count,$page,$leng);//获取分页条
        $this->assign('rows',$rows);
        $this->assign('page_html',$page_html);
        $this->display('index');
    }
    //修改
    public function edit(){
        @session_start();
        if($_SERVER['REQUEST_METHOD']=='POST'){
            $data=$_POST;//普通数据
            $photo=$_FILES['photo'];//传送数据
            if($photo['error']!=4){
                $uploadtool=new UploadTool() ;
                //期望该方法上传成功返回图片地址,错误保存error信息
                $photo_path=$uploadtool->upload($photo);
                if($photo_path===false){
                    //上传失败输出错误信息,跳转到添加页面
                    $this->redirect("index.php?p=Admin&c=User&a=edit",$uploadtool->geterror(),1);
                    exit;
                }
                //上传成功将图片进行缩略图修改
                $thumb=new ImageTool();
                $thumb_path=$thumb->thumb($photo_path);
                //上传成功将图片 地址  保存到$data数据库中
                $data['photo']=$thumb_path;

            }
            $UserModel=new UserModel();
            $Useradd=$UserModel->update($data);
            //修改失败跳转到修改页面
            if($Useradd===false){
                $this->redirect("index.php?p=Admin&c=User&a=edit&id={$data['id']}",$UserModel->geterror(),1);
            }

            $this->redirect('index.php?p=Admin&c=User&a=index','修改成功',10);

        }else{
            $id=$_GET['id'];
            $userModel=new userModel();
            $editlist=$userModel->getone($id);
            $this->assign('editlist',$editlist);
            $this->display('edit');
        }

    }
    //添加
    public function add(){
        @session_start();
        if($_SERVER['REQUEST_METHOD']=='POST'){
            $data=$_POST;//普通数据
            $photo=$_FILES['photo'];//传送数据

            if($photo['error']!=4){
                $uploadtool=new UploadTool() ;
                //期望该方法上传成功返回图片地址,错误保存error信息
                $photo_path=$uploadtool->upload($photo);
                if($photo_path===false){
                    //上传失败输出错误信息,跳转到添加页面
                    $this->redirect('index.php?p=Admin&c=User&a=add',$uploadtool->getError(),1);
                    exit;
                }

                //上传图片成功后将图片进行缩略图修改
                $thumb=new ImageTool();
                $thumb_path=$thumb->thumb($photo_path);
                //修改成功后 将缩略图地址  保存到$data数据库中
                $data['photo']=$thumb_path;

            }


            $UserModel=new UserModel();
            $Useradd=$UserModel->register($data);
            if($Useradd===false){
                $this->redirect('index.php?p=Admin&c=User&a=add',$UserModel->geterror(),1);
            }

            $this->redirect('index.php?p=Admin&c=User&a=index','添加成功',1);

        }else{
            $this->display('add');
        }

    }
    //删除
    public function delete(){
        $id=$_GET['id'];
        $UserModel=new UserModel();
        $now=$UserModel->getout($id);
        if($now===false){
            $this->redirect('index.php?p=Admin&c=User&a=index',$UserModel->getError(),1);
        }
        $this->redirect('index.php?p=Admin&c=User&a=index','删除成功',0.5);
    }
    //充值
    public function getmoney(){
        if($_SERVER['REQUEST_METHOD']=='GET'){
            $id=$_GET['id'];
            $this->assign('id',$id);
            $this->display('pushin');

        }else{
            $data=$_POST;
            $UserModel=new UserModel();
            $moneyadd=$UserModel->moneyin($data);
            if($moneyadd===false){
                $this->redirect("index.php?p=Admin&c=User&a=getmoney&id='{$data['id']}'",$UserModel->getError(),1);
            }
            $this->redirect('index.php?p=Admin&c=User&a=index','充值成功',0.5);
        }


    }
    //消费
    public function pay(){
        @session_start();
        if($_SERVER['REQUEST_METHOD']=='GET'){
            $id=$_GET['id'];
            $UserModel=new UserModel();
            $codes=$UserModel->getcode($id);
            $members=$UserModel->getmember();
            $plans=$UserModel->getplans();

            $this->assign('codes',$codes);
            $this->assign('members',$members);
            $this->assign('plans',$plans);
            $this->assign('id',$id);
            $this->display('pay');

        }else{
            $data=$_POST;
            $UserModel=new UserModel();
            $moneyadd=$UserModel->moneyout($data);
            if($moneyadd===false){
                $this->redirect("index.php?p=Admin&c=User&a=index",$UserModel->getError(),1);
                exit;
            }
            $this->redirect('index.php?p=Admin&c=User&a=index','消费成功',0.5);
        }

    }

}