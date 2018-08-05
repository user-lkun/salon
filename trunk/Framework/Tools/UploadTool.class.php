<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2018/5/25
 * Time: 11:09
 */

namespace Framework\Tools;


class UploadTool
{
    private $image_types=['image/jpeg','image/gif','image/png'];//允许的图片类型
    private $max_size=2*1024*1024;//图片的最大尺寸
    private $error;//保存错误信息
    public function getError(){
        return $this->error; //返回错误信息
    }
    public function upload($logo){
        //1.文件上传是否成功
        if ($logo['error']!=0 ){
            $this->error= "文件上传失败!";
            return false;
        }

//2.文件是否是被允许的类型

        if (!in_array($logo['type'],$this->image_types)){
            $this->error= "请上传jpeg/gif/png格式的图片文件!";
            return false;
        }
//3.文件的大小

        if ($logo['size']>$this->max_size){
            $this->error= "上传失败,文件过大!";
            return false;
        }
//4.是否通过http POST方式上传
        if (!is_uploaded_file($logo['tmp_name'])){
            $this->error= "不是通过HTTP POST上传!";
            return false;
        }

//后缀
        $suffix=strrchr($logo['name'],'.');
//唯一文件名
        $filename=uniqid();
//文件目录
        $dir='./Uploads/'.date('Ymd').'/';
        $fullfilename=$dir.$filename.$suffix;
//判断目录是否存在
        if (!is_dir($dir)){
            mkdir($dir,0777,true);
        }
//5.文件是否移动成功
        if (!@move_uploaded_file($logo['tmp_name'],$fullfilename)){
            $this->error= "移动文件失败!";
            return false;
        }
//6.上传文件成功
        return $fullfilename;
    }
}