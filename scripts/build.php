<?php

/*
usage:
 for dev build:			build.php
 for release build:		build.php release


*/



const SOURCE_DIR = __DIR__ . "/../src/";
const STUB_FILE = 'bootstrap.php';

const PHAR_NAME = "mishell.phar";

const BUILD_PATH = __DIR__ . "/../build/";
const BUILD_PATH_DEV = BUILD_PATH . "dev/";
const BUILD_PATH_RELEASE = BUILD_PATH . "release/";

const BUILD_PATH_DEV_FILE = BUILD_PATH_DEV . PHAR_NAME;
const BUILD_PATH_RELEASE_FILE = BUILD_PATH_RELEASE . PHAR_NAME;

@mkdir(BUILD_PATH);
@mkdir(BUILD_PATH_DEV);
@mkdir(BUILD_PATH_RELEASE);

/* build dev file */
@unlink(BUILD_PATH_DEV_FILE);
$phar = new Phar(
	BUILD_PATH_DEV_FILE
	,
	FilesystemIterator::CURRENT_AS_FILEINFO | FilesystemIterator::KEY_AS_FILENAME
	,
	PHAR_NAME
);

$phar->buildFromDirectory(SOURCE_DIR);
$phar->setStub($phar->createDefaultStub(STUB_FILE));


/* release build */
if (@$argv[1] != 'release')
{
	exit;
}


copy(BUILD_PATH_DEV_FILE, BUILD_PATH_RELEASE_FILE);
