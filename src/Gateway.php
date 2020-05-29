<?php

namespace DuiBa;

use Exception;

class Gateway
{
    use Sign;
    const appKey = 'H15Bo94UnxwnJKDnFbZDaPJucYR';
    const appSecret = '35YL816ZZn9W13XWqtT1JtDi5dWD';
    const url = "https://activity.m.duiba.com.cn/autoLogin/autologin?";

    /**
     * 测试生成免登录url
     * 免登录地址涉及到的参数包含
     * $uid,$credits,$redirect,$dcustom,$transfer,$vip等参数
     * @param string $uid
     * @param int $credits
     * @param array|null $options
     * @return string
     */
    public static function buildNoLoginUrl(string $uid, int $credits = 0, array $options = null)
    {
        if (is_null($options) || empty($options)) {
            $params = ["uid" => $uid,"credits"=> $credits];
        } else {
            // 有可选参数，则处理后合并
            $options = array_map(function ($v) {
                return urlencode($v);
            }, $options);
            $params = array_merge(["uid" => $uid, "credits"=> $credits], $options);
        }
        return self::buildUrlWithSign(self::url, self::appKey, self::appSecret, $params);
    }

    /**
     * 构建积分商城请求链接的方式方法
     *
     * @param string $url
     * @param string $appKey
     * @param string $appSecret
     * @param array $params
     * @return string
     */
    private static function buildUrlWithSign(string $url, string $appKey, string $appSecret, array $params)
    {
        $params = array_merge($params, ['appKey' => $appKey, 'timestamp' => time() * 1000, 'appSecret' => $appSecret]);
        $params['sign'] = self::sign($params);

        //构建URL
        unset($params['appSecret']);
        return $url.http_build_query($params, '', '&', PHP_QUERY_RFC3986);
    }
}
