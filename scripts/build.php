<?php
const SOURCE_DIR = __DIR__ . "/../src/";
const STUB_FILE = 'bootstrap.php';

const PHAR_NAME = "mishell.phar";

const BUILD_PATH = __DIR__ . "/../build/";

const BUILD_PATH_FILE = BUILD_PATH . PHAR_NAME;

@mkdir(BUILD_PATH);

/* build dev file */
@unlink(BUILD_PATH_FILE);
$phar = new Phar(
	BUILD_PATH_FILE
	,
	FilesystemIterator::CURRENT_AS_FILEINFO | FilesystemIterator::KEY_AS_FILENAME
	,
	PHAR_NAME
);

$phar->buildFromDirectory(SOURCE_DIR);
$phar->setStub($phar->createDefaultStub(STUB_FILE));
