<?php
require 'vendor/autoload.php';

function sign(array $array)
{
    ksort($array);
    return md5(array_reduce($array, function ($carry, $item) {
        return $carry . $item;
    }));
}

$p = ['actualPrice'=>0,
    'ip'=>'192.168.1.100',
    'orderNum'=>'order-for-test-1477390592222',
    'description'=>'测试专用优惠券',
    'waitAudit'=>true,
    'params'=>null,
    'type'=>'coupon',
    'uid'=>'test001',
    'paramsTest68'=>68,
    'credits'=>500,
    'facePrice'=>0,
    'appKey'=>'H15Bo94UnxwnJKDnFbZDaPJucYR',
    'appSecret'=>'35YL816ZZn9W13XWqtT1JtDi5dWD',
    'timestamp'=>time()*1000];
$p['sign'] = sign($p);
var_dump(  (new class() extends \DuiBa\AddCredit {
    /**
     * @param $params
     * @return
     */
    private static function updateCredits($params)
    {
        // 积分。
        return 10;
    }
})::handler($p));
