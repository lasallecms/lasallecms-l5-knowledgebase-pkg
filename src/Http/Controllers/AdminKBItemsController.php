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
 * @link       http://LaSalleCMS.com
 * @copyright  (c) 2015, The South LaSalle Trading Corporation
 * @license    http://www.gnu.org/licenses/gpl-3.0.html
 * @author     The South LaSalle Trading Corporation
 * @email      info@southlasalle.com
 *
 */

// LaSalle Software
use Lasallecms\Knowledgebase\Repositories\KnowledgebaseRepository;
use Lasallecms\Formhandling\AdminFormhandling\AdminFormBaseController;
//use Lasallecms\Lasallecmsapi\Repositories\BaseRepository;
use Lasallecms\Helpers\HTML\HTMLHelper;

// Laravel Facades
use Illuminate\Support\Facades\Session;

// Third party classes
use Collective\Html\FormFacade as Form;




///////////////////////////////////////////////////////////////////
///////     MODIFY THE MODEL NAMESPACE & CLASS "as Model"     /////
///////          THIS IS THE ONLY THING YOU HAVE TO           /////
///////              SPECIFY IN THIS CONTROLLER               /////
///////////////////////////////////////////////////////////////////
use Lasallecms\Knowledgebase\Models\Kb_item as Model;


/*
 * Resource controller for administration of posts
 */
class AdminKBItemsController extends AdminFormBaseController
{
    /*
     * @param  Model, as specified above
     * @param  Lasallecms\Lasallecmsapi\Repositories\BaseRepository
     * @return void
     */
    public function __construct(Model $model, KnowledgebaseRepository $repository)
    {
        // execute AdminController's construct method first in order to run the middleware
        parent::__construct();

        // Inject the model
        $this->model = $model;

        // Inject repository
        $this->repository = $repository;

        // Inject the relevant model into the repository
        $this->repository->injectModelIntoRepository($this->model->model_namespace."\\".$this->model->model_class);
    }



    /**
     * Display a listing
     * GET /{table}/index
     *
     * @return Response
     */
    public function index()
    {
        // Is this user allowed to do this?
        if (!$this->repository->isUserAllowed('index'))
        {
            Session::flash('status_code', 400 );
            $message = "You are not allowed to view the list of Knowledge Base items";
            Session::flash('message', $message);
            return view('formhandling::warnings/' . config('lasallecmsadmin.admin_template_name') . '/user_not_allowed', [
                'package_title'        => 'LaSalleCMS',
                'table_type_plural'    => 'knowledge base',
                'table_type_singular'  => 'knowledge base',
                'resource_route_name'  => 'AdminKBItemsController',
                'HTMLHelper'           => HTMLHelper::class,
            ]);
        }


        // If this user has locked records for this table, then unlock 'em
        $this->repository->unlockMyRecords($this->model->table);

        return view('knowledgebase::' . config('lasallecmsadmin.admin_template_name') . '/index',
            [
                'records'                      => $this->repository->listItemsByCategory(),
                'HTMLHelper'                   => HTMLHelper::class,
                'Form'                         => Form::class,
            ]);

        return view('formhandling::adminformhandling/' . config('lasallecmsadmin.admin_template_name') . '/index',
            [
                'display_the_view_button'      => $this->model->display_the_view_button,
                'records'                      => $this->repository->getAll(),
                'repository'                   => $this->repository,
                'package_title'                => $this->model->package_title,
                'table_name'                   => $this->model->table,
                'model_class'                  => $this->model->model_class,
                'resource_route_name'          => $this->model->resource_route_name,
                'field_list'                   => $this->model->field_list,
                'suppress_delete_button_when_one_record' => $this->model->suppress_delete_button_when_one_record,
                'DatesHelper'                  => DatesHelper::class,
                'HTMLHelper'                   => HTMLHelper::class,
                'carbon'                       => Carbon::class,
                'Config'                       => Config::class,
                'Form'                         => Form::class,
            ]);
    }
}