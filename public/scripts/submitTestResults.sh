#! /bin/bash

# // this gets called from {uuid}/modules/{module}/
source ./settings.sh

# // TODO check params

MODULE_NAME=$1
TYPE=$2
ID=$3

echo "|-----------------------------------------------------------------------|"
echo "| Uploading Test Results                                                |"
echo "|-----------------------------------------------------------------------|"
#echo "| PHP:              $PHP";
echo "| UUID:             $UUID";
echo "| MODULE NAME:      $MODULE_NAME"
echo "| TYPE:             $TYPE"
echo "| ID:               $ID"
#echo "| SUBMITURL:        $SUBMITURL"
# // TODO do work here

if [ -s SUCCESS_CONSTANT.result ]; then
    echo "Submitting Constant Success results"
    curl -F uuid=$UUID -F testType=CONSTANTS -F resultType=SUCCESS -F data=@SUCCESS_CONSTANT.result  $SUBMITURL
fi;

if [ -s FAILED_CONSTANT.result ]; then
    echo "Submitting Constant Failed results"
    curl -F uuid=$UUID -F testType=CONSTANTS -F resultType=FAILED  -F data=@FAILED_CONSTANT.result   $SUBMITURL
fi;

if [ -s OTHER_CONSTANT.result ]; then
    echo "Submitting Constant Other results"
    curl -F uuid=$UUID -F testType=CONSTANTS -F resultType=OTHER   -F data=@OTHER_CONSTANT.result    $SUBMITURL
fi;

if [ -s SUCCESS_FUNCTION.result ]; then
    echo "Submitting Function Success results"
    curl -F uuid=$UUID -F testType=FUNCTIONS -F resultType=SUCCESS -F data=@SUCCESS_FUNCTION.result  $SUBMITURL
fi;

if [ -s FAILED_FUNCTION.result ]; then
    echo "Submitting Function Failed results"
    curl -F uuid=$UUID -F testType=FUNCTIONS -F resultType=FAILED  -F data=@FAILED_FUNCTION.result   $SUBMITURL
fi;

if [ -s OTHER_FUNCTION.result ]; then
    echo "Submitting Function Other results"
    curl -F uuid=$UUID -F testType=FUNCTIONS -F resultType=OTHER   -F data=@OTHER_FUNCTION.result    $SUBMITURL
fi;


