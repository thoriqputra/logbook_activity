<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Route::group(['prefix' => 'logbook', 'namespace' => 'App\Modules\Logbook\Controllers', 'middleware' => ['web', 'auth']], function(){
    route::get('/', 'LogbookController@index');
    route::get('/create', 'LogbookController@create');
    route::get('/get_list_activity', 'LogbookController@getListActivity');
    route::get('/get_data_create', 'LogbookController@getDataCreate');
    route::get('/get_department_activity/{department_id}', 'LogbookController@getDepartmentActivity');
    route::get('/get_detail_list_activity/{id_list_activity}', 'LogbookController@getDetailListActivityById');
    route::post('/doSubmit/{page}', 'LogbookController@doSubmit');
    route::post('/doImport/{count}', 'LogbookController@doImport');
    route::get('/doExportTemplate', 'LogbookController@doExportTemplate');
    route::get('/doExportTable', 'LogbookController@doExportTable');
    route::get('/doExportDetail/{id}', 'LogbookController@doExportDetail');
});