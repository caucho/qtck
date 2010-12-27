<?php
/**
 * Created by IntelliJ IDEA.
 * User: domdorn
 * Date: 12/26/10
 * Time: 11:28 PM
 * To change this template use File | Settings | File Templates.
 */

class ModuleController extends Controller
{

    public static function show($params)
    {
        $module = ModuleObject::findById($params->id);

        $constants = ConstantObject::findByModule($module);
        $functions = FunctionObject::findByModule($module);

        $constantsStatus = array();
        $functionsStatus = array();

        $constantsOKCount = 0;
        $constantsFailCount = 0;

        foreach ($constants as $constant)
        {
            $constantsStatus[$constant->name] = defined($constant->name);
            if ($constantsStatus[$constant->name]) {
                $constantsOKCount++;
            }
            else
            {
                $constantsFailCount++;
            }
        }
        $constantsSuccessRate = ($constantsOKCount + $constantsFailCount > 0) ? (round($constantsOKCount * 10000 / ($constantsOKCount + $constantsFailCount)) / 100) : 100;

        $functionsOKCount = 0;
        $functionsFailCount = 0;
        foreach ($functions as $func)
        {
            $functionsStatus[$func->name] = function_exists($func->name);
            if ($functionsStatus[$func->name]) {
                $functionsOKCount++;
            }
            else
            {
                $functionsFailCount++;
            }
        }
        $functionsSuccessRate = ($functionsOKCount + $functionsFailCount > 0) ? (round($functionsOKCount * 10000 / ($functionsOKCount + $functionsFailCount)) / 100) : 100;

        ModuleController::renderView(array(
                                          "id" => $params->id
                                          , "module" => $module
                                          , "constants" => $constants

                                          , "constantsStatus" => $constantsStatus
                                          , "constantsSuccessCount" => $constantsOKCount
                                          , "constantsFailureCount" => $constantsFailCount
                                          , "constantsSuccessRate" => $constantsSuccessRate

                                          , "functions" => $functions
                                          , "functionsStatus" => $functionsStatus
                                          , "functionsSuccessCount" => $functionsOKCount
                                          , "functionsFailureCount" => $functionsFailCount
                                          , "functionsSuccessRate" => $functionsSuccessRate
                                     ));

    }

    public static function generateTestScript($params)
    {
        $id = intval($params->id);
        if ($id < 1)
            throw new NoResultFoundException();

        $module = ModuleObject::findById($id);

        $constants = ConstantObject::findByModule($module);
        $functions = FunctionObject::findByModule($module);

        $testScript = <<<EOF
#! /bin/bash

echo "Quercus Technology Compatibility Kit"
echo "===================================="
echo " (c) 2011 Caucho Technology Inc.    "
echo ""

EOF;
        foreach($constants as $constant)
        {
            $absoluteUrl = createAbsoluteLink("Constant", "testCode", array("id"=> $constant->id) );
//            echo "absolute Link is " . $absoluteUrl . "\n";
            $id = $constant->id;
            $testScript = $testScript . <<<EOF
echo "Running test for constant #$id"
rm -f testscript.php;
curl -o testscript.php "$absoluteUrl";
\$PHP testscript.php > stdout.txt 2> stderr.txt

echo "Submitting test results....";

EOF;
        }

        // TODO functions

        ModuleController::renderBashDownload("module_" . $module->id . ".sh", $testScript);
    }
}
