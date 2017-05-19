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

Route::post('api/admin/login', 'api/login/adminlogin', "POST");
Route::post('api/student/login', 'api/login/studentlogin', "POST");
Route::post('api/admin/logout', 'api/login/adminlogout', "POST");
Route::post('api/student/logout', 'api/login/studentlogout', "POST");

Route::rule('api/group/:id/rule', 'api/Group/GetRule', "GET");
Route::rule('api/group/:id/rule', 'api/Group/SaveRule', "PUT");
//unique check
Route::post('api/system/:id/unique', 'api/System/Unique');
Route::post('api/group/:id/unique', 'api/Group/Unique');
Route::post('api/rule/:id/unique', 'api/Rule/Unique');
Route::post('api/user/:id/unique', 'api/User/Unique');
Route::post('api/course/:id/unique', 'api/Course/Unique');
Route::post('api/training/:id/unique', 'api/Training/Unique');
Route::post('api/register/:id/unique', 'api/Register/Unique');
//status change
Route::put('api/system/:id/activate', 'api/System/ChangeStatus?status=1');
Route::put('api/system/:id/deactivate', 'api/System/ChangeStatus?status=0');
Route::put('api/group/:id/activate', 'api/Group/ChangeStatus?status=1');
Route::put('api/group/:id/deactivate', 'api/Group/ChangeStatus?status=0');
Route::put('api/rule/:id/activate', 'api/Rule/ChangeStatus?status=1');
Route::put('api/rule/:id/deactivate', 'api/Rule/ChangeStatus?status=0');
Route::put('api/user/:id/activate', 'api/User/ChangeStatus?status=1');
Route::put('api/user/:id/deactivate', 'api/User/ChangeStatus?status=0');
Route::put('api/course/:id/activate', 'api/Course/ChangeStatus?status=1');
Route::put('api/course/:id/deactivate', 'api/Course/ChangeStatus?status=0');
Route::put('api/training/:id/activate', 'api/Training/ChangeStatus?status=1');
Route::put('api/training/:id/deactivate', 'api/Training/ChangeStatus?status=0');
//resource
Route::resource('api/user', 'api/User');
Route::resource('api/rule', 'api/Rule');
Route::resource('api/group', 'api/Group');
Route::resource('api/system', 'api/System');
Route::resource('api/course', 'api/Course');
Route::resource('api/training', 'api/Training');
Route::resource('api/register', 'api/Register');
Route::resource('api/reguser', 'api/Reguser');

return [
    '__pattern__' => [
        'name' => '\w+',
    ],
    '[hello]' => [
        ':id' => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
        ':name' => ['index/hello', ['method' => 'post']],
    ],

];
