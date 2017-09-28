<?php
session_start();

$d = $_POST['data'];//这里获取的直接就是数组了，不需要用到json_decode
echo $d['code'];
$_SESSION['value']=$d['code'];
//print_r($d);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://sms-api.luosimao.com/v1/send.json");

curl_setopt($ch, CURLOPT_HTTP_VERSION  , CURL_HTTP_VERSION_1_0 );
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 8);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);

curl_setopt($ch, CURLOPT_HTTPAUTH , CURLAUTH_BASIC);
curl_setopt($ch, CURLOPT_USERPWD  , 'api:4efc7922b1bc90b949a2fa073519eb61');

curl_setopt($ch, CURLOPT_POST, TRUE);
curl_setopt($ch, CURLOPT_POSTFIELDS, array('mobile' => $d['tel'],'message' => "验证码：{$d['code']}【迈德科技】"));

$res = curl_exec( $ch );
curl_close( $ch );
//$res  = curl_error( $ch );
var_dump($res);






