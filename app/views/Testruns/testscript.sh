#! /bin/bash

echo "   Quercus Technology Compatibility Kit"
echo "  Copyright 2011 - Caucho Technology Inc."
echo "=========================================="
echo ""

echo "This is the TestRun Script for the following environment: "
echo "Vendor:       ${testRun.vendor} "
echo "Product:      ${testRun.product} "
echo "Version:      ${testRun.version} "
echo "TestRun UUID:     ${testRun.uuid} "

echo "Creating test directory"

rm -Rf ${testRun.uuid}/
mkdir ${testRun.uuid}
cd ${testRun.uuid}

echo "ZEND_PHP=\"/usr/bin/php\"" >> settings.sh
echo "RESIN_PATH=\"SET_PATH_HERE\"" >> settings.sh
echo "QUERCUS_PHP=\"java -cp \$RESIN_PATH/lib/resin-kernel.jar:\$RESIN_PATH/lib/quercus.jar:\$RESIN_PATH/lib/resin.jar:\$RESIN_PATH/lib/mysql-connector-java-*-bin.jar com.caucho.quercus.CliQuercus \"" >> settings.sh
echo "PHP=\"\$QUERCUS_PHP\"" >> settings.sh
echo "UUID=\"${testRun.uuid}\"" >> settings.sh
echo "SUBMITURL=\"@@{Testruns.submitTestResult}\"" >> settings.sh
echo "SUBMITOTHERURL=\"@@{Testruns.submitOtherTestResult}\"" >> settings.sh
echo "FINISHEDURL=\"@@{Testruns.markFinished}\"" >> settings.sh
wget -q @@{'public/scripts/test_setup.sh'}

chmod +x test_setup.sh
#./test_setup.sh

mkdir modules;
cd modules;


echo "Downloading Scripts"
wget -q @@{Application.modulesTestScript(testRun.uuid)} -O download_modules.sh

bash ./download_modules.sh



cd ../

wget @@{'public/scripts/downloadTests.sh'} -O downloadTests.sh
chmod +x downloadTests.sh


wget -q @@{'public/scripts/runTests.sh'} -O runTests.sh
chmod +x runTests.sh

wget -q @@{'public/scripts/processTestResult.sh'} -O processTestResult.sh
chmod +x processTestResult.sh

wget -q @@{'public/scripts/submitTestResults.sh'} -O submitTestResults.sh
chmod +x submitTestResults.sh

wget -q @@{'public/scripts/testrunFinished.sh'} -O markFinished.sh
chmod +x markFinished.sh

mkdir OTHER_RESULTS

echo ""
echo "Please adjust settings.sh to proper suit your setup."
echo "Then test the setup with ./test_setup.sh"
echo "If your environment is correctly set up, start the tests by executing"
echo "cd ${testRun.uuid}; ./test_setup.sh && ./downloadTests.sh && ./runTests.sh "
