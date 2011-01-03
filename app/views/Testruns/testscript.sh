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

echo "PHP=\"/usr/bin/php\"" >> settings.sh
echo "UUID=\"${testRun.uuid}\"" >> settings.sh
echo "SUBMITURL=\"@@{Testruns.submitTestResult}\"" >> settings.sh
wget -q @@{'public/scripts/test_setup.sh'}

chmod +x test_setup.sh
./test_setup.sh

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


echo ""
echo "Please adjust settings.sh to proper suit your setup."
echo "Then test the setup with ./test_setup.sh"
echo "If your environment is correctly set up, start the tests by executing"
echo "cd ${testRun.uuid}; ./test_setup.sh && ./downloadTests.sh && ./runTests.sh "
