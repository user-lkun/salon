<?php
/**
 * Created by PhpStorm.
 * User: 35482
 * Date: 2018/5/29
 * Time: 10:35
 */

namespace Application\Controller\Home;


use Framework\Controller;

class CaptchaController extends Controller
{
    public function create(){
        //创建随机字符串
        $string="abcdefghjklmnpqrstuvwxy3456789";
        $mix=str_shuffle($string);
        $str=substr($mix,-4);
        //打乱后保存到session
        @session_start();
        $_SESSION['captcha']=$str;
        //创建图片
        //1. 图片路径
        $image_path="./Public/Home/captcha/pn".mt_rand(1,3).".png";
        //2.动态获取宽高
        $size=getimagesize($image_path);
        list($width,$height)=$size;
        $image=imagecreatefrompng($image_path);
        //3.调整颜色
        $black=imagecolorallocate($image,0,0,0);
        $white=imagecolorallocate($image,255,255,255);
        $darkpurple=imagecolorallocate($image,131,6,255);
        $fontcolor=[$white,$black];
        //4.将字符串写到图片
        imagettftext($image,28,0,$width/3.7,$height/1.2,$fontcolor[mt_rand(0,1)],"./Public/Home/fonts/ygyxsziti2.0.ttf",$str);
        //5.优化图片
        imageline($image,mt_rand(1,$width-2),mt_rand(2,$height-3),mt_rand(2,$width-1),mt_rand(3,$height-1),$darkpurple);
        imagerectangle($image,0,0,$width/1,$height/1,$white);
        for($i=1;$i<=100;$i++){
            imagesetpixel($image,mt_rand(1,$width-1),mt_rand(1,$height-1),$black);
        }
        //将图片输出
        header("content-type:image/png");
        imagepng($image);
        //摧毁
        imagedestroy($image);




    }
}