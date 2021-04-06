<?php
/**
 * Created by PhpStorm.
 * User: wf
 * Date: 2021/3/30
 * Time: 11:31
 */

namespace common\Auth;


class Auth
{
    static function check($roles = array( 'administrator' )) {
        $user = wp_get_current_user();
        $allowed_roles = $roles;
        return array_intersect( $allowed_roles, $user->roles );
    }
}
