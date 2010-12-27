<?php
/*
 * Copyright (c) 1998-2011 Caucho Technology -- all rights reserved
 *
 * This file is part of Resin(R) Open Source
 *
 * Each copy or derived work must preserve the copyright notice and this
 * notice unmodified.
 *
 * Resin Open Source is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * Resin Open Source is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE, or any warranty
 * of NON-INFRINGEMENT.  See the GNU General Public License for more
 * details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Resin Open Source; if not, write to the
 *
 *   Free Software Foundation, Inc.
 *   59 Temple Place, Suite 330
 *   Boston, MA 02111-1307  USA
 *
 * @author Dominik Dorn
 */

/**
 * Abstract Controller class.
 * Extend your own controllers from this one.
 * User: domdorn
 * Date: 12/26/10
 * Time: 10:52 PM
 */
abstract class Controller
{

    /**
     * renders the corresponding view for this Controller::Action mapping
     * @static
     * @param  $params
     * @return void
     */
    public static function renderView($params)
    {
//        echo get_called_class();
        $arr = debug_backtrace();
        $controller = $arr[0]["args"][0][0];
        $action = $arr[0]["args"][0][1];
        $controller = str_replace('Controller[]', "", $controller);

        // bring model into scope
        {
            foreach ($params as $key => $value)
            {
                $$key = $value;
            }
            $viewPath = "WEB-INF/views/" . $controller. "/" . $action . ".php";

            include($_SERVER["DOCUMENT_ROOT"] . $viewPath);
        }
    }

    public static function renderJSON($params)
    {
        echo json_encode($params);
    }

    public static function renderPlain($string)
    {
        header("Content-Type: text/plain");
        echo $string;
    }

    public static function renderPHPDownlaod($filename, $string)
    {
        header("Content-Type: application/x-httpd-php5");
        header("Content-Disposition: attachment; filename=\"$filename\"");
        echo $string;
    }

    public static function renderBashDownload($filename, $string)
    {
        header("Content-Type: application/x-sh");
        header("Content-Disposition: attachment; filename=\"$filename\"");
        echo $string;
    }

}
