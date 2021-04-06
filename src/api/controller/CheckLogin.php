<?php
/**
 * Created by PhpStorm.
 * User: wf
 * Date: 2021/3/29
 * Time: 17:49
 */

use common\ReturnData\ReturnData;

class CheckLogin extends ReturnData {
    function Main() {
        return ReturnData::success([]);
    }
}
function check_token() {
    $CheckLogin = new CheckLogin;
    return $CheckLogin->Main();
}
