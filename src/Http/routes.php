<?php

/**
 *
 * Knowledge Base package to track links, articles, and resources.
 *
 * This is a LaSalle Software package. It requires the LaSalle Content Management System.
 *
 * Based on the superb Laravel 5 Framework
 *
 * Copyright (C) 2015 - 2016  The South LaSalle Trading Corporation
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 *
 * @package    Knowledge Base package for the LaSalle Content Management System
 * @link       http://LaSalleCMS.com
 * @copyright  (c) 2015 - 2016, The South LaSalle Trading Corporation
 * @license    http://www.gnu.org/licenses/gpl-3.0.html
 * @author     The South LaSalle Trading Corporation
 * @email      info@southlasalle.com
 *
 */

Route::group(array('prefix' => 'admin'), function()
{
    // Regular tables
    Route::resource('kbitems', 'AdminKBItemsController');
    Route::post('kbitems/confirmDeletion/{id}', 'AdminKBItemsController@confirmDeletion');
    Route::post('kbitems/confirmDeletionMultipleRows', 'AdminKBItemsController@confirmDeletionMultipleRows');
    Route::post('kbitems/destroyMultipleRecords', 'AdminKBItemsController@destroyMultipleRecords');

    // Lookup Tables
    Route::resource('lukbcategories', 'AdminLookupKbCategoriesController');
    Route::post('lukbcategories/confirmDeletion/{id}', 'AdminLookupKbCategoriesController@confirmDeletion');
});