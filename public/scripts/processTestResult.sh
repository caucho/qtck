#! /bin/bash

# // this gets called from {uuid}/modules/{module}/
source ./settings.sh

# // TODO check params

MODULE_NAME=$1
TYPE=$2
ID=$3

echo "|-----------------------------------------------------------------------|"
echo "| Storing Data                                                          |"
echo "|-----------------------------------------------------------------------|"
#echo "| PHP:              $PHP";
echo "| UUID:             $UUID";
echo "| MODULE NAME:      $MODULE_NAME"
echo "| TYPE:             $TYPE"
echo "| ID:               $ID"
#echo "| SUBMITURL:        $SUBMITURL"
# // TODO do work here

RESULTDATA=`cat modules/${MODULE_NAME}/completed/${TYPE}_${ID}_stdout.txt`
if [ $RESULTDATA == "SUCCESS" ]; then
 # store in success file
echo "|--------------------------------SUCCESS--------------------------------|"
 echo $ID >> SUCCESS_${TYPE}.result
 exit;
fi;

if [ $RESULTDATA == "FAILED" ]; then
 # store in failed file
 echo "|--------------------------------FAILED---------------------------------|"
 echo $ID >> FAILED_${TYPE}.result
 exit;
fi;

echo "|--------------------------------OTHER---------------------------------|"
echo $ID >> OTHER_${TYPE}.result

