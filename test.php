<?php
require 'vendor/autoload.php';

$smartrunner = realpath("vendor/bin/smartrunner");
$cache_file = ".smartrunner/cache.json";

@unlink($cache_file);
@rmdir(dirname($cache_file));

$out = [];
exec("$smartrunner tests/CalcTest.php", $out);

PHPUnit_Framework_Assert::assertTrue(is_dir(dirname($cache_file)), dirname($cache_file) . " is not directory.");
PHPUnit_Framework_Assert::assertTrue(is_readable($cache_file), "$cache_file is not readable.");
PHPUnit_Framework_Assert::assertContains("CalcTest::test_add", implode($out));

$out = [];
exec("$smartrunner src/Calc.php", $out);

PHPUnit_Framework_Assert::assertContains("CalcTest::test_add", implode($out));
