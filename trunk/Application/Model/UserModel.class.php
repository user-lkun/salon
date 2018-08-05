<?php
/**
 * Created by PhpStorm.
 * User: 35482
 * Date: 2018/6/1
 * Time: 19:35
 */

namespace Application\Model;


use Framework\Model;

class UserModel extends Model
{
    //获取所有信息
    //分页搜索
    public function getall($sex,$conditions, $page)
    {

        $sql   = "select * from users";
        $where = "";//没传收索条件给一个空
        if (empty($conditions)&&!empty($sex)) {
            $where = " where " . $sex;
        }elseif(!empty($conditions)&&!empty($sex)){
            $where = " where " . implode(" or ", $conditions)." and ". $sex ;
        }elseif(!empty($conditions)&&empty($sex)){
            $where = " where " . implode(" or ", $conditions);
        }




        //分页处理
        //设置每页的显示条数  where xxx limit $start ,$leng;
        $leng = 5;
        //获取总页数
        //获取数据库中的总数据条数
        $count     = $this->db->fetchColumn("select count(*) from users ".$where);//分页时需要将搜索的条件加上,

        $totalPage = ceil($count / $leng);//总页数
        //判断
        $page  = $page > $totalPage ? $totalPage : $page;//页码不能大于总页数
        $page  = $page < 1 ? 1 : $page;//页码不能小于1
        $start = ($page - 1) * $leng;//起始页
        $limit = " limit {$start},{$leng}";
        $rows  = $this->db->fetchAll($sql . $where . $limit);

        $all_msg['rows'] = $rows;
        //将分页信息保存在新数组中
        $all_msg['page']  = $page;
        $all_msg['count'] = $count;
        $all_msg['leng']  = $leng;
        return $all_msg;
    }

    //获取一条信息
    public function getone($id){
        return $this->db->fetchRow("select * from users where user_id='{$id}'");
    }

    //注册,添加会员
    public function register($data)
    {
        //常识判断
        //搜索与传过来的用户名相同的用户名,如果有判断失败;
        $showuser = $this->db->fetchRow("select username from users where username='{$data['username']}'");
        if (isset($showuser['username'])) {
            $this->error = "用户名已被注册,请重新输入";
            return false;
        }

        if (empty($data['username']) || empty($data['realname'])) {
            $this->error = "用户名和真实姓名不能为空";
            return false;
        }
        if (empty($data['telephone'])) {
            $this->error = "手机号码不能为空";
            return false;
        }
        if ($data['password'] != $data['repassword']) {
            $this->error = "确认密码不正确";
            return false;
        }
        //结束

        //头像为空默认头像
        if (empty($data['photo'])) {
            $data['photo'] = "./Public/default.png";
        }
        if (empty($data['remark'])) {
            $data['remark'] = "无";
        }

        $password = md5($data['password']);

        return $this->db->execute("insert into users(`username`,`password`,`realname`,`sex`,`telephone`,`photo`,`remark`)VALUES(
'{$data['username']}',
'{$password}',
'{$data['realname']}',
'{$data['sex']}',
'{$data['telephone']}',
'{$data['photo']}',
'{$data['remark']}'
)");

    }

