<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2018/6/2
 * Time: 22:53
 */

namespace Application\Controller\Home;


use Application\Model\RankingModel;
use Framework\Controller;
use Framework\Tools\PlatformController;

class RankingController extends Controller
{


    public function index()
    {
        @session_start();
//充值排行前三
        $ranks = new RankingModel();
        $all_msg = $ranks->rank();
        $this->assign('all_msg', $all_msg);
        $this->display('rank');
    }
}