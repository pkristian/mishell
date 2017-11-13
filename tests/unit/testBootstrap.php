<?php

require __DIR__ . "/tester.phar";
require __DIR__ . "/../../build/mishell.phar";

use Tester\Assert;


Tester\Environment::setup();


Assert::same('Hello John', 'Hello John');
Assert::same('Hello John', 'Hello John');
Assert::same('Hello John', 'Hello John');
Assert::same('Hello John', 'Hello John');
Assert::same('Hello John', 'Hello John');
