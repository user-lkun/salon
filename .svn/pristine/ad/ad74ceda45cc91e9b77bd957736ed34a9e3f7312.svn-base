<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/29 0029
 * Time: 下午 7:30
 */

namespace Application\Model;

use Framework\Model;

class PlatformModel extends Model
{
//根据传入的管理员名字查询值(后台)
    public  function  tongyiyanzhen($id,$password){
        //sql
        $sql="select * from `members` WHERE  members_id='{$id}'";
        //执行sql
        $result=$this->db->fetchRow($sql);
        //判断密码是否相同
        if ($password!=$result['password']){
            return false;
        }
        //返回值
        return  $result;

    }
    public  function  qiantaiyanzheng($id,$password){
        //sql
        $sql="select * from `users` WHERE  user_id='{$id}'";
        //执行sql
        $result=$this->db->fetchRow($sql);
        //判断密码是否相同
        if ($password!=$result['password']){
            return false;
        }
        //返回值
        return  $result;

    }
}