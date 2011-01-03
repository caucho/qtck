#! /bin/bash
echo "Quercus Technology Compatibility Kit"
echo "===================================="
echo " (c) 2011 Caucho Technology Inc.    "
echo ""
echo "Downloading tests...."

for MODULE in `cat modules/modules.list`; do
    bash modules/${MODULE}/downloadTests.sh
done;


