
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
echo "Downloading test for constant #${c.id} ( ${c.name} )"
wget -o modules/${c.module.shortname}/logs/CONSTANT_${c.id}.txt -O modules/${c.module.shortname}/todo/CONSTANT_${c.id}.php "@@{Constants.testCode(c.id)}"
#{/list}

#{list functions, as:'f'}
echo "Downloading test for function #${f.id} ( ${f.name} )"
wget -o modules/${f.module.shortname}/logs/FUNCTION_${f.id}.txt -O modules/${f.module.shortname}/todo/FUNCTION_${f.id}.php "@@{Functions.testCode(f.id)}"
#{/list}


