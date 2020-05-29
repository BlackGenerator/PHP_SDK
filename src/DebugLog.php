<?php


namespace DuiBa;


trait DebugLog
{
    protected function log($params)
    {
        return file_put_contents('/tmp/debug.dui.log',
            'test'
            .json_encode($params)
            .PHP_EOL,
            FILE_APPEND);
    }
}