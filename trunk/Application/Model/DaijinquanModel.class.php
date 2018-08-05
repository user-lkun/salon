<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2018/6/2
 * Time: 10:53
 */

namespace Application\Model;


use Framework\Model;

class DaijinquanModel extends Model
{
    public function getName(){
        $sql="select username ,user_id from users";
        $rows = $this->db->fetchAll($sql);
        return $rows;
    }
    public function getList($conditions,$page){
        $sql = "select * from codes";
        $where ='';//没传收索条件给一个空
        if (!empty($conditions)){
            $where =" where ".implode(' and ',$conditions);
        }

        //分页处理
        //设置每页的显示条数  where xxx limit $start ,$leng;
        $leng=5;
        //获取总页数
        //获取数据库中的总数据条数
        $count=$this->db->fetchColumn("select count(*) from codes ".$where);//分页时需要将搜索的条件加上,
        $totalPage=ceil($count/$leng);//总页数
//        判断
        $page=$page>$totalPage?$totalPage:$page;//页码不能大于总页数
        $page=$page<1?1:$page;//页码不能小于1
        $start = ($page - 1) * $leng;//起始页
        $limit=" limit {$start},{$leng}";
        $order=" order by code_id desc";
        $rows = $this->db->fetchAll($sql.$where.$order.$limit);
//通过code_id  查询出username
       foreach ($rows as &$val){
           $sql="select username from users WHERE user_id='{$val['user_id']}'";
           $val['username'] = $this->db->fetchColumn($sql);
       }

        $all_msg['rows']=$rows;
        //将分页信息保存在新数组中
        $all_msg['page']=$page;
        $all_msg['count']=$count;
        $all_msg['leng']=$leng;
        return $all_msg;

    }
    public function insert($money,$code){

        foreach ($code as $v) {
            $sql="insert into codes set code='{$v}',money='{$money}' ";

            $res = $this->db->execute($sql);
        }
        return $res;

    }
    public function getOne($code_id){
        $sql="select * from codes WHERE code_id='{$code_id}'";
        $res = $this->db->fetchRow($sql);
        return $res;
    }
    public function update($data){

        $sql="update codes set 
money='{$data['money']}',
user_id='{$data['user_id']}',
status='{$data['status']}'
 WHERE code_id='{$data['code_id']}'";
        $res = $this->db->execute($sql);
        return $res;
    }
    public function delete($code_id){
        $sql="select status from codes WHERE code_id='{$code_id}'";
        $res = $this->db->fetchRow($sql);

        if ($res['status']==0){
            $this->error = '代金券未使用,不能删除!';
            return false;
        }else{
            $sql="delete from codes WHERE code_id='{$code_id}'";
            $res = $this->db->execute($sql);
            return $res;
        }


    }
}