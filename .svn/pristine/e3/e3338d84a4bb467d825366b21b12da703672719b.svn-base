<?php
/**
 * Created by PhpStorm.
 * User: 35482
 * Date: 2018/6/2
 * Time: 10:20
 */

namespace Application\Controller\Home;


use Application\Model\UserModel;
use Framework\Controller;
use Framework\Tools\ImageTool;
use Framework\Tools\UploadTool;

class UserLoginController extends Controller
{
    //前台登录验证
    public function login(){
        if($_SERVER['REQUEST_METHOD']=='POST'){
            $data=$_POST;
            $UserModel=new UserModel();
            $firstcheck=$UserModel->checklogin($data);
            if($firstcheck===false){
                $this->redirect('index.php?p=Home&c=UserLogin&a=login',$UserModel->getError(),1.5);
            }
            //成功保存用户信息到session
            $_SESSION['user']=$firstcheck;

            //有设置保存登录信息
            if(isset($data['remember'])){
                setcookie('user_id',$firstcheck['user_id'],time()+7*24*3600,'/');
                setcookie('password',$firstcheck['password'],time()+7*24*3600,'/');
            }
            $this->redirect('index.php?p=Home&c=Index&a=index','登录成功',0.5);


        }else{
            $this->display('index');
        }


    }
    //退出登录
    public function logout(){
        @session_start();
        unset($_SESSION['user']);
        setcookie('user_id',null,-1,'/');
        setcookie('password',null,-1,'/');
        $this->redirect('index.php?p=Home&c=Index&a=index','退出成功!',1);
    }
    //前台注册会员
    public function register(){
        if($_SERVER['REQUEST_METHOD']=='POST'){
            $data=$_POST;//普通数据
            $photo=$_FILES['photo'];//传送数据
            if($photo['error']!=4){

                $uploadtool=new UploadTool() ;
                $photo_path=$uploadtool->upload($photo);
                if($photo_path===false){
                    //上传失败输出错误信息,跳转到添加页面
                    $this->redirect('index.php?p=Home&c=User&a=index',$uploadtool->getError(),1);
                    exit;
                }
                $thumb=new ImageTool();
                $thumb_path=$thumb->thumb($photo_path);
                //修改成功后 将缩略图地址  保存到$data数据库中
                $data['photo']=$thumb_path;

            }

            $UserModel=new UserModel();
            $Homeuser=$UserModel->register($data);
            if($Homeuser===false){
                $this->redirect('index.php?p=Home&c=UserLogin&a=register',$UserModel->getError(),1);
            }
            //注册成功
            $this->redirect('index.php?p=Home&c=Index&a=index','注册成功!',1);
        }else{

            $this->display('register');
        }

    }


}