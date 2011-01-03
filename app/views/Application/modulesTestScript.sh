#! /bin/bash

echo "Downloading modules"

rm modules.list
touch modules.list
#{list modules, as:'module'}
echo "-------"
echo "preparing module ${module.name} "
mkdir ${module.shortname}/
mkdir ${module.shortname}/completed/
mkdir ${module.shortname}/todo/
mkdir ${module.shortname}/logs/

echo "downloading download-tests-script for module ${module.name} "
wget -q @@{Modules.downloadTestScript(module.id)} -O ${module.shortname}/downloadTests.sh
echo "downloading run-tests-script for module ${module.name} "
wget -q @@{Modules.runTestScript(module.id)} -O ${module.shortname}/runTests.sh
echo ${module.shortname} >> modules.list


#{/list}
