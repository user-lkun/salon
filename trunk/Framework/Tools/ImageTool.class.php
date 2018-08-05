<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2018/5/25
 * Time: 11:54
 */

namespace Framework\Tools;


/**
 * 图片处理工具
 * Class ImageTool
 * @package Tools
 */
class ImageTool
{
    private $error;
    public function getError(){
        return $this->error;
    }

    /**
     * 制作缩略图
     * @param $logo_path   原图地址
     * @param $thumb_width
     * @param $thumb_height
     * @return string
     */
    public function thumb($logo_path){
        //1.准备原图
//        var_dump($logo_path);exit();
//        string(35) "./Upload/20180520/5b015b704b9d1.jpg"
//        $src_path="./1024x768.jpg";
        if (!is_file($logo_path)){
            $this->error="原图片不存在!";
            return false;
        }
        $size=getimagesize($logo_path);
        list($width,$height) = $size;
        //获取传过来的图片格式
        $suffix = explode('/',$size['mime'])[1];
        $new_create="imagecreatefrom".$suffix;
        $src_image = $new_create($logo_path);
//2.准备新画布
     $thumb_width=100;
       $thumb_height=100;
        $thumb_image=imagecreatetruecolor($thumb_width,$thumb_height);
        //设置背景颜色
        $color = imagecolorallocate($thumb_image,255,255,255);
        imagefill($thumb_image,0,0,$color);
//3.将原图拷贝到新画布
        //按等比例进行缩放 缩放的比例值 == 宽/高的最大缩放比
        $values_width=$width/$thumb_width;
        $values_height=$height/$thumb_height;
        //最大缩放比例
        $values = max($values_width,$values_height);

        //计算目标图片使用多宽多高保存原图,缩放后 宽高的大小
        $later_width=$width/$values;
        $later_height=$height/$values;
        //目标图起始坐标
        $start_width=($thumb_width-$later_width)/2;
        $start_height=($thumb_height-$later_height)/2;
        //* 重采样拷贝部分图片并调整大小
        //* bool imagecopyresampled
//        (
//         *      resource $dst_image , 目标图片资源
//        *      resource $src_image , 原图资源
//        *      int $dst_x , int $dst_y , 目标图片的起始坐标位置开始存放原图
//        *      int $src_x , int $src_y , 原图的起始位置,从该位置开始拷贝图片
//        *      int $dst_w , int $dst_h , 目标图片的宽高,使用目标图片的多宽多高保存原图
//        *      int $src_w , int $src_h   原图的宽高,表示拷贝原图的多宽多高
//        * )
        imagecopyresampled($thumb_image,$src_image,$start_width,$start_height,0,0,$later_width,$later_height,$width,$height);
//4.保存新图(地址) 和原图保存在相同的地址下面  5afefa568482b.gif--->5afefa568482b_100x100.gif
//        header('Content-type:image/jpeg');
        $path=pathinfo($logo_path);//pathinfo() 函数,获取路径信息
//后缀
//        $suffix=strrchr($logo_path,'.');
//          $suffix=$path['extension'];
//唯一文件名
        $filename=$path['filename'];
//文件目录
        $dir=$path['dirname'];
        $fullfilename=$dir.'/'.$filename."_{$thumb_width}x{$thumb_height}.".$suffix;
//拼接输出函数
        $new_out="image".$suffix;
        $new_out($thumb_image,$fullfilename);
//5.关闭新图和地址
        imagedestroy($thumb_image);
        imagedestroy($src_image);
//6.返回缩略图路径
        return $fullfilename;
    }

}