<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Route::group(['prefix' => 'user_management', 'namespace' => 'App\Modules\UserManagement\Controllers', 'middleware' => ['web', 'auth']], function(){
    route::get('/', 'UserManagementController@index');
    route::get('/get_user_list', 'UserManagementController@getUserList');
    route::get('/get_data_user/{user_id}', 'UserManagementController@get_data_user_by_user_id');
    route::post('/doSubmit', 'UserManagementController@doSubmit');
    route::patch('/doUpdate/{user_id}', 'UserManagementController@doUpdate');
    route::get('/doRemove/{id}/{name}', 'UserManagementController@doRemove');
});