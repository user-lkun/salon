<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/2 0002
 * Time: 上午 1:54
 */

namespace Application\Model;


use Framework\Model;

class GroupModel extends  Model
{
//查询员工表
    public function index($tiaojian = [], $page)
    {
        $where = '';
        //接收条件,根据条件判定implode将一个数组拼接成字符串
        if (!empty($tiaojian)) {
            $where = " where " . implode(' or ', $tiaojian);
        }
        //设定每页的查询条数
        $pagesize = 4;
        //查询总的条数
        $count = $this->db->fetchColumn("select count(*)  from  `group`  {$where}");
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
        $sql = "select * from `group` " . $where . $limit;
        //dump($sql);
        //>>2.执行sql
        $result = $this->db->fetchAll($sql);
        //需要将值全部返回出去
        return array('result' => $result, 'page' => $page, 'pagesize' => $pagesize, 'count' => $count, 'zongyeshu' => $zongyeshu);
    }
    //添加部门
    public  function  add($data)
    {
        //判断输入的用户名是否为空
        if (empty($data['name'])) {
            //保存错误信息
            $this->error = "用户名为空";
            return false;
        }

        //>>1.准备sql
        $sql = "insert into `group` set  name= '{$data['name']}'" ;


        //>>2.执行sql并返回结果
        return $result= $this->db->execute($sql);
    }
    //修改回显
    public  function  getone($id){
        $sql="select * from `group` where group_id={$id}";
        //执行sql并返回值
        $result = $this->db->fetchRow($sql);
        //返回值
        return $result;
    }
    //修改保存
    public  function  edite($data){


        $sql="update `group`set name='{$data['name']}' where group_id='{$data['id']}'";
        //执行
       return  $this->db->execute($sql);
    }
    //根据条件删除部门
    public  function  delete($id){

    //根据传入的id查询该部门是否员工
        $sql="select count(*) from  `members` where group_id='{$id}'";
        //执行sql
        $result=$this->db->fetchColumn($sql);
        if (!empty($result)){
            $this->error='不能删除拥有员工的部门';
            return false;
        }else {//有result的值可以返回
            $sql="delete from `group` where name='{$id}'";
            //执行sql并返回值
            return $this->db->execute($sql);
        }
    }
}