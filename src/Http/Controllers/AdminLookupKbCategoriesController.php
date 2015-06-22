<?php

namespace Lasallecms\Knowledgebase\Http\Controllers;

/**
 *
 * Knowledge Base package to track links, articles, and resources.
 *
 * This is a LaSalle Software package. It requires the LaSalle Content Management System.
 *
 * Based on the superb Laravel 5 Framework
 *
 * Copyright (C) 2015  The South LaSalle Trading Corporation
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
 * @version    1.0.0
 * @link       http://LaSalleCMS.com
 * @copyright  (c) 2015, The South LaSalle Trading Corporation
 * @license    http://www.gnu.org/licenses/gpl-3.0.html
 * @author     The South LaSalle Trading Corporation
 * @email      info@southlasalle.com
 *
 */

// LaSalle Software
use Lasallecms\Formhandling\Lookuptables\AdminLookupTableBaseController;
use Lasallecms\Lasallecmsapi\Repositories\BaseRepository;

/*
 * Resource controller for administration of lookup_address_types
 */
class AdminLookupKbCategoriesController extends AdminLookupTableBaseController
{
    ///////////////////////////////////////////////////////////////////
    ////////////////     USER DEFINED PROPERTIES      /////////////////
    ////////////////           MODIFY THESE!          /////////////////
    ///////////////////////////////////////////////////////////////////

    /*
     * @var Name of this package
     */
    public $package_title        = "LaSalleCMS - Knowledge Base";

    /*
     * Lookup table type, in the plural
     */
    public $table_type_plural   = "Knowledge Base Categories";

    /*
     * Lookup table type, in the singular
     */
    public $table_type_singular  = "Knowledge Base Category";

    /*
     * Lookup table name
     */
    public $table_name           = "kb_lookup_categories";

    /*
     * This lookup table's model class namespace
     */
    public $model_namespace      = "Lasallecrm\Knowledgebase\Models";

    /*
     * This lookup table's model class
     */
    public $model_class          = "Kb_lookup_category";

    /*
     * The base URL of this lookup table's resource routes
     */
    public $resource_route_name   = "lukbcategories";

    /*
     * Suppress the delete button when just one record to list, in the listings (index) page
     *
     * true  = suppress the delete button when just one record to list
     * false = display the delete button when just one record to list
     *
     * @var bool
     */
    public $suppress_delete_button_when_one_record = false;




    ///////////////////////////////////////////////////////////////////
    ////////////////     DO NOT MODIFY BELOW!         /////////////////
    ///////////////////////////////////////////////////////////////////

    /*
     * @param  Lasallecms\Lasallecmsapi\Repositories\BaseRepository
     * @return void
     */
    public function __construct(BaseRepository $repository)
    {
        // execute AdminLookupTableBaseController's construct method first in order to run the middleware
        parent::__construct() ;

        // Inject repository
        $this->repository = $repository;

        // Inject the relevant model into the repository
        $this->repository->injectModelIntoRepository($this->model_namespace."\\".$this->model_class);
    }
}