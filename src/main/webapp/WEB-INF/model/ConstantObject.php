<?php
/**
 * Created by IntelliJ IDEA.
 * User: domdorn
 * Date: 12/26/10
 * Time: 8:53 PM
 * To change this template use File | Settings | File Templates.
 */
 
class ConstantObject extends Model {


    private /* ModuleObject */ $module;
    private /* String */ $name;
    private /* String */ $shortname;
    private /* String */ $description;
    private /* String */ $type;
    private /* String */ $defaultvalue;



    public static function findByModule(ModuleObject $module)
    {
//        echo "in findByModule of ConstantObject <br/>\n";
        return ConstantObject::findByQuery("SELECT * FROM {tableName} WHERE module_id = :module_id ORDER BY name",array("module_id" => intval($module->id) ));
    }

    public static function createTestCode(ConstantObject $constant)
    {
        $constantName = $constant->getName();

        $testCode = <<<EOF
<?
        if( defined("$constantName") ) { echo "SUCCESS"; } else { echo "FAILED"; }
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

    public function setModule($module)
    {
        $this->module = $module;
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

    public function setDefaultvalue($defaultvalue)
    {
        $this->defaultvalue = $defaultvalue;
    }

    public function getDefaultvalue()
    {
        return $this->defaultvalue;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getType()
    {
        return $this->type;
    }


}
