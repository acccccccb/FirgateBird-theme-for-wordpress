<?php
/**
 * Created by PhpStorm.
 * User: wf
 * Date: 2021/4/1
 * Time: 15:07
 */

namespace common\FilterParam;


class FilterParam
{
    static function get($key = '') {
        if (empty($key)) {
            return false;
        }
        return htmlspecialchars($_GET[$key]) ?? false;
    }
    static function post($key = '') {
        if (empty($key)) {
            return false;
        }
        return htmlspecialchars($_POST[$key]) ?? false;
    }
}
