<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2018/6/2
 * Time: 23:41
 */

namespace Application\Model;


use Framework\Model;

class RankingModel extends Model
{
    public function rank(){
        $all_msg=[];//空数组存放 消费  充值  服务 前三名的信息
        //求出充值排行前三的金额跟会员名
        $sql="SELECT sum(amount) as sum from histories WHERE type=1 GROUP BY user_id ORDER BY sum desc limit 3";
        $rechar = $this->db->fetchAll($sql);

        foreach ($rechar as &$val){
            $sql="SELECT sum(amount) as sum,user_id from histories WHERE type=1 GROUP BY user_id  HAVING sum='{$val['sum']}'";
            $res = $this->db->fetchRow($sql);
            $sql="select username from users WHERE user_id='{$res['user_id']}'";
            $username = $this->db->fetchColumn($sql);
            $val[].=$username;
        }
            $all_msg['rechar']=$rechar;



        //求出消费排行前三的金额跟会员名

        $sql="SELECT sum(amount) as sum from histories WHERE type=2 GROUP BY user_id ORDER BY sum desc limit 3";
        $xiaofei = $this->db->fetchAll($sql);

        foreach ($xiaofei as &$v){
            $sql="SELECT sum(amount) as sum,user_id from histories WHERE type=2 GROUP BY user_id  HAVING sum='{$v['sum']}'";
            $res = $this->db->fetchRow($sql);

            $sql="select username from users WHERE user_id='{$res['user_id']}'";
            $username = $this->db->fetchColumn($sql);
            $v[].=$username;
        }
        $all_msg['xiaofei']=$xiaofei;


        //求出服务排行前三的次数跟员工名
        $sql="SELECT count(*) as count from histories GROUP BY members_id ORDER BY count desc limit 3";
        $servers = $this->db->fetchAll($sql);

        foreach ($servers as &$v){
            $sql="SELECT count(*) as count, members_id  from histories GROUP BY members_id HAVING count='{$v['count']}'";
            $res = $this->db->fetchRow($sql);

            $sql="select username from members WHERE members_id='{$res['members_id']}'";
            $username = $this->db->fetchColumn($sql);
            $v[].=$username;
        }
        $all_msg['servers']=$servers;
        return $all_msg;

    }
}