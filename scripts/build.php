<?php

const SOURCE_DIR = __DIR__ . "/../src/";
const STUB_FILE = 'bootstrap.php';

const PHAR_NAME = "mishell.phar";
const PHAR_PATH = __DIR__ . "/../build/" . PHAR_NAME;

@unlink(PHAR_PATH);
$phar = new Phar(
	PHAR_PATH
	,
	FilesystemIterator::CURRENT_AS_FILEINFO | FilesystemIterator::KEY_AS_FILENAME
	,
	PHAR_NAME
);

$phar->buildFromDirectory(SOURCE_DIR);
$phar->setStub($phar->createDefaultStub(STUB_FILE));