    //修改编辑会员
    public function update($data)
    {
        $showone = $this->db->fetchRow("select * from users where user_id='{$data['id']}'");
        //搜索用户名,不为传过来的用户名且id不为当前id的值,判断传过来的值是否和搜索的值重合;
        $showuser = $this->db->fetchRow("select username from users where username!='{$data['username']}' and user_id!='{$data['id']}'");

        if (empty($data['username'])) {
            $this->error = "用户名不能为空";
            return false;
        }

        if (!isset($showuser['username'])) {
            $this->error = "用户名已被注册,请重新输入";
            return false;
        }



        //头像为空默认头像
        //数据库头像为空且传过来的也为空给默认头像
        if (empty($showone['photo']) && empty($data['photo'])) {
            $data['photo'] = "./Public/default.png";
        }
        //数据库不为空,且传过来的为空,将传过来的改成数据库的头像
        if (!empty($showone['photo']) && empty($data['photo'])) {
            $data['photo'] = $showone['photo'];
        }


        //原密码不为空时修改密码,为空时不修改;
        if (!empty($data['password'])) {
            $oldpassword = md5($data['password']);
            if ($showone['password'] != $oldpassword) {
                $this->error = "原密码错误,请重新输入";
                return false;
            }
            if (empty($data['newpassword']) || empty($data['repassword'])) {
                $this->error = "新密码不能为空";
                return false;
            }
            if ($data['newpassword'] != $data['repassword']) {
                $this->error = "新密码不一致,重新输入";
                return false;
            }

            $newpassword = md5($data['newpassword']);
            if ($newpassword == $showone['password']) {
                $this->error = "不能与原密码一致";
                return false;
            }

            $sql = "update users set 
username='{$data['username']}',
password='{$newpassword}',
realname='{$data['realname']}',
telephone='{$data['telephone']}',
remark='{$data['remark']}',
money='{$data['money']}',
sex='{$data['sex']}',
photo='{$data['photo']}'
 where user_id='{$data['id']}'
";
        } else {
            $sql = "update users set 
username='{$data['username']}',
realname='{$data['realname']}',
telephone='{$data['telephone']}',
remark='{$data['remark']}',
money='{$data['money']}',
sex='{$sex}',
photo='{$data['photo']}'
 where user_id='{$data['id']}'
";
        }

        return $this->db->execute($sql);
    }

    //删除会员
    public function getout($id){
        $sesion=$this->db->fetchRow("select user_id from histories where user_id='{$id}'");
        if(isset($sesion)){
            $this->error="有消费记录不能删除";
            return false;
        }else{
            $this->db->execute("delete from users where user_id='{$id}'");
        }


    }

    //会员登录
    public function checklogin($data)
    {
        $first = $this->db->fetchRow("select * from users where username='{$data['username']}'");
        @session_start();
        if (strtolower($data['captcha']) != strtolower($_SESSION['captcha'])) {
            $this->error = "验证码不正确";
            return false;
        }
        if (empty($first)) {
            $this->error = "用户名不存在,或密码错误";
            return false;
        }
        $password = md5($data['password']);
        if ($password != $first['password']) {
            $this->error = "密码错误";
            return false;
        }
        return $first;
    }

