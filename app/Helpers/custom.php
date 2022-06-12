<?php 
define('LOGO_PATH','logo/');
define('USER_AVATAR_PATH','user/');
define('DATE_FORMAT',date('d M, Y',));
define('GENDER',['1'=>'Male','2'=>'Female']);
define('STATUS',['1'=>'Active','2'=>'Inactive']);
define('DELETABLE',['1'=>'No','2'=>'Yes']);
define('STATUS_LABEL',
['1'=>'<span class="badge badge-success">Active</span>',
'2'=>'<span class="badge badge-danger">Inactive</span>']);

define('MAIL_MAILER',['smtp','sendmal','mail']);
define('MAIL_ENCRYPTION',['none'=>'null','tls'=>'tls','ssl'=>'ssl']);

if(!function_exists('permission')){
    function permission(string $value){
        if(collect(\Illuminate\Support\Facades\Session::get('permission'))->contains($value)){
            return true;
        }
        return false;
    }
}