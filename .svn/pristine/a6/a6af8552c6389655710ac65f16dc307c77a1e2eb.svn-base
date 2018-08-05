<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2018/6/4
 * Time: 0:12
 */

namespace Application\Model;


use Framework\Model;

class DingdanModel extends  Model
{
    public function getList($conditions,$page){

        $sql="select * from dingdan";
        $where ='';//没传收索条件给一个空
        if (!empty($conditions)){
            $where =" where ".implode(' and ',$conditions);
        }
        //分页处理
        //设置每页的显示条数  where xxx limit $start ,$leng;
        $leng=5;
        //获取总页数
        //获取数据库中的总数据条数
        $count=$this->db->fetchColumn("select count(*) from dingdan ".$where);//分页时需要将搜索的条件加上,
        $totalPage=ceil($count/$leng);//总页数
        //判断
        $page=$page>$totalPage?$totalPage:$page;//页码不能大于总页数
        $page=$page<1?1:$page;//页码不能小于1
        $start = ($page - 1) * $leng;//起始页
        $limit=" limit {$start},{$leng}";
        $sql_all=$sql.$where.$limit;
        $rows = $this->db->fetchAll($sql_all);
        $all_msg['rows']=$rows;
        //将分页信息保存在新数组中

        $all_msg['page']=$page;
        $all_msg['count']=$count;
        $all_msg['leng']=$leng;
        return $all_msg;
    }
    public function dealDingdan($dingdan_id){
        $time=time();
        $sql="update dingdan set deal_time='{$time}',status=1 WHERE dingdan_id='{$dingdan_id}'";
        $res = $this->db->execute($sql);
        return $res;
    }
    public function dealSend($dingdan_id){
        $sql="update dingdan set is_send=1 WHERE dingdan_id='{$dingdan_id}'";
        $res = $this->db->execute($sql);
        return $res;
    }
    public function getuserDingdan(){
        @session_start();
//var_dump($_SESSION);exit;
        $sql="select * from dingdan WHERE user_id='{$_SESSION['user']['user_id']}'";
        $rows = $this->db->fetchAll($sql);
        return $rows;
    }
}