    //充值
    public function moneyin($data)
    {
        @session_start();
        $money = $data['money'];
        if (!is_numeric($money)) {
            $this->error = "请输入数字";
            return false;
        }
        if (empty($money) || $money < 0) {
            $this->error = "充值金额不能为0";
            return false;
        }
//按传过来的user_id获取USERS表的用户信息
        $userlist = $this->db->fetchAll("select * from users where user_id='{$data['id']}'");

        //每冲500VIp+1
        foreach ($userlist as $v) {
            $vip = $v['is_vip'];
            if ($money < 500) {
                $vip = $vip + 0;
            } else {
                $vip = $vip + floor($money / 500);
            }
            if ($vip > 10) {
                $vip = 10;
            }
        }


        $this->db->execute("update users set is_vip='{$vip}' where user_id='{$data['id']}' ");


//获取规则表里的与用户名相同id的规则
        $rule = $this->db->fetchColumn("select give from fullrule where full<='{$money}'and user_id='{$data['id']}' order by full desc limit 1 ");
        //user增加的金额为充值+赠送
        $money = $money + $rule;
        //USERS表的余额=当前余额+充值金额+赠送
        foreach ($userlist as $val) {

            $nowmoney = $val['money'] + $money;
        }
        //充值后修改user当前金额
        $this->db->execute("update users set money='{$nowmoney}' where user_id='{$data['id']}'");
        //查询histories信息,获取当前余额
        $time = time();
        $this->db->execute("insert into histories
 set
 user_id='{$data['id']}',
 members_id='{$_SESSION['xinxi']['members_id']}',
`type`=2,
amount='{$money}',
remainder='{$nowmoney}',
content='充值了''{$money}''元',
`time`='{$time}'
");
    }

    //查询套餐
    public function getplans(){
        return $this->db->fetchAll("select * from plans where status=1");
    }

    //查询员工
    public function getmember(){
        return $this->db->fetchAll("select * from members");
    }

    //查询代金券
    public function getcode($id)
    {
        $codes = $this->db->fetchAll("select * from codes where user_id='{$id}'");
        foreach ($codes as
        &$val) {
            if (empty($val['code'])) {
                $val['code'] = "无代金券";
            }

        }

        return $codes;
    }

    //消费
    public function moneyout($data)
    {
        $codename  = substr($data['code'], 0, 14);
        $codemoney = substr($data['code'], 14);

        //$z=isvip-(isvip/2);
        //通过当前用户id搜索users vip等级
        $forvip = $this->db->fetchRow("select is_vip from users where user_id='{$data['id']}'");
        $vip    = $forvip['is_vip'];
        //通过规律计算出折扣值
        $discount = ($vip - $vip / 2) / 10;


        $this->db->fetchRow("select is_vip from users where user_id='{$data['id']}'");
        @session_start();
        //套餐和服务员工必选，代金券可选
        if (empty($data['plansmoney']) || empty($data['members_id'])) {
            $this->error = "请选择套餐和服务人员";
            return false;
        }
        //如果代金券为空则为0
        if (empty($data['code'])) {
            $codemoney = 0;
        }


        //按传过来的user_id获取USERS表的用户信息,获取用户的余额
        $userlist = $this->db->fetchRow("select * from users where user_id='{$data['id']}'");

        //获取套餐金额
        $plansmoney = $data['plansmoney'];


        //会员的余额必须大于套餐金额才能消费。
        if ($userlist['money'] < $plansmoney) {
            $this->error = "余额不足,无法消费";
            return false;
        }
        //最后消费金额=如果不使用代金券就打折
        if (empty($data['code'])) {
            $paymoney = $plansmoney-($plansmoney * $discount);//套餐价格 乘以 折扣float
        } else {

            //如果套餐金额大于等于代金券金额

            $paymoney = $plansmoney - $codemoney;//套餐价格 减 代金券金额
            //小于等于0时,意为代金券比套餐金额大保存代金券剩余值到代金券
            if ($paymoney <= 0) {
                $paymoney = abs($paymoney);
                $this->db->execute("update codes set money='{$paymoney}' where code='{$codename}'");
            } else {
                //大于0意为代金券用完,删除使用的代金券
                $this->db->execute("delete from codes where code='{$codename}'");
            }

            //使用代金券后将状态改为已使用
            $this->db->execute("update codes set status=1
where user_id='{$data['id']}' and code='{$codename}'
");
        }
        if ($paymoney < 0) {
            $paymoney = 0;
        }
        //当前用户余额=用户的余额减去(套餐消费金额减去代金券 或 打过折扣).
        $nowmoney = $userlist['money'] - $paymoney;


        //消费完成后修改会员的余额
        $this->db->execute("update users set money=$nowmoney where user_id ='{$data['id']}'");
//会员每消费一次都需要新增一条信息到日志表histories里面
        $time = time();
        $this->db->execute("insert into histories set
 user_id='{$data['id']}',
 members_id='{$data['members_id']}',
 type=+1,
 amount='{$paymoney}',
 content='消费了{$paymoney}',
 time='{$time}',
 remainder='{$nowmoney}' 
");
        //查询积分表当前用户剩余积分
        $jifennow = $this->db->fetchRow("select jifen from jifen where user_id='{$data['id']}' order by jifen_id desc");

        //剩余积分加上赠送的积分,插入新的记录
        $restjifen = $jifennow['jifen'] + $paymoney;


        $this->db->execute("insert into jifen set 
jifen='{$restjifen}',
user_id='{$data['id']}',
record='通过消费赠送了''{$paymoney}''积分'
");
        //创建会员的同时插入积分表,删除时删除积分表
        //消费只做修改


    }
    //导出,为导出获取信息
    public function popout(){
        $sql="select * from users";
        return $this->db->fetchAll($sql);
    }


}