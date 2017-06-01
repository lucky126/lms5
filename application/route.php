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

Route::rule('api/group/:id/rule', 'api/Group/getRule', "GET", [], ['id' => '\d+']);
Route::rule('api/group/:id/rule', 'api/Group/saveRule', "PUT", [], ['id' => '\d+']);
//unique check
Route::post('api/system/:id/unique', 'api/System/unique', [], ['id' => '\d+']);
Route::post('api/group/:id/unique', 'api/Group/unique', [], ['id' => '\d+']);
Route::post('api/rule/:id/unique', 'api/Rule/unique', [], ['id' => '\d+']);
Route::post('api/user/:id/unique', 'api/User/unique');
Route::post('api/course/:id/unique', 'api/Course/unique', [], ['id' => '\d+']);
Route::post('api/training/:id/unique', 'api/Training/unique', [], ['id' => '\d+']);
Route::post('api/register/:id/unique', 'api/Register/unique');
//status change
Route::put('api/system/:id/activate', 'api/System/changeStatus?status=1', [], ['id' => '\d+']);
Route::put('api/system/:id/deactivate', 'api/System/changeStatus?status=0', [], ['id' => '\d+']);
Route::put('api/group/:id/activate', 'api/Group/changeStatus?status=1', [], ['id' => '\d+']);
Route::put('api/group/:id/deactivate', 'api/Group/changeStatus?status=0', [], ['id' => '\d+']);
Route::put('api/rule/:id/activate', 'api/Rule/changeStatus?status=1', [], ['id' => '\d+']);
Route::put('api/rule/:id/deactivate', 'api/Rule/changeStatus?status=0', [], ['id' => '\d+']);
Route::put('api/user/:id/activate', 'api/User/changeStatus?status=1');
Route::put('api/user/:id/deactivate', 'api/User/changeStatus?status=0');
Route::put('api/course/:id/activate', 'api/Course/changeStatus?status=1', [], ['id' => '\d+']);
Route::put('api/course/:id/deactivate', 'api/Course/changeStatus?status=0', [], ['id' => '\d+']);
Route::put('api/training/:id/activate', 'api/Training/changeStatus?status=1', [], ['id' => '\d+']);
Route::put('api/training/:id/deactivate', 'api/Training/changeStatus?status=0', [], ['id' => '\d+']);
//other
Route::get('api/training/:id/courses', 'api/Training/courses', [], ['id' => '\d+']);
//resource
Route::resource('api/user', 'api/User');
Route::resource('api/rule', 'api/Rule', [], ['id' => '\d+']);
Route::resource('api/group', 'api/Group', [], ['id' => '\d+']);
Route::resource('api/system', 'api/System', [], ['id' => '\d+']);
Route::resource('api/course', 'api/Course', [], ['id' => '\d+']);
Route::resource('api/training', 'api/Training', [], ['id' => '\d+']);
Route::resource('api/activatecode', 'api/Activatecode', [], ['id' => '\d+']);
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
