<?php
/**
 * Created by IntelliJ IDEA.
 * User: domdorn
 * Date: 12/26/10
 * Time: 10:52 PM
 * To change this template use File | Settings | File Templates.
 */
 
class IndexController extends Controller {


    public static function index()
    {
        $modules = ModuleObject::findAll();

        IndexController::renderView(array("modules" => $modules));
    }

}
