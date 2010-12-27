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


define("QTCK", "1.0");

set_include_path(get_include_path().":".$_SERVER["DOCUMENT_ROOT"]."/WEB-INF/framework/controller/");
set_include_path(get_include_path().":".$_SERVER["DOCUMENT_ROOT"]."/WEB-INF/framework/exceptions/");
set_include_path(get_include_path().":".$_SERVER["DOCUMENT_ROOT"]."/WEB-INF/framework/model/");
set_include_path(get_include_path().":".$_SERVER["DOCUMENT_ROOT"]."/WEB-INF/framework/");
set_include_path(get_include_path().":".$_SERVER["DOCUMENT_ROOT"]."/WEB-INF/controllers/");
set_include_path(get_include_path().":".$_SERVER["DOCUMENT_ROOT"]."/WEB-INF/exceptions/");
set_include_path(get_include_path().":".$_SERVER["DOCUMENT_ROOT"]."/WEB-INF/errors/");
set_include_path(get_include_path().":".$_SERVER["DOCUMENT_ROOT"]."/WEB-INF/model/");
set_include_path(get_include_path().":".$_SERVER["DOCUMENT_ROOT"]."/WEB-INF/views/");

function __autoload($name)
{
    require($name.".php");
}

/* basic framework */
require($_SERVER["DOCUMENT_ROOT"]."WEB-INF/config.inc.php");
require($_SERVER["DOCUMENT_ROOT"]."WEB-INF/framework/connect.inc.php");


if(!DB_CONNECTED)
{
    die("couldn't connect to db");
}

$uri = $_SERVER["REQUEST_URI"];

function sanitize_uri($uri)
{
    $uri = str_replace("/index.php/", "", $uri);
    $uri = str_replace("/index.php?", "", $uri);
    $uri = str_replace("/index.php", "", $uri);
    return $uri;
}

function execute($controllerAction, $params = array())
{
    $controllerName = $controllerAction->controller . "Controller";
    $actionName = $controllerAction->action;
    $params = $controllerAction->params;
    // TODO: Apply params

    return call_user_func_array(array(new $controllerName(), $actionName), $params);
}

function createAbsoluteLink($controller, $action, $params)
{
    $serverName = $_SERVER["SERVER_NAME"];
    $serverPort = $_SERVER["SERVER_PORT"];
    $contextPath = (function_exists("quercus_servlet_request"))? quercus_servlet_request()->getContextPath() : "";

    $link = createLink($controller, $action, $params);
    $absoluteUrl = "http://". $serverName ;
    if($serverPort != "80")
        $absoluteUrl = $absoluteUrl . ":".$serverPort;
    $absoluteUrl = $absoluteUrl . $contextPath;
    $absoluteUrl = $absoluteUrl . $link;
    return $absoluteUrl;
}

function createLink($controller, $action, $params)
{
    $baseUrl = "/index.php";

    return $baseUrl. "?controller=$controller&amp;action=$action&amp;params=".urlencode(json_encode($params));
}

class ControllerAction {
    public $controller;
    public $action;
    public $params;

    public function setAction($action)
    {
        $this->action = $action;
    }

    public function getAction()
    {
        return $this->action;
    }

    public function setController($controller)
    {
        $this->controller = $controller;
    }

    public function getController()
    {
        return $this->controller;
    }

    public function setParams($params)
    {
        $this->params = $params;
    }

    public function getParams()
    {
        return $this->params;
    }


}

function resolve_controller_action($uri)
{
    if(!empty($uri) && $uri != "/"){

        parse_str($uri, $arr);
        if(empty($arr))
            throw new ControllerNotFoundException();

        if(empty($arr["controller"]))
            throw new ControllerNotFoundException();

        if(empty($arr["action"]))
            throw new ActionNotFoundException();

        $controllerAction = new ControllerAction();
        $controllerAction->controller = $arr["controller"];
        $controllerAction->action = $arr["action"];
        $controllerAction->params = json_decode($arr["params"]);
    }
    else
    {
        $controllerAction = new ControllerAction();
        $controllerAction->controller = "Index";
        $controllerAction->action = "index";
        $controllerAction->params = array();
    }

    return $controllerAction;
}

try{
    $uri = sanitize_uri($uri);

    $controllerAction = resolve_controller_action($uri);

    execute($controllerAction);
}
catch(Exception $exception)
{
    $exceptionName = str_replace("Exception", "", get_class($exception));

    $exceptionFileName = $_SERVER["DOCUMENT_ROOT"]."WEB-INF/errors/".$exceptionName.".php";

    $error = $exception;
    if(is_file($exceptionFileName))
    {

        require($exceptionFileName);
        die();
    }
    else
    {
        require($_SERVER["DOCUMENT_ROOT"]."WEB-INF/errors/GeneralException.php");
        die();
    }
}



?>
