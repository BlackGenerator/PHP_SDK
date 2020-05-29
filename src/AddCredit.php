<?php


namespace DuiBa;


use Exception;

abstract class AddCredit implements HandlerInterface
{
    use Parse;
    use Credit;

    public static function handler(array $req_array)
    {
        try {
            self::parse(self::appKey, self::appSecret, $req_array);
            // 处理 积分消耗
            return (int)self::updateCredits($req_array);
//            return true;
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }

    /**
     *  兑换订单的结果通知请求的解析方法
     * @param string $appKey
     * @param string $appSecret
     * @param array $request_array
     * @return array
     * @throws Exception
     */
    private static function parse(string $appKey, string $appSecret, array $request_array)
    {
        $request_array['success'] = (boolean)$request_array['success'];
        self::check($appKey, $appSecret, $request_array);
        if (!isset($request_array["uid"]) && self::uidCheck($request_array["uid"])) {
            throw new Exception("uid not match");
        }
        if (!isset($request_array["credits"])) {
            throw new Exception("credits not match");
        }
        if (!isset($request_array["type"])) {
            throw new Exception("type not match");
        }
        if (!isset($request_array["orderNum"])) {
            throw new Exception("orderNum not match");
        }
        return $request_array;
    }
}