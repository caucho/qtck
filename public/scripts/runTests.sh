#! /bin/bash
echo "Quercus Technology Compatibility Kit"
echo "===================================="
echo " (c) 2011 Caucho Technology Inc.    "
echo ""
echo "Running tests...."

for MODULE in `cat modules/modules.list`; do
    bash modules/${MODULE}/runTests.sh
done;


