#!/bin/bash

ROOT=`pwd`

#mk build
echo "mkdir build ..."
BUILD_PATH="/Users/purpen/project/itablet/build"
if [ ! -f $BUILD_PATH ];then
	mkdir "$BUILD_PATH"
fi

#mk build/web
BUILD_WEB_PATH="$BUILD_PATH/web"
if [ ! -d $BUILD_WEB_PATH ];then
	mkdir "$BUILD_WEB_PATH"
fi
#copy data/web/*
echo "start to copy static file..."
cp -R $ROOT/data/web/* $BUILD_WEB_PATH

#mk build/tmp
BUILD_TMP_PATH="$BUILD_PATH/tmp"
if [ ! -d $BUILD_TMP_PATH ];then
	mkdir "$BUILD_TMP_PATH"
	mkdir "$BUILD_TMP_PATH/cache"
	mkdir "$BUILD_TMP_PATH/templates_c"
	chmod 777 "$BUILD_TMP_PATH/cache"
	chmod 777 "$BUILD_TMP_PATH/templates_c"
fi
echo "clear cache dir..."
rm -f $BUILD_TMP_PATH/cache/%%*
rm -f $BUILD_TMP_PATH/templates_c/%%*

#mk data/config/templates
BUILD_DATA_PATH="$BUILD_PATH/data"
if [ ! -d $BUILD_DATA_PATH ];then
	mkdir $BUILD_DATA_PATH
	mkdir $BUILD_DATA_PATH/config
	mkdir $BUILD_DATA_PATH/templates
fi
#copy config file
echo "start to copy config file ..."
cp -R $ROOT/data/config/* $BUILD_DATA_PATH/config/
#copy templates file
echo "start to copy templates file ..."
cp -R $ROOT/data/templates/* $BUILD_DATA_PATH/templates/

echo "done."
