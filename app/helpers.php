<?php
/**
 * Created by ...
 * User: zhanghui
 * Date: 16/12/2
 * DesCription:...
 */
//创建文件 app/helpers.php
//composer dump-autoload
/**
 * 格式化打印函数
 * @param  [type] $arr [数组]
 * @return [type]      [description]
 */
if (!function_exists('p')) {
    function p($arr)
    {
        echo '<pre>';
        print_r($arr);
        echo '</pre>';
    }
}

if (!function_exists('uuid')) {
    function uuid($prefix = '')
    {
        $chars = md5(uniqid(mt_rand(), true));
        $uuid = substr($chars, 0, 8) . '-';
        $uuid .= substr($chars, 8, 4) . '-';
        $uuid .= substr($chars, 12, 4) . '-';
        $uuid .= substr($chars, 16, 4) . '-';
        $uuid .= substr($chars, 20, 12);
        return $prefix . $uuid;
    }
}

///**
// * 模拟post进行url请求
// * @param string $url
// * @param string $param
// */
//function request_post($url = '', $param = '') {
//    if (empty($url) || empty($param)) {
//        return false;
//    }
//
//    $postUrl = $url;
//    $curlPost = $param;
//    $ch = curl_init();//初始化curl
//    curl_setopt($ch, CURLOPT_URL,$postUrl);//抓取指定网页
//    curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
//    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
//    curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
//    curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
//    $data = curl_exec($ch);//运行curl
//    curl_close($ch);
//
//    return $data;
//}