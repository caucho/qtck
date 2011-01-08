#! /bin/bash

source ./settings.sh

echo "Marking this testrun as finished"
curl $FINISHEDURL -d uuid=$UUID
echo "done."