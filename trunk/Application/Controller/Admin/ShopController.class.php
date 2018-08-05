<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/3 0003
 * Time: 下午 2:19
 */

namespace Application\Controller\Admin;


use Application\Model\PlatformModel;
use Application\Model\ShopModel;
use Framework\Tools\PlatformController;
use  Framework\Tools\ImageTool;
class ShopController extends  PlatformController
{      private $model;
    public function __construct()
    {  $this->yanzhengdenglu();

        $this->model = new  ShopModel();

    }
    //添加积分商品
    public function add()
    {
        //为get传值,显示添加页面
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $this->display('add');
        } else {//添加保存
            //>>1.接收数据
            $data = $_POST;
            $head = $_FILES['logo'];//文件图片数据
            ////对上传图片限制,本机保存原图,返回径制作缩略图
            $lujing = $this->touxiang($head);
            $data['img']= $lujing ;
            //自动制作缩略图返回地址,保存到数据库
            //根据原图路径制作缩略图
            $suoluetu = new  ImageTool();
            //制作缩略图,并返回缩略图路径
            $data['logo'] = $suoluetu->thumb($lujing);
            //>>2.处理数据
            //2.1 调用模型 将$data数据保存到数据库
            $rs = $this->model->add($data);
            if ($rs === false) {
                //添加失败 提示错误信息 再调转当前页面//调用错误信息,
                $this->redirect("index.php?p=Admin&c=Shop&a=add", '添加失败'.$this->model->getError(), 1);
            }
            //成功 调整到首页
            $this->redirect("index.php?p=Admin&c=Shop&a=index", '添加成功', 1);

        }
    }
    //后台显示积分商品信息
    public  function  index(){
        //判断搜索框中姓名条件有没有值,设置一个空数组保存条件
        $tiaojian = [];

        //将传入的值遍历,转义字符串,防止字符串有特殊意义,例如,搜索框中有'
        foreach ($_REQUEST as $k => &$v) {
            $v = addslashes($v);
        }
        //如果传入关键字,就需要按照关键(标题)字查询
        if (!empty($_REQUEST['name'])) {
            $tiaojian[] = "name like '%{$_REQUEST['name']}%' ";
        }

        //设置分页,给定当前页一个初始值$page为当前页
        $page = $_REQUEST['page']??1;
        //调用model方法,完成查询数据库的功能
        $c = $this->model->index($tiaojian, $page);
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
        @session_start();
        //分配数据
        $this->assign('a', $a);
        $this->assign('cc', $cc);
        //加载模板
        $this->display('list');
    }
    //后台商品的修改
    public  function  edit(){
        if ($_SERVER['REQUEST_METHOD']=="GET"){
            $id=$_GET['id'];
            //修改回显
            $v= $this->model->getone($id);
            //将值分配给视图
            $this->assign('user',$v);
            //加载视图
            $this->display('edit');
        }else{//post传值,修改保存
            $data=$_POST;
            //判断用户是否修改图片,
            if ($_FILES['logo']['error']==4){//值为4,表示不修改图片,传原图路径
                $data['logo']=$data['oldlogo'];
            }else{//不为4时上传图片
            $head = $_FILES['logo'];//文件图片数据
            ////对上传图片限制,本机保存原图,返回径制作缩略图
            $lujing = $this->touxiang($head);
                $data['img']= $lujing ;
            //自动制作缩略图返回地址,保存到数据库
            //根据原图路径制作缩略图
            $suoluetu = new  ImageTool();
            //制作缩略图,并返回缩略图路径
            $data['logo'] = $suoluetu->thumb($lujing);
            }

            //调用修改保存模型
            $c=$this->model->edit($data);

            if ($c===false){
                $this->redirect("index.php?p=Admin&c=Shop&a=edit&id={$data['id']}",'修改失败'.$this->model->getError(),1);
            }//修改成功跳转回首页
            $this->redirect('index.php?p=Admin&c=Shop&a=index','修改成功',1);


        }
    }
    //商品删除
    public  function  delete(){
        $id=$_GET['id'];
        //调用模型删除商品
        $result=$this->model->delete($id);
        //删除完毕跳转回首页
        if ($result===false){
            $this->redirect('index.php?p=Admin&c=Shop&a=index','删除失败',2);
        }//删除成功也跳转回首页
        $this->redirect('index.php?p=Admin&c=Shop&a=index','删除成功',2);
    }
}