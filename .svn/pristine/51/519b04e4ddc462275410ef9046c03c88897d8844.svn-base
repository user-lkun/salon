<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2018/5/25
 * Time: 13:14
 */

namespace Framework\Tools;


/**
 * 封装分页工具条
 * Class PageTool
 * @package Tools
 */
class PageTool
{
    //显示分页的方法
    /**
     * @param $count  总条数
     * @param $page  当前页数
     * @param $leng  每页显示条数
     * @param $url  连接
     * @return string
     */
    public static function show($count,$page,$leng,$url=''){
        if (empty($url)){
            unset($_REQUEST['page']);
//            $paramas=[];
//            foreach ($_REQUEST as $key=>$val){
//                $paramas[]="{$key}={$val}";
//            }
//            $url="?".implode('&',$paramas);
            $url="index.php?".http_build_query($_REQUEST);
        }
        $totalPage=ceil($count/$leng);
        $prePage=$page-1<1?1:($page-1);
        $nextPage=$page+1>$totalPage?$totalPage:($page+1);
        $html=<<<PAGE
<!-- 分页开始 -->
    <table id="page-table" cellspacing="0">
        <tbody>
            <tr>
                <td align="right" nowrap="true" style="background-color: rgb(255, 255, 255);">
                   
                    <div id="turn-page">
                        总计  <span id="totalRecords">{$count}</span>个记录分为 <span id="totalPages">{$totalPage}</span>页当前第 <span id="pageCurrent">{$page} </span>
                        页，每页 <input type="text" size="3" id="pageSize" value="{$leng}" onkeypress="return listTable.changePageSize(event)">
                        <span id="page-link">
                            <a href="{$url}&page=1">第一页</a>
                            <a href="{$url}&page={$prePage}">上一页</a>
                            <a href="{$url}&page={$nextPage}">下一页</a>
                            <a href="{$url}&page={$totalPage}">最末页</a>

                        </span>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <!-- 分页结束 -->
PAGE;
        return $html;
    }
}