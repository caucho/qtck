<?php
/**
 * Created by IntelliJ IDEA.
 * User: domdorn
 * Date: 12/27/10
 * Time: 6:42 PM
 * To change this template use File | Settings | File Templates.
 */
 
class FunctionController extends Controller{

    public static function testCode($params)
    {
        $id = intval($params->id);

        $functionObject = FunctionObject::findById($id);

        FunctionController::renderPHPDownlaod("$id.php", FunctionObject::createTestCode($functionObject));
    }

}
