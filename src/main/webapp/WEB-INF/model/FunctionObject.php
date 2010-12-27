<?php
/**
 * Created by IntelliJ IDEA.
 * User: domdorn
 * Date: 12/26/10
 * Time: 8:52 PM
 * To change this template use File | Settings | File Templates.
 */
 
class FunctionObject extends Model {

    private /* ModuleObject */ $module;
    private $name;
    private $shortname;
    private $description;



    public static function findByModule(ModuleObject $module)
    {
        return FunctionObject::findByQuery("SELECT * FROM {tableName} WHERE module_id = :module_id ORDER BY name",array("module_id" => intval($module->id)));
    }


    public static function createTestCode(FunctionObject $function)
    {
        $functionName = $function->getName();

        $testCode = <<<EOF
<?
        if( function_exists("$functionName") ) { echo "SUCCESS"; } else { echo "FAILED"; }
?>
EOF;
        return $testCode;
    }


    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setModule(ModelObject $modelObject)
    {
        $this->module = $modelObject;
    }

    public function getModule()
    {
        return $this->module;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setShortname($shortname)
    {
        $this->shortname = $shortname;
    }

    public function getShortname()
    {
        return $this->shortname;
    }
}
