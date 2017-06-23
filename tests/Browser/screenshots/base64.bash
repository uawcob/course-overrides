#!/bin/bash

cd $( dirname "${BASH_SOURCE[0]}" )

for file in *.png; do
    cat $file | base64
done
