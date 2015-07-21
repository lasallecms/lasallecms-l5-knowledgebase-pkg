<?php

namespace Lasallecms\Knowledgebase\Repositories;

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
use Lasallecms\Lasallecmsapi\Repositories\BaseRepository;
use Lasallecms\Knowledgebase\Models\Kb_item;

class KnowledgebaseRepository extends BaseRepository
{
    /*
     * Run the Base Repository's constructor
     */
    public function __construct()
    {
        parent::__construct();
    }


    /*
     * Run the special data handling that is unique to this Knowledge Base.
     *
     * Called from the "update" and "create" command handlers.
     *
     * @param  array  $data
     * @return array
     */
    public function specialDataHandling($data)
    {
        // If there is a link, and the title & description are blank, then go to that link
        // to get the title & description directly from that site.

        // if there is a link...
        if ($data['link'] == "") return $data;

        $link          = $this->checkLink($data['link']);
        $linksMetaTags = $this->linksMetaTags($link);

        // Not guaranteed that the site has a title and/or a meta-description tag
        if (empty($linksMetaTags['title']))        $linksMetaTags['title'] = $link ;
        if (empty($linksMetaTags['description']))  $linksMetaTags['description'] = "";

        // Do not override the title
        if ($data['title'] == "") $data['title'] = $linksMetaTags['title'];

        // Do not override the description
        if ($data['description'] == "") $data['description'] = $linksMetaTags['description'];

        return $data;
    }


    /*
     * Make sure the URL is fully qualified.
     *
     * I am a very bad boy. This is the exact same method found in HTMLHelper.
     *
     * @param   string  $url
     * @return  string
     */
    public function checkLink($url)
    {
        $url = trim($url);
        if (substr($url, 0, 7 ) == "http://") return $url;

        if (substr($url, 0, 8 ) == "https://") return $url;

        return "http://".$url;
    }


    /*
     * Grab the meta tags from a link using the native PHP function
     *
     * @param  string  $link
     * @return array
     */
    public function linksMetaTags($link)
    {
        $tags = get_meta_tags($link);

        if ($tags) return $tags;
        return null;
    }


    /*
     * Display records ordered on kb_category_id, title, ASC
     *
     * Paginate the results (http://laravel.com/docs/5.1/pagination)
     *
     * @return collection
     */
    public function listItemsByCategory()
    {
        return $this->model->orderBy('kb_category_id', 'title', 'asc')->simplePaginate(25);
    }
}