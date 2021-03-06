<?php
/**
 * Created by PhpStorm.
 * User: 35482
 * Date: 2018/6/2
 * Time: 13:13
 */

namespace Application\Model;


use Framework\Model;

class HistoriesModel extends Model
{

    public function getall($conditions,$page){
        $sql="select * from histories";
        $where ="";//没传收索条件给一个空
        if (!empty($conditions)){
            $where =" where ".implode(" and ",$conditions);
        }
        //分页处理
        //设置每页的显示条数  where xxx limit $start ,$leng;
        $leng=5;
        //获取总页数
        //获取数据库中的总数据条数
        $count=$this->db->fetchColumn("select count(*) from histories ".$where);//分页时需要将搜索的条件加上,
        $totalPage=ceil($count/$leng);//总页数
        //判断
        $page=$page>$totalPage?$totalPage:$page;//页码不能大于总页数
        $page=$page<1?1:$page;//页码不能小于1
        $start = ($page - 1) * $leng;//起始页
        $limit=" limit {$start},{$leng}";
        $list=$this->db->fetchAll($sql.$where." order by history_id desc ".$limit);
        foreach($list as &$v){
            $sql="select `username` from `users` where user_id='{$v['user_id']}'";
            $a=$this->db->fetchColumn($sql);
            $v['user']=$a;
        }
        foreach($list as &$u){
            $sql="select `username` from `members` where
members_id='{$u['members_id']}'";
            $b=$this->db->fetchColumn($sql);
            $u['member']=$b;
        }
        $all_msg['list']=$list;
        //将分页信息保存在新数组中
        $all_msg['page']=$page;
        $all_msg['count']=$count;
        $all_msg['leng']=$leng;
        return $all_msg;

    }
}