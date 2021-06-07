<?php
/**
 * Date: 2017/6/16
 * Time: 10:31
 */

/**
 * @param int $code
 * @param string $msg
 * @param array $data
 * @return array
 */
function format_json_response(int $code, string $msg = 'OK', array $data = []): array
{
    return [
        'code' => $code,
        'msg' => $msg,
        'data' => (object)$data
    ];
}
