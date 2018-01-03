<?php
/**
 * Created by PhpStorm.
 * User: ys
 * Date: 2017/10/16
 * Time: 16:36
 */
namespace backend\controllers\traits;

trait HouseOthers
{
    private function JsonReturn($code, $data)
    {
        $result_info = [
            'code' => $code,
            'data' => $data
        ];
        return json_encode($result_info, JSON_UNESCAPED_UNICODE);
    }
}