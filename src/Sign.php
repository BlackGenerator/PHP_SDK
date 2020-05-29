<?php

namespace DuiBa;

trait Sign
{
    /**
     * 签名验证,通过签名验证的才能认为是合法的请求
     *
     * @param string $appSecret
     * @param array $array
     * @return bool
     */
    private static function signVerify(string $appSecret, array $array)
    {
        $newArray = array_filter($array, function ($k) {
            return 'sign' != $k;
        }, ARRAY_FILTER_USE_KEY);
        $newArray["appSecret"] = $appSecret;
        reset($array);
        return self::sign($newArray) == $array["sign"];
    }

    /**
     * md5签名，$array中务必包含 appSecret
     *
     * @param array $array
     * @return string
     */
    private static function sign(array $array)
    {
        ksort($array);
        return md5(array_reduce($array, function ($carry, $item) {
            return $carry . $item;
        }));
    }
}
