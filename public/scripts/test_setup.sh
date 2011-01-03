#! /bin/bash

source ./settings.sh

echo "<?php if(true){ echo \"SUCCESS\\n\"; exit(200); }  ?>" > test_setup.php

RETURN_VALUE=`$PHP test_setup.php`
if [ $RETURN_VALUE == "SUCCESS" ]; then
    echo "Environment successfully set up";
    exit 0;
else
    echo "Your PHP Environment isn't set up correctly. Please adjust settings.sh"
    exit 1;
fi;
