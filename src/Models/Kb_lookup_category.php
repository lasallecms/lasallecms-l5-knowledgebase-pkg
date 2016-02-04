<?php

namespace Lasallecms\Knowledgebase\Models;

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

/* =======================================
 * KB_LOOKUP_CATEGORY IS A LOOKUP TABLE!
 * ======================================= */

// LaSalle Software
use Lasallecms\Lasallecmsapi\Models\BaseModel;

// Laravel facades
use Illuminate\Support\Facades\DB;

class Kb_lookup_category extends BaseModel
{
    ///////////////////////////////////////////////////////////////////
    //////////////          PROPERTIES              ///////////////////
    ///////////////////////////////////////////////////////////////////

    /**
     * The database table used by the model.
     *
     * @var string
     */
    public $table = 'kb_lookup_categories';

    /**
     * Which fields may be mass assigned
     * @var array
     */
    protected $fillable = [
        'title', 'description', 'enabled'
    ];

    /*
     * User groups that are allowed to execute each controller action
     */
    public $allowed_user_groups = [
        ['index'   => ['Super Administrator']],
        ['create'  => ['Super Administrator']],
        ['store'   => ['Super Administrator']],
        ['edit'    => ['Super Administrator']],
        ['update'  => ['Super Administrator']],
        ['destroy' => ['Super Administrator']],
    ];



    ///////////////////////////////////////////////////////////////////
    //////////////        RELATIONSHIPS             ///////////////////
    ///////////////////////////////////////////////////////////////////

    /*
     * One to one relationship with Kb_item
     *
     * Method name must be:
     *    * the model name,
     *    * NOT the table name,
     *    * singular;
     *    * lowercase.
     *
     * @return Eloquent
     */
    public function Kb_item()
    {
        return $this->belongsTo('Lasallecms\Knowledgebase\Models\Kb_item');
    }



    ///////////////////////////////////////////////////////////////////
    ////////////        FOREIGN KEY CONSTRAINTS       /////////////////
    ///////////////////////////////////////////////////////////////////

    /*
     * Return an array of all the tables using a specified lookup table id.
     * The array is in the form ['table related to the lookup table' => 'count']
     *
     * @param   int   $id   Table ID
     * @return  array
     */
    public function foreignKeyCheck($id)
    {
        // 'related_table' is the table name
        return  [
            [ 'related_table' => 'milestones', 'count' => $this->kb_itemCount($id) ],
        ];
    }

    /*
     * Count of related table using lookup table.
     *
     * Method name is the table name (no techie reason, just a convention to adopt)
     *
     * @return int
     */
    public function kb_itemCount($id)
    {
        // I know eloquent does this, but having trouble so hand crafting using DB
        $record =  DB::table('kb_items')->where('kb_category_id', '=', $id)->get();
        return count($record);
    }
}