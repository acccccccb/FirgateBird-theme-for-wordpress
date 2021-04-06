<?php
/**
 * Created by PhpStorm.
 * User: wf
 * Date: 2021/3/30
 * Time: 9:17
 */
namespace common\ReturnData;

class ReturnData {
    static function page($list = [],$page = 1, $pageSize = 10, $total = 0, $message = '请求成功'){
        header('Content-Type:application/json');
        return array(
            "code" => 200,
            "success" => true,
            "message" => $message,
            "data" => array(
                "rows" => $list,
                "page" => (int)$page,
                "pageSize" => (int)$pageSize,
                "total" => (int)$total,
                "totalPage" => ceil((int)$total / (int)$pageSize),
            ),
        );
    }
    static function success($data = [], $message = '请求成功'){
        header('Content-Type:application/json');
        return array(
            "code" => 200,
            "success" => true,
            "message" => $message,
            "data" => $data,
        );
    }
    static function error($data = [], $message = '请求失败'){
        header('Content-Type:application/json');
        return array(
            "code" => 403,
            "success" => false,
            "message" => $message,
            "data" => $data,
        );
    }
}
