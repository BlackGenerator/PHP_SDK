<?php


namespace DuiBa;

use Exception;

class CreditConsume implements HandlerInterface
{
    use Parse;
    use Credit;
    /**
     * 构建积分商城扣积分请求测试
     * @param array $req_array
     * @return false|string
     * @throws Exception
     */
    public static function handler(array $req_array)
    {
        try {
            self::parse(self::appKey, self::appSecret, $req_array);
            // 处理 积分消耗
            return (int)self::updateCredits($req_array);
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }

    /**
     * @param string $appKey
     * @param string $appSecret
     * @param array $request_array
     * @return mixed
     * @throws Exception
     */
    private static function parse(string $appKey, string $appSecret, array $request_array)
    {
        self::check($appKey, $appSecret, $request_array);
        if (!isset($request_array["uid"]) && self::uidCheck($request_array["uid"])) {
            throw new Exception("uid not match");
        }
        if (!isset($request_array["credits"])) {
            throw new Exception("credits not match");
        }
        if (!isset($request_array["description"])) {
            throw new Exception("description not match");
        }
        if (!isset($request_array["orderNum"])) {
            throw new Exception("orderNum not match");
        }
        if (!isset($request_array["actualPrice"])) {
            throw new Exception("actualPrice not match");
        }
        return $request_array;
    }
}