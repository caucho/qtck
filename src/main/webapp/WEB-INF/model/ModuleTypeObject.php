<?php
/**
 * Created by IntelliJ IDEA.
 * User: domdorn
 * Date: 12/26/10
 * Time: 8:51 PM
 * To change this template use File | Settings | File Templates.
 */
 
class ModuleTypeObject extends Model {


    private $name;


    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }
}
