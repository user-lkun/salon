<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2018/6/4
 * Time: 23:17
 */

namespace Application\Model;


use Framework\Model;

class XiaofeiModel extends Model
{
    public function getall(){
        @session_start();
//        var_dump($_COOKIE);exit;
        $user_id=$_SESSION['user']['user_id'];

        $sql="select * from histories WHERE user_id='{$user_id}'";
        $rows = $this->db->fetchAll($sql);

        return $rows;
    }
}