#!/bin/bash

echo "Manage database Opengest v1 local exports."
echo "Started at `date +"%T %d/%m/%Y"`"

sudo mv /tmp/*.csv ~/Desktop
sudo chown david ~/Desktop/*.csv
sudo chgrp staff ~/Desktop/*.csv
sudo chmod 644 ~/Desktop/*.csv

echo "Finished at `date +"%T %d/%m/%Y"`"
echo "EOF."
