<?php


namespace DuiBa;


use Exception;

class CreditNotify implements HandlerInterface
{
    use Parse;
    use Credit;

    /**
     *处理 兑换订单的结果
     * @param array $req_array
     * @return false|string
     * @throws Exception
     */
    public static function handler(array $req_array)
    {
        try {
            self::parse(self::appKey, self::appSecret, $req_array);
            if (!$req_array['success']) {
                // 兑换订单的结果为成功或者失败，如果为失败，开发者需要将积分返还给用户
                return (int)self::updateCredits($req_array);
            } else{
                return true;
            }
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
        if (!isset($request_array["success"])) {
            throw new Exception("success not match");
        }
        if (!isset($request_array["orderNum"])) {
            throw new Exception("orderNum not match");
        }
        return $request_array;
    }
}