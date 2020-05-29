<?php

namespace DuiBa;

use Exception;

interface HandlerInterface
{
    const appKey = 'H15Bo94UnxwnJKDnFbZDaPJucYR';
    const appSecret = '35YL816ZZn9W13XWqtT1JtDi5dWD';

    /**
     * @param array $req_array
     * @return false|string
     * @throws Exception
     */
    public static function handler(array $req_array);

}