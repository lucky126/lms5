<?php
use think\Route;

// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
Route::rule('admin/login', 'admin/Common/login');
Route::rule('admin/main', 'admin/Index/index');
Route::rule('api/login', 'api/login/index', "POST");
Route::rule('api/logout', 'api/login/logout', "POST");

Route::rule('api/group/:id/rule', 'api/Group/GetRule', "GET");
Route::rule('api/group/:id/rule', 'api/Group/SaveRule', "PUT");
Route::rule('api/group/:id/unique', 'api/Group/Unique', "POST");

Route::resource('api/user', 'api/User');
Route::resource('api/rule', 'api/Rule');
Route::resource('api/group', 'api/Group');
Route::resource('api/training', 'api/Training');

return [
    '__pattern__' => [
        'name' => '\w+',
    ],
    '[hello]' => [
        ':id' => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
        ':name' => ['index/hello', ['method' => 'post']],
    ],

];
