<?php
/**
 * Created by IntelliJ IDEA.
 * User: domdorn
 * Date: 12/27/10
 * Time: 5:22 PM
 * To change this template use File | Settings | File Templates.
 */
 
class TestrunObject extends Model {
    private /* String */ $vendor;
    private /* String */ $product;
    private /* String */ $version;
    private /* Date */ $creationDate;
    private /* Boolean */ $isReference;
    private /* UUID */ $uuid;

    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;
    }

    public function getCreationDate()
    {
        return $this->creationDate;
    }

    public function setIsReference($isReference)
    {
        $this->isReference = $isReference;
    }

    public function getIsReference()
    {
        return $this->isReference;
    }

    public function setProduct($product)
    {
        $this->product = $product;
    }

    public function getProduct()
    {
        return $this->product;
    }

    public function setVersion($version)
    {
        $this->version = $version;
    }

    public function getVersion()
    {
        return $this->version;
    }

    public function setUuid($uuid)
    {
        $this->uuid = $uuid;
    }

    public function getUuid()
    {
        return $this->uuid;
    }

    public function setVendor($vendor)
    {
        $this->vendor = $vendor;
    }

    public function getVendor()
    {
        return $this->vendor;
    }


}
