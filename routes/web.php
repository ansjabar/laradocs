<?php

use Illuminate\Support\Facades\Route;

Route::get('laradocs/{group_name?}', 'AnsJabar\LaraDocs\DocReader@index')->name('laradocs.read');