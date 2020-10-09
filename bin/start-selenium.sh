#!/usr/bin/env bash

# Download selenium server
cd $HOME

# Create tools folder if it doesnt exist
mkdir -p tools


wget http://selenium-release.storage.googleapis.com/3.141/selenium-server-standalone-3.141.59.jar --no-verbose -P $(pwd)/tools/
java -jar tools/selenium-server-standalone-3.141.59.jar >/dev/null 2>&1 &
