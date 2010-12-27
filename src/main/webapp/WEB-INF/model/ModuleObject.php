<?php
/**
 * Created by IntelliJ IDEA.
 * User: domdorn
 * Date: 12/26/10
 * Time: 8:51 PM
 * To change this template use File | Settings | File Templates.
 */
 
class ModuleObject extends Model {


    private $name;
    private $shortname;

    private $deprecated;


    public function setDeprecated($deprecated)
    {
        $this->deprecated = ($deprecated === true || $deprecated == "t" || $deprecated == "true");
    }

    public function getDeprecated()
    {
        return $this->deprecated;
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
