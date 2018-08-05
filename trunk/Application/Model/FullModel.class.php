<?php
/**
 * Created by PhpStorm.
 * User: 35482
 * Date: 2018/6/3
 * Time: 13:21
 */

namespace Application\Model;


use Framework\Model;

class FullModel extends Model
{
    public function getall(){
        $fulllist=$this->db->fetchAll("select * from fullrule");
        foreach($fulllist as &$v){
            $sql="select username from users where user_id='{$v['user_id']}'";
            $a=$this->db->fetchColumn($sql);
            $v['user']=$a;
        }
        return $fulllist;
    }
    public function insert($data){

        $check=$this->db->fetchRow("select * from fullrule where user_id='{$data['user']}'");



        if($data['user']==$check['user_id']){
            if($data['full']==$check['full']||$data['give']==$check['give']){
                $this->error="相同用户,规则不能相同";
                return false;
            }
        }



        if(empty($data['full'])||empty($data['give'])){
            $this->error="充值金额或赠送金额不能为空";
            return false;
        }

        if($data['full']==$data['give']){
            $this->error="充值金额与赠送金额不能相同";
            return false;
        }
        if($data['full']<$data['give']){
            $this->error="赠送金额不能大于充值金额";
            return false;
        }



        $this->db->execute("insert into fullrule SET 
full='{$data['full']}',
give='{$data['give']}',
user_id='{$data['user']}'
");
    }
    public function update($data){
        $check=$this->db->fetchAll("select * from fullrule");

        foreach($check as $val){
            if($data['user_id']==$val['user_id']){
                if($data['full']==$val['full']&&$data['give']==$val['give']){
                    $this->error="相同用户,规则不能相同,请检查充值金额或赠送金额";
                    return false;
                }
            }
        }

        return $this->db->execute("update fullrule set 
full='{$data['full']}',
give='{$data['give']}'
where full_id='{$data['id']}'
");
    }
    public function getone($id){
        return $this->db->fetchRow("select * from fullrule where full_id='{$id}'");
    }
    public function getout($id){
         $this->db->execute("delete from fullrule where full_id='{$id}'");
    }
    public function getuser(){
        return $this->db->fetchAll("select * from users");
    }
    public function getiduser($userid){
        return $this->db->fetchRow("select * from users where user_id='{$userid}'");
    }
}