<?php

namespace DuiBa;

use Exception;

trait Parse
{
    use Sign;
    use UidCheck;

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
        return $request_array;
    }

    /**
     * 公共参数 检查
     *
     * @param string $appKey
     * @param string $appSecret
     * @param array $request_array
     * @return mixed
     * @throws Exception
     */
    private static function check(string $appKey, string $appSecret, array $request_array)
    {
        if ($request_array["appKey"] != $appKey) {
            throw new Exception("appKey not match");
        }
        if ($request_array["timestamp"] == null) {
            throw new Exception("timestamp can't be null");
        }
        $verify = self::signVerify($appSecret, $request_array);
        if (!$verify) {
            throw new Exception("sign verify fail");
        }
        return $request_array;
    }
}
