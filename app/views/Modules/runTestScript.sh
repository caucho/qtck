
#! /bin/bash
echo "Quercus Technology Compatibility Kit"
echo "===================================="
echo " (c) 2011 Caucho Technology Inc.    "
echo ""

source ./settings.sh

echo "Configuration settings are: "
echo "PHP-Interpreter: $PHP"
echo "UUID: $UUID"

#{list constants, as:'c'}
echo "Running test for constant #${c.id} ( ${c.name} )"
if [ -s modules/${c.module.shortname}/todo/CONSTANT_${c.id}.php ]; then
    # running the test
    $PHP modules/${c.module.shortname}/todo/CONSTANT_${c.id}.php > modules/${c.module.shortname}/completed/CONSTANT_${c.id}_stdout.txt 2> modules/${c.module.shortname}/completed/CONSTANT_${c.id}_stderr.txt && rm modules/${c.module.shortname}/todo/CONSTANT_${c.id}.php

    #if it succeeded:
    if [ ! -s modules/${c.module.shortname}/todo/CONSTANT_${c.id}.php ]; then
    #    echo "Test run";
    #    echo "Processing test results...."
        ./processTestResult.sh ${c.module.shortname} CONSTANT ${c.id}
    fi;
fi;
#{/list}

#{list functions, as:'f'}
echo "Running test for function #${f.id} ( ${f.name} )"
if [ -s modules/${f.module.shortname}/todo/FUNCTION_${f.id}.php ]; then

    $PHP modules/${f.module.shortname}/todo/FUNCTION_${f.id}.php > modules/${f.module.shortname}/completed/FUNCTION_${f.id}_stdout.txt 2> modules/${f.module.shortname}/completed/FUNCTION_${f.id}_stderr.txt && rm modules/${f.module.shortname}/todo/FUNCTION_${f.id}.php
    if [ ! -s modules/${f.module.shortname}/todo/FUNCTION_${f.id}.php ]; then
    #    echo "Test run";
    #    echo "Processing test results...."
        ./processTestResult.sh ${f.module.shortname} FUNCTION ${f.id}
    fi;
fi;
#{/list}


