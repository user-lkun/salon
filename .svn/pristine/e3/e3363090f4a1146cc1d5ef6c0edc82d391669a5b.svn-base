<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/3 0003
 * Time: 下午 2:21
 */

namespace Application\Model;


use Framework\Model;

class ShopModel extends Model
{//后台先添加积分商品
    public function add($data)
    {
        //判断输入的sahngpin名是否为空
        if (empty($data['name'])) {
            //保存错误信息
            $this->error = "商品名不能为空";
            return false;
        }
        //需要积分
        if (empty($data['number'])) {
            //保存错误信息
            $this->error = "积分不足";
            return false;
        }
        //剩余库存
        if ($data['kucun']<=0) {
            //保存错误信息
            $this->error = "库存不足";
            return false;
        }
        //图片路径
        if (empty($data['logo'])) {
            //保存错误信息
            $this->error = "请上传图片";
            return false;
        }
// //写sql
        $sql = "insert into `shop`(`name`,`number`,kucun,logo,img) VALUES (
'{$data['name']}',
'{$data['number']}',
'{$data['kucun']}',
'{$data['logo']}',
'{$data['img']}'
)";
//执行sql
        return $this->db->execute($sql);
    }
    //查询商品图片(后台)
    public  function  index($tiaojian=[],$page){
        $where = '';
        //接收条件,根据条件判定implode将一个数组拼接成字符串
        if (!empty($tiaojian)) {
            $where = " where " . implode(' and ', $tiaojian);
        }
        //设定每页的查询条数
        $pagesize = 4;
        //查询总的条数
        $count = $this->db->fetchColumn("select count(*)  from  `shop`  {$where}");
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
        $sql = "select * from `shop` " . $where . $limit;
        //dump($sql);
        //>>2.执行sql
        $result = $this->db->fetchAll($sql);
        //需要将值全部返回出去
        return array('result' => $result, 'page' => $page, 'pagesize' => $pagesize, 'count' => $count, 'zongyeshu' => $zongyeshu);
    }
    //根据传入的id,查询
    public  function  getone($id){
        $sql = "select *from `shop` where shop_id={$id}";
        //执行sql并返回值
        $result = $this->db->fetchRow($sql);
        //返回值
        return $result;

    }
    //修改保存
    public function edit($data)
    {
        //判断输入的sahngpin名是否为空
        if (empty($data['name'])) {
            //保存错误信息
            $this->error = "商品名不能为空";
            return false;
        }
        //需要积分
        if (empty($data['number'])) {
            //保存错误信息
            $this->error = "积分不足";
            return false;
        }
        //剩余库存
        if ($data['kucun']<=0) {
            //保存错误信息
            $this->error = "库存不足";
            return false;
        }
        //图片路径
        if (empty($data['logo'])) {
            //保存错误信息
            $this->error = "请上传图片";
            return false;
        }
        $sql = "update `shop` set 
name='{$data['name']}',
`number`='{$data['number']}',
kucun='{$data['kucun']}'";
        if(isset($data['logo'])){
            $sql .= ",logo='{$data['logo']}'";
        }
        if(isset($data['img'])){
            $sql .= ",img='{$data['img']}'";
        }
        $sql .= " WHERE shop_id={$data['id']}";
        //>>2.执行sql
        return $this->db->execute($sql);
    }
    //删除管理员
    public function delete($id)
    {
        $sql = "delete from  `shop` where shop_id='{$id}'";
        //执行sql
        $this->db->execute($sql);
    }
    //查询商品(前端)
    public  function  home($tiaojian=[],$page){
        $where = '';
        //接收条件,根据条件判定implode将一个数组拼接成字符串
        if (!empty($tiaojian)) {
            $where = " where " . implode(' and ', $tiaojian);
        }
        //设定每页的查询条数
        $pagesize = 9;
        //查询总的条数
        $count = $this->db->fetchColumn("select count(*)  from  `shop`  {$where}");
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
        $sql = "select * from `shop` " . $where . $limit;
        //dump($sql);
        //>>2.执行sql
        $result = $this->db->fetchAll($sql);
        //需要将值全部返回出去
        return array('result' => $result, 'page' => $page, 'pagesize' => $pagesize, 'count' => $count, 'zongyeshu' => $zongyeshu);
    }
    //积分对换商品查询
    public  function  jifen($jifen,$brand,$kucun){
        //1,通过session中的用户信息查询到用户的积分
  @session_start();
  $user_id=$_SESSION['user']['user_id'];
  $result=$this->db->fetchRow("select jifen from `jifen` where user_id='{$user_id}' order by
jifen_id DESC ");
  if (empty($result)){
      $result['jifen']=0;
  }
  //如果用户积分小于商品积分不能对换,$result['jifen}为用户拥有的积分
        if ($result['jifen']<$jifen){
            $this->error='积分不足';
            return false;
        }//积分足够减去所需积分,将剩余积分保存进积分系统,填写消费信息
        $overjifen=$result['jifen']-$jifen;
        $record='商品兑换使用'.$jifen.'积分';
        $a= $this->db->execute("insert into `jifen` (user_id,jifen,record) VALUES ('$user_id', '$overjifen', '$record')");
       //修改积分商城的库存
        $xinkucun=$kucun-1;
        $d= $this->db->execute("update `shop` set kucun='{$xinkucun}' where `name`='{$brand}'");
        //兑换后生成订单
        //生成订单时间
        $time=time();
        $sql="insert into `dingdan`(user_id,brand,`jifen`,order_time) VALUES ('{$user_id}','{$brand}','{$jifen}','{$time}')";
        $b=$this->db->execute($sql);
    }
    //查询用户积分
    public  function  user($id){
        return $this->db->fetchColumn("select jifen from `jifen` where user_id='{$id}' order by jifen_id desc ");
    }
}