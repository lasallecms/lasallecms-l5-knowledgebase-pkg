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

// Laravel classes
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKnowledgebaseTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        ///////////////////////////////////////////////////////////////////////
        ////                    Lookup Tables                              ////
        ///////////////////////////////////////////////////////////////////////

        if (!Schema::hasTable('kb_lookup_categories'))
        {
            Schema::create('kb_lookup_categories', function (Blueprint $table)
            {
                $table->engine = 'InnoDB';

                $table->increments('id')->unsigned();

                $table->string('title')->unique();
                $table->string('description');

                $table->boolean('enabled')->default(true);

                $table->timestamp('created_at');
                $table->integer('created_by')->unsigned();
                $table->foreign('created_by')->references('id')->on('users');

                $table->timestamp('updated_at');
                $table->integer('updated_by')->unsigned();
                $table->foreign('updated_by')->references('id')->on('users');

                $table->timestamp('locked_at')->nullable();
                $table->integer('locked_by')->nullable()->unsigned();
                $table->foreign('locked_by')->references('id')->on('users');
            });
        }


        ///////////////////////////////////////////////////////////////////////
        ////                    Main Tables                                ////
        ///////////////////////////////////////////////////////////////////////

        if (!Schema::hasTable('kb_items'))
        {
            Schema::create('kb_items', function (Blueprint $table)
            {
                $table->engine = 'InnoDB';

                $table->increments('id')->unsigned();

                $table->integer('kb_category_id')->unsigned();
                $table->foreign('kb_category_id')->references('id')->on('kb_lookup_categories');

                $table->string('title');
                $table->string('description');
                $table->text('comments');

                $table->text('link');

                $table->timestamp('created_at');
                $table->integer('created_by')->unsigned();
                $table->foreign('created_by')->references('id')->on('users');

                $table->timestamp('updated_at');
                $table->integer('updated_by')->unsigned();
                $table->foreign('updated_by')->references('id')->on('users');

                $table->timestamp('locked_at')->nullable();
                $table->integer('locked_by')->nullable()->unsigned();
                $table->foreign('locked_by')->references('id')->on('users');
            });
        }
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Disable foreign key constraints or these DROPs will not work
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');


        ///////////////////////////////////////////////////////////////////////
        ////                       Lookup Tables                           ////
        ///////////////////////////////////////////////////////////////////////

        Schema::table('kb_lookup_categories', function($table){
            $table->dropIndex('kb_lookup_categories_title_unique');
            $table->dropForeign('kb_lookup_categories_created_by_foreign');
            $table->dropForeign('kb_lookup_categories_updated_by_foreign');
            $table->dropForeign('kb_lookup_categories_locked_by_foreign');
        });
        Schema::dropIfExists('kb_lookup_categories');


        ///////////////////////////////////////////////////////////////////////
        ////                    Main Tables                                ////
        ///////////////////////////////////////////////////////////////////////

        Schema::table('kb_items', function($table){
            $table->dropForeign('kb_items_kb_category_id_foreign');
            $table->dropForeign('kb_items_created_by_foreign');
            $table->dropForeign('kb_items_updated_by_foreign');
            $table->dropForeign('kb_items_locked_by_foreign');
        });
        Schema::dropIfExists('kb_items');

        // Enable foreign key constraints
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}