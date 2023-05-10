<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Route::group(['prefix' => 'home', 'namespace' => 'App\Modules\Home\Controllers', 'middleware' => ['web', 'auth']], function(){
    route::get('/', 'HomeController@index');
    route::get('/get_user_list', 'HomeController@get_user_list');
    route::get('/edit-profile', 'HomeController@show_edit_profile')->name('show-edit-profile');
    route::put('/update-profile', 'HomeController@update_profile')->name('update-profile');
});