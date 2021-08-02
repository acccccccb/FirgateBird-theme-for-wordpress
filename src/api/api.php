<?php
    use common\Auth\Auth;

    function check() {
        return Auth::check();
    }
    function noCheck() {
        return true;
    }
//  class
    require_once ('common/ReturnData.php');
    require_once ('common/Auth.php');
    require_once ('common/FilterParam.php');

    require_once ('controller/WxLogin.php');
    require_once ('controller/CheckLogin.php');

    require_once ('controller/lightWord/LightWordAdmin.php');
//    require_once ('controller/bookshelf/Bookshelf.php');
//  router
    require_once ('router/router.php');
?>
