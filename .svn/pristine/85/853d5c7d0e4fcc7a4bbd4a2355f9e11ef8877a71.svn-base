<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2018/6/3
 * Time: 13:43
 */

namespace Application\Model;


use Framework\Model;

class JifensysModel extends Model
{
    public function getAll($conditions,$page){
        $sql="select * from jifen ";
        $where ='';//没传收索条件给一个空
        if (!empty($conditions)){
            $where =" where ".implode(' and ',$conditions);
        }
        //分页处理
        //设置每页的显示条数  where xxx limit $start ,$leng;
        $leng=5;
        //获取总页数
        //获取数据库中的总数据条数
        $count=$this->db->fetchColumn("select count(*) from jifen ".$where);//分页时需要将搜索的条件加上,
        $totalPage=ceil($count/$leng);//总页数
        //判断
        $page=$page>$totalPage?$totalPage:$page;//页码不能大于总页数
        $page=$page<1?1:$page;//页码不能小于1
        $start = ($page - 1) * $leng;//起始页
        $limit=" limit {$start},{$leng}";
        $sql_all=$sql.$where." order by jifen_id desc ".$limit;
        $rows = $this->db->fetchAll($sql_all);


        foreach ($rows as &$val){
            $sql="select username from users WHERE user_id='{$val['user_id']}'";
            $username = $this->db->fetchColumn($sql);

            $val[].=$username;
        }
        $all_msg['rows']=$rows;
        //将分页信息保存在新数组中

        $all_msg['page']=$page;
        $all_msg['count']=$count;
        $all_msg['leng']=$leng;

        return $all_msg;
    }
}