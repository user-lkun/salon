<?php

namespace Framework;


/**
 * 基础模型类
 */
abstract class Model
{
    //可以让继承提交中的类都使用该属性.
    protected $db;
    //存放错误信息
    protected $error;

    public function __construct()
    {
        $this->db = \Framework\Tools\MysqlDb::getInstance($GLOBALS['config']['db']);
    }

    /**
     * 获取错误信息
     * @return mixed
     */
    public function getError()
    {
        return $this->error;
    }
}