<?php

Route::group(['middleware'=>['auth','admin'],'prefix'=>'admin'],function()
{
	Route::get('/','Admin\AdminController@index');
});