<?php
    /*
   *  md5签名，$array中务必包含 appSecret
   */
    function sign($array){
        ksort($array);
        $string="";
        while (list($key,$val) = each($array)){
            $string = $string . $val ;
        }
        return md5($string);
    }
    /*
    *  签名验证,通过签名验证的才能认为是合法的请求
    */
    function signVerify($appSecret,$array){
        $newarray=array();
        $newarray["appSecret"]=$appSecret;
        reset($array);
        while(list($key,$val) = each($array)){
            if($key != "sign" ){
                $newarray[$key]=$val;
            }
        }
        $sign=sign($newarray);
        if($sign == $array["sign"]){
            return true;
        }
        return false;
    }
    /*
    *构建URL
    */
    function AssembleUrl($url, $array)
    {
        unset($array['appSecret']);
        foreach ($array as $key=>$value) {
            $url=$url.$key."=".urlencode($value)."&";
        }
        return $url;
    }
    /*
    *  构建积分商城请求链接的方式方法
    */
    function buildUrlWithSign($url,$appKey,$appSecret,$params){
        $timestamp=time()*1000 . "";
        $params["appKey"]=$appKey;
        $params["timestamp"]=$timestamp;
        $params["appSecret"]=$appSecret;
        $sign=sign($params);
        $params['sign']=$sign;
        $url=AssembleUrl($url,$params);
        return $url;
    }
    /*
    *  积分消耗请求的解析方法
    *  当用户进行兑换时，兑吧会发起积分扣除请求，开发者收到请求后，可以通过此方法进行签名验证与解析，然后返回相应的格式
    *  返回格式为：
    *  {"status":"ok"，"credits":"10","bizId":"no123546","errorMessage":""}  或者
    *  {"status":"fail","credits":"10","errorMessage":"余额不足"}
    */
    function parseCreditConsume($appKey,$appSecret,$request_array){
        if($request_array["appKey"] != $appKey){
            throw new Exception("appKey not match");
        }
        if($request_array["timestamp"] == null ){
            throw new Exception("timestamp can't be null");
        }
        $verify=signVerify($appSecret,$request_array);
        if(!$verify){
            throw new Exception("sign verify fail");
        }
        $ret=$request_array;
        return $ret;
    }
    /*
    *  兑换订单的结果通知请求的解析方法
    *  当兑换订单成功时，兑吧会发送请求通知开发者，兑换订单的结果为成功或者失败，如果为失败，开发者需要将积分返还给用户
    */
    function parseCreditNotify($appKey,$appSecret,$request_array){
        if($request_array["appKey"] != $appKey){
            throw new Exception("appKey not match");
        }
        if($request_array["timestamp"] == null ){
            throw new Exception("timestamp can't be null");
        }
        $verify=signVerify($appSecret,$request_array);
        if(!$verify){
            throw new Exception("sign verify fail");
        }
        $ret=$request_array;
        return $ret;
    }

    /*
       *  虚拟商品充值请求的解析方法
       *  当用户兑换虚拟商品时，兑吧会发起虚拟商品充值请求，开发者收到请求后，可以通过此方法进行签名验证与解析，然后返回相应的格式
       *  返回格式为：
       *  成功：{"status":"success","credits":"10","supplierBizId":"no123546","errorMessage":""}
       *  处理中{"status":"process","credits":"10","supplierBizId":"no123546","errorMessage":""}
       * 失败：{"status":"fail","credits":"10","supplierBizId":"no123546","errorMessage":"余额不足"}
    */
    function parseVitrual($appKey,$appSecret,$request_array){
        if($request_array["appKey"] != $appKey){
            throw new Exception("appKey not match");
        }
        if($request_array["timestamp"] == null ){
            throw new Exception("timestamp can't be null");
        }
        $verify=signVerify($appSecret,$request_array);
        if(!$verify){
            throw new Exception("sign verify fail");
        }
        $ret=$request_array;
        return $ret;
    }

    /*
       *  加积分请求的解析方法
        *  返回格式为：
        *  {"status":"ok"，"credits":"10","bizId":"no123546","errorMessage":""}  或者
        *  {"status":"fail","credits":"10","errorMessage":"余额不足"}
    */
    function parseAddCredits($appKey,$appSecret,$request_array){
        if($request_array["appKey"] != $appKey){
            throw new Exception("appKey not match");
        }
        if($request_array["timestamp"] == null ){
            throw new Exception("timestamp can't be null");
        }
        $verify=signVerify($appSecret,$request_array);
        if(!$verify){
            throw new Exception("sign verify fail");
        }
        $ret=$request_array;
        return $ret;
    }

    /**
     * @param $requrl
     * @return array
     * 通过解析请求的url，封装成功params对象
     */
    function buildRequestParams($requrl){
        $arr = explode('&', $requrl);
        $params = array();
        foreach ($arr as $key => $val) {
            $arr = explode('=', $val);
            $params[$arr[0]] = urldecode($arr[1]);
        }
        return $params;
}


?>