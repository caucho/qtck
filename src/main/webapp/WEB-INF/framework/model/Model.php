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
 * Basic Model Class,
 * managing
 *  * ids,
 *  * created_at timestamps,
 *  * modified_at timestamps
 *
 * Also provides some basic persistence methods,
 * thereby implementing the &quot;Active Record&quot;
 * Pattern described by Fowler in
 * &quot;Patterns of Enterprise Application Architecture&quot;
 * User: domdorn
 * Date: 12/26/10
 * Time: 8:53 PM
 */
 
abstract class Model {


    protected $id;
    public static $QTCKDB;
    public static $objectName;

    public static $references = array();
    public static $fields = array();

    public function __construct()
    {
//        echo "in __construct()";
        $className = get_class($this);
//        echo "className is $className <br/>";
        get_called_class()::setObjectName($className);


//        get_defined_vars()get_called_class()

//        echo "objectName is now " . get_called_class()::getObjectName();
//        echo "<br/>";
    }


    public function getId(){
        return $this->id;
    }

    public function setId($newId)
    {
        $this->id = $newId;
    }

    public function setObjectName($newName)
    {
        get_called_class()::$objectName = $newName;
    }


    public static function getObjectName($objectName)
    {
        return $objectName;
//        return str_replace("Object", "", $objectName);
//        echo "in getObjectName with param $objectName";
//        $name = get_called_class()::$objectName;
//        if(empty($name))
//        {
//            $name =get_called_class();
//            get_called_class()::setObjectName($name);
//
//        }
//        return $name;
    }

    public static function create($object)
    {
        // TODO
    }

    public static function createOrUpdate($object)
    {
        // TODO
    }

    public static function find($value)
    {
        // TODO
    }

    public static function findById($id)
    {
        $id = intval($id);
        if($id < 1){
            return null;
        }

        $values = get_called_class()::findByQuery("SELECT * FROM {tableName} WHERE id = :id LIMIT 1 OFFSET 0", array("id" => $id));
        if(count($values) > 0)
            return $values[0];
        else
            throw new NoResultFoundException();
    }

    protected static function getDatabaseTableName($objectName)
    {
//        $objectName = self::getObjectName();
        $objectName = str_replace("Object", "", $objectName);
        return strtolower($objectName);
    }

    protected static function deriveFullClassName($name)
    {
        $objectName = ucwords($name)."Object";
        return $objectName;
    }

    protected static function findByQuery($query, $params = array(), $amount = -1, $offset = -1)
    {
        //        $QTCKDB = get_class()::$QTCKDB;
        $db = Model::$QTCKDB;
        $objectName = get_called_class()::getObjectName(get_called_class());
        $tableName = Model::getDatabaseTableName(get_called_class());

//        echo "called class: " . get_called_class()::getDatabaseTableName();

        if($db == null)
        {
            die("Database is not set");
        }
        $query = str_replace("{tableName}", $tableName, $query);
        if($amount >= 0)
            $query = str_replace("{limit}", $amount, $query);
        if($offset >= 0)
            $query = str_replace("{offset}", $offset, $query);

//        echo $query;

        $result = $db->prepare($query);
        if(!empty($params))
        {
//            echo "\nbinding params<br/>\n";
            foreach($params as $key => $value)
            {
//                echo "\nbinding :$key to $value <br/>\n";
                $result->bindValue(":$key", $value);
            }
        }
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $worked = $result->execute();
        if( $worked === FALSE )
            throw new DatabaseException("Object $objectName not properly mapped. Table is $tableName;\n".
            "Query was: \n". $query ."\n" . print_r($result->errorInfo()) );

        // workaround as Quercus PDO isn't supporting this yet.
        $resultArray = array();
        foreach($result as $row)
        {
//            echo "creating an $objectName Object <br/>\n";
            $object = new $objectName();
            foreach($row as $key => $value)
            {
//                echo "strPos for $key is ". intval(strpos($key, "_id")) . "<br/>\n";
                if(strpos($key, "_id") > 0)
                {
                    $propertyName = str_replace("_id", "", $key);
                    $childObjectName = Model::deriveFullClassName($propertyName);

                    $obj = new $childObjectName();
                    $obj->setId(intval($value));

                    $funcName = "set".ucwords($propertyName);
                    $object->$funcName($obj);
                    // TODO implement lazy loading
//                    echo "creating an object with name $childObjectName and id $value <br/>\n";
                }
                else
                {
                    $funcName = "set".ucwords($key);
                    $object->$funcName($value);
                }
            }
            $resultArray[] = $object;
        }

        return $resultArray;
    }

    public static function findAll()
    {
        return get_called_class()::findByQuery("SELECT * FROM {tableName}");
    }

    public static function save($object)
    {
        // TODO
    }


    public static function delete($object)
    {
        // TODO
    }
}
