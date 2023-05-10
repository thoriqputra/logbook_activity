<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Route::group(['prefix' => 'configuration', 'namespace' => 'App\Modules\Configuration\Controllers', 'middleware' => ['web', 'auth']], function(){
    route::get('/support_department', 'ConfigurationController@index');
    route::get('/activity', 'ConfigurationController@index');
    route::get('/activity_type', 'ConfigurationController@index');
    route::get('/channel_requestor', 'ConfigurationController@index');
    route::get('/requestor', 'ConfigurationController@index');
    route::get('/role', 'ConfigurationController@index');
    route::get('/getList/{URI}', 'ConfigurationController@getListService');
    route::get('/view_edit/{URI}/{id}', 'ConfigurationController@getDataEdit');
    route::post('/doSubmit/{URI}', 'ConfigurationController@doSubmit');
    route::patch('/doUpdate/{URI}/{id}', 'ConfigurationController@doUpdate');
});