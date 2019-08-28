<?php

//构建积分商城扣积分请求测试
include 'duiba-sdk.php';
$requrl=$_SERVER['QUERY_STRING'];
$appKey='3gyWdRiPKkaMiiH6V3RUFybsdeDZ';//此处填写自己的appKey
$appSecret='4DEz67Z1VmzWVxUy5mVUnZoS2d8v';//此处填写自己的appSecret
$req_array = buildRequestParams($requrl);
$params = parseCreditConsume($appKey,$appSecret,$req_array);
$status = 'ok';//状态根据自己逻辑返回
$credits = '10000';//此处填写用户剩余积分
$errorMessage='';
$bizId='31213123';//此处开发者自己创建订单号，不要重复响应
$result = array ('credits'=>$credits,'status'=>$status,'bizId'=>$bizId,'errorMessage'=>$errorMessage);
print_r (json_encode($result));
?>
