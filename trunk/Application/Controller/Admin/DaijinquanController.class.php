<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2018/6/2
 * Time: 9:47
 */

namespace Application\Controller\Admin;


use Application\Model\DaijinquanModel;
use Framework\Controller;
use Framework\Tools\PageTool;
use Framework\Tools\PlatformController;


class DaijinquanController extends PlatformController
{  public function __construct()
{ $this->yanzhengdenglu();
}

    public function index(){
        @session_start();
        //搜索条件
        //准备空数组来保存搜索条件
        $conditions=[];
        //判断搜索条件是否为空
        if (!empty($_REQUEST['code'])){//传了code
            $conditions[]="(code like '%{$_REQUEST['code']}%' )";
        }

        //分页
        $page=$_GET['page']??1;
        $daijinquan  = new DaijinquanModel();
        $all_msg = $daijinquan->getList($conditions,$page);

        $rows=$all_msg['rows'];
        $count=$all_msg['count'];
        $page=$all_msg['page'];
        $leng=$all_msg['leng'];
        $page_html=PageTool::show($count,$page,$leng);//获取分页条

        $this->assign('rows',$rows);
        $this->assign('page_html',$page_html);
        $this->display('index');

    }
    public function add(){
        @session_start();
        if ($_SERVER['REQUEST_METHOD']=='GET'){
            $this->display('daijinquan_add');
        }else{

            $money=$_POST['money'];
            $num=$_POST['number'];
            $code = [];
            for ($i=1;$i<=$num;$i++){
                $code[] .= uniqid($i);
            }
            $daijinquan  = new DaijinquanModel();
            $rows = $daijinquan->insert($money,$code);
            $this->redirect('?p=Admin&c=Daijinquan&a=index','添加成功!',2);
        }

    }
    public function edit(){
        @session_start();
        if ($_SERVER['REQUEST_METHOD']=='GET'){
            $code_id=$_GET['code_id'];
            $daijinquan  = new DaijinquanModel();
            $row = $daijinquan->getOne($code_id);
            //获取username
            $rows = $daijinquan->getName();
            $this->assign($row);
            $this->assign('rows',$rows);

            $this->display('daijinquan_edit');
        }else{
            $data = $_POST;
            $daijinquan  = new DaijinquanModel();
            $row = $daijinquan->update($data);
            $this->redirect('?p=Admin&c=Daijinquan&a=index','修改成功!',2);
        }
    }
    public function delete(){
        @session_start();
        $code_id=$_GET['code_id'];
        $daijinquan  = new DaijinquanModel();
        $row = $daijinquan->delete($code_id);
        if ($row===false){
            $this->redirect('?p=Admin&c=Daijinquan&a=index','删除失败!'.$daijinquan->getError(),2);
        }
        $this->redirect('?p=Admin&c=Daijinquan&a=index','删除成功!',2);
    }
}