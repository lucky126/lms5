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

Route::rule('student/login', 'Student/Common/Login');
Route::rule('student/register', 'Student/Common/Register');
Route::rule('admin/login', 'admin/Common/login');

Route::rule('student/main', 'Student/Index/index');
Route::rule('admin/main', 'admin/Index/index');

Route::rule('api/admin/login', 'api/login/adminlogin', "POST");
Route::rule('api/student/login', 'api/login/studentlogin', "POST");
Route::rule('api/admin/logout', 'api/login/adminlogout', "POST");
Route::rule('api/student/logout', 'api/login/studentlogout', "POST");

Route::rule('api/group/:id/rule', 'api/Group/GetRule', "GET");
Route::rule('api/group/:id/rule', 'api/Group/SaveRule', "PUT");
//unique check
Route::rule('api/group/:id/unique', 'api/Group/Unique', "POST");
Route::rule('api/rule/:id/unique', 'api/Rule/Unique', "POST");
Route::rule('api/user/:id/unique', 'api/User/Unique', "POST");
Route::rule('api/system/:id/unique', 'api/System/Unique', "POST");
Route::rule('api/course/:id/unique', 'api/Course/Unique', "POST");
Route::rule('api/training/:id/unique', 'api/Training/Unique', "POST");
Route::rule('api/register/:id/unique', 'api/Register/Unique', "POST");
//resource
Route::resource('api/user', 'api/User');
Route::resource('api/rule', 'api/Rule');
Route::resource('api/group', 'api/Group');
Route::resource('api/system', 'api/System');
Route::resource('api/course', 'api/Course');
Route::resource('api/training', 'api/Training');
Route::resource('api/register', 'api/Register');

return [
    '__pattern__' => [
        'name' => '\w+',
    ],
    '[hello]' => [
        ':id' => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
        ':name' => ['index/hello', ['method' => 'post']],
    ],

];
