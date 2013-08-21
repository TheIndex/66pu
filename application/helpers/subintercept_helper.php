<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Lion
 * Date: 13-8-7
 * Time: 下午5:44
 * To change this template use File | Settings | File Templates.
 */

/**
 * 中文字符串的截取
 *
 * @access: public
 * @author: linyong
 * @param: string，$str，原字符串
 * @param: int，$len ，截取的长度
 * @return: string
 */
function utf_substr($str,$len){
    for($i=0;$i<$len;$i++){
        $temp_str=substr($str,0,1);
        if(ord($temp_str) > 127){
            $i++;
            if($i<$len){
                $new_str[]=substr($str,0,3);
                $str=substr($str,3);
            }
        }else{
            $new_str[]=substr($str,0,1);
            $str=substr($str,1);
        }
    }
    return join("",$new_str);
}
