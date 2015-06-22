<?php namespace Lasallecms\Knowledgebase;

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

// Laravel Classes
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;


/**
 * This is the Knowledge Base service provider class.
 *
 * @author Bob Bloom <info@southlasalle.com>
 */
class KnowledgebaseServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;


    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        //$this->setupConfiguration();

        $this->setupRoutes($this->app->router);

        //$this->setupTranslations();

        $this->setupViews();

        //$this->setupAssets();
    }

    /**
     * Setup the Configuration.
     *
     * @return void
     */
    protected function setupConfiguration()
    {
        $configuration = realpath(__DIR__.'/../config/knowledgebase.php');

        $this->publishes([
            $configuration => config_path('knowledgebase.php'),
        ]);
    }


    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerKnowledgebase();
    }


    /**
     * Register the application bindings.
     *
     * @return void
     */
    private function registerKnowledgebase()
    {
        $this->app->bind('knowledgebase', function($app) {
            return new Knowledgebase($app);
        });
    }


    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function setupRoutes(Router $router)
    {
        $router->group(['namespace' => 'Lasallecms\Knowledgebase\Http\Controllers'], function($router)
        {
            require __DIR__.'/Http/routes.php';
        });

    }


    /**
     * Define the translations for the application.
     *
     * @return void
     */
    public function setupTranslations()
    {
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'knowledgebase');
    }


    /**
     * Define the views for the application.
     *
     * @return void
     */
    public function setupViews()
    {
        $this->loadViewsFrom(__DIR__.'/../views', 'knowledgebase');

        $this->publishes([
            __DIR__.'/../views' => base_path('resources/views/vendor/lasallecms/knowledgebase'),
        ]);

    }

    /**
     * Define the assets for the application.
     *
     * @return void
     */
    public function setupAssets()
    {
        $this->publishes([
            __DIR__.'/../public' => public_path('packages/lasallecms/knowledgebase/'),
        ]);

    }


}