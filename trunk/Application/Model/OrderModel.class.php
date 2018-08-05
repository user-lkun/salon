<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/2 0002
 * Time: 下午 9:36
 */

namespace Application\Model;


use Framework\Model;

class OrderModel extends  Model
{//预约前台界面
    //保存预约信息
    public function add($data){

        //判断输入的用户名是否为空
        if (empty($data['realname'])) {
            //保存错误信息
            $this->error = "真实姓名不能为空";
            return false;
        }
        if (is_int($data['phone'])) {
            //保存错误信息
            $this->error = "电话号码必须为数字";
            return false;
        }
        if (empty($data['barber'])) {
            //保存错误信息
            $this->error = "必须指定造型师";
            return false;
        }
        if (empty($data['content'])) {
            //保存错误信息
            $this->error = "填写具体备注信息";
            return false;
        }
        $time=time();
        $date=strtotime($data['date']);
        if ($time>$date){
            $this->error='预约时间不能小于当前时间';
            return false;
        }
      //如果没传sttus,默认0,即未审核
        if (empty($data['status'])){
            $data['status']=0;
        }
        //写sql
        $sql="insert into `order`(realname,phone,barber,content,`date`,status) VALUES (
'{$data['realname']}',
'{$data['phone']}',
'{$data['barber']}',
'{$data['content']}',
'{$date}',
'{$data['status']}')";
        //执行sql
        return $this->db->execute($sql);
    }
//展示前台页面
public  function  index(){
    $sql="select * from `order`ORDER BY order_id desc limit 0,3 ";
    $result=$this->db->fetchAll($sql);
    return $result;
}
//展示后台台页面
    public  function    Admin($page){
        //设定每页的查询条数
        $pagesize = 4;
        //查询总的条数
        $count = $this->db->fetchColumn("select count(*)  from  `order` ");
        //查询总的总页数,向上取整
        $zongyeshu = ceil($count / $pagesize);
        //dump($zongyeshu);exit();
        $page = $page > $zongyeshu ? $zongyeshu : $page;
//需要球开始页(当前页-1)乘以每页条数
        //当前页不能小于1,不能大于总页数
        $page = $page < 1 ? 1 : $page;
        $start = ($page - 1) * $pagesize;
        $limit = " limit $start,$pagesize";
        //>>1.准备sql
        $sql = "select * from `order` "  . $limit;
        //dump($sql);
        //>>2.执行sql
        $result = $this->db->fetchAll($sql);
        //需要将值全部返回出去
        return array('result' => $result, 'page' => $page, 'pagesize' => $pagesize, 'count' => $count, 'zongyeshu' => $zongyeshu);
    }
    //根据传入值确定状态
    public  function  shenhe($data){
        if ($data['status']>0){
            $data['status']=0;
        }else{
            $data['status']=1;
        }
//修改数据库
        $sql="update `order` set status='{$data['status']}' where order_id='{$data['id']}'";
//执行sql
        return  $this->db->execute($sql);
    }
    //查询所有的管理员名称
    public function  member(){
        $sql='select username from `members`';
        //执行sql返回值
       return $this->db->fetchAll($sql);
    }
    //查询所有的可选套餐
    public function  plans(){
        $sql="select name from `plans` where status=1";
        //执行sql返回值
        return $this->db->fetchAll($sql);
    }
    //保存回复信息
    public  function  huifu($data){
        $sql="update `order` set reply='{$data['content']}' where  order_id='{$data['id']}' ";
        //执行并且返回sql
       return $this->db->execute($sql);
    }

}