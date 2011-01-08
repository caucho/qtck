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
echo "| SUBMITURL:        $SUBMITURL"
echo "| SUBMITOTHERURL:      $SUBMITOTHERURL"
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
    for ID in `cat OTHER_CONSTANT.result`; do
        curl -F uuid=$UUID -F testType=CONSTANT -F id=$ID -F stdout=@OTHER_RESULTS/CONSTANT_${ID}_stdout.txt -F stderr=@OTHER_RESULTS/CONSTANT_${ID}_stderr.txt $SUBMITOTHERURL
        echo ""
    done;
    #curl -F uuid=$UUID -F testType=CONSTANTS -F resultType=OTHER   -F data=@OTHER_CONSTANT.result    $SUBMITURL
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
    for ID in `cat OTHER_FUNCTION.result`; do
        curl -F uuid=$UUID -F testType=FUNCTION -F id=$ID -F stdout=@OTHER_RESULTS/FUNCTION_${ID}_stdout.txt -F stderr=@OTHER_RESULTS/FUNCTION_${ID}_stderr.txt $SUBMITOTHERURL
        echo ""
    done;


    echo "Submitting Function Other results"
    curl -F uuid=$UUID -F testType=FUNCTIONS -F resultType=OTHER   -F data=@OTHER_FUNCTION.result    $SUBMITURL
fi;

echo "Your testresults have been published. "
echo "If everything worked as expected, mark this testcase as completed, "
echo "by executing: "
echo "./markFinished.sh"
