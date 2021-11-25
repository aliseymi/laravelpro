<?php

use Illuminate\Support\Facades\Route;

Route::get('modules','ModuleController@index')->name('modules.index');
