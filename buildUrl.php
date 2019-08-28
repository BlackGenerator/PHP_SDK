<?php

/**
 * 测试生成免登录url
 * 免登录地址涉及到的参数包含
 * $uid,$credits,$redirect,$dcustom,$transfer,$vip等参数
 */
include 'duiba-sdk.php';
$appKey = '3gyWdRiPKkaMiiH6V3RUFybsdeDZ';
$appSecret ='4DEz67Z1VmzWVxUy5mVUnZoS2d8v';
$uid = '111';
$credits="1000";
#$redirect="https://goods.m.duiba.com.cn/mobile/appItemDetail?appItemId=1422773";
#$transfer = urlencode("a=1&b=2");
#dcustom = urlencode("v=1&f=2");
#$params= array("uid"=>$uid,"credits"=>$credits,"redirect"=>$redirect,"transfer"=>$transfer,"dcustom"=>$dcustom);
$params= array("uid"=>$uid,"credits"=>$credits);
$url = "https://activity.m.duiba.com.cn/autoLogin/autologin?";
$autourl = buildUrlWithSign($url,$appKey,$appSecret, $params);
#echo $autourl;
header("Location:$autourl");
?>

