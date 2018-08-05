<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/3 0003
 * Time: 下午 4:58
 */

namespace Application\Controller\Home;


use Application\Model\ShopModel;
use Framework\Tools\PlatformController;

class ShopController extends  PlatformController
{//前台显示积分商城
    private $model;

    public function __construct()
    {   $this->qiantaiyanzheng();
        $this->model=new ShopModel();
    }
    //显示积分商城
    public  function shop()
    {   //判断搜索框中姓名条件有没有值,设置一个空数组保存条件
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
        $c = $this->model->home($tiaojian, $page);
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
        //查询用户积分
        @session_start();
        $b=$_SESSION['user']['username'];
        $id=$_SESSION['user']['user_id'];
        $d=$this->model->user($id);;//查询用户积分
        if (empty($d)){
            $d=0;
        }
//        var_dump($d);exit;
        $this->assign('b',$b);
        $this->assign('d',$d);
        //分配数据
        $this->assign('a', $a);
        $this->assign('cc', $cc);
        $this->display('index');
    }
    //点击兑换扣除积分,添加日志
public  function   jifen(){
        //将商品的积分传过来,用以比较修改用户积分
        $jifen=$_GET['jifen'];
        //商品名
       $brand=$_GET['brand'];
       //商品库存
    $kucun=$_GET['kucun'];
    //调用model执行并返回值
  $result=$this->model->jifen($jifen,$brand,$kucun);
  if ($result===false){
      $this->redirect('index.php?p=Home&c=Shop&a=shop','兑换失败'.$this->model->getError(),2);
  }//兑换成功返回首页
    $this->redirect('index.php?p=Home&c=Index&a=index','兑换成功',1);
}
}