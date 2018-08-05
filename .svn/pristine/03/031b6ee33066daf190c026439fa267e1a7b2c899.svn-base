<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/29 0029
 * Time: 上午 9:52
 */

namespace Application\Controller\Admin;


use Framework\Controller;

class YanzhengmaController extends  Controller
{//z制作验证码

    public function yanzhenma()
    {//更具原图值卓验证
        //制作随机字符串
        $a='123456789';
        $b='QWERTYUIOPLKJHGFDSAZXCVBNM';
        $zi=$a.$b;
        //打乱字符串
        $zifu=str_shuffle($zi);
        //截取字符串并保存到session中
        $zifuchuan=substr($zifu,1,4);
        @session_start();
        $_SESSION['yanzhenma']=$zifuchuan;
        //制作验证码
        $yuantu=PUBLIC_PATH.'Admin/denglu/captcha/captcha_bg'.mt_rand(1,5).'.jpg';
        //制作画布
        $image=imagecreatefromjpeg($yuantu);
        //获取原图高宽
        $size=getimagesize($yuantu);
        //自动分配高宽
        list($with,$height)=$size;
        //创建字体颜色
        $red=imagecolorallocate($image,255,0,0);
        $blue=imagecolorallocate($image,0,0,255);
        $white=imagecolorallocate($image,255,255,255);
        $yanse=[$red,$blue,$white];
        //将字符串输入图片中
        imagettftext($image,14,0,$with/3,$height/1.5,$yanse[mt_rand(0,2)],PUBLIC_PATH.'Admin/ygyxsziti2.0.ttf',$zifuchuan);
        //保存验证码和关闭图片
//输出图片
        imagejpeg($image);
        header("Content-type:image/jpeg");
        //关闭图片
        imagedestroy($image);
    }
}
