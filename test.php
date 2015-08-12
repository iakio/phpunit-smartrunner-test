<?php
require 'vendor/autoload.php';

$smartrunner = realpath("vendor/bin/smartrunner");
$cache_file = ".smartrunner.cache";

@unlink($cache_file);

$out = [];
exec("$smartrunner tests/CalcTest.php", $out);

PHPUnit_Framework_Assert::assertTrue(is_readable($cache_file));
PHPUnit_Framework_Assert::assertContains("CalcTest::test_add", implode($out));

$out = [];
exec("$smartrunner src/Calc.php", $out);

PHPUnit_Framework_Assert::assertContains("CalcTest::test_add", implode($out));
