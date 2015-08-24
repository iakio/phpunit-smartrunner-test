<?php
require 'vendor/autoload.php';

$smartrunner = realpath("vendor/bin/smartrunner");
$phpunit = realpath("vendor/bin/phpunit");
$cache_file = ".smartrunner/cache.json";

PHPUnit_Framework_Assert::assertTrue(class_exists('iakio\phpunit\smartrunner\SmartRunner'));

@unlink($cache_file);
@rmdir(dirname($cache_file));

exec("$smartrunner init");
PHPUnit_Framework_Assert::assertTrue(is_dir(dirname($cache_file)), dirname($cache_file) . " is not directory.");

file_put_contents(".smartrunner/config.json", json_encode([
    "phpunit" => "$phpunit --tap"
]));
$out = []; exec("$smartrunner run tests/CalcTest.php", $out);
PHPUnit_Framework_Assert::assertTrue(is_readable($cache_file), "$cache_file is not readable.");
PHPUnit_Framework_Assert::assertContains("CalcTest::test_add", implode($out));
PHPUnit_Framework_Assert::assertContains("1..1", implode($out));

$out = []; exec("$smartrunner run tests/OtherTest.php", $out);
PHPUnit_Framework_Assert::assertContains("OtherTest::test_other", implode($out));
PHPUnit_Framework_Assert::assertContains("1..1", implode($out));

$out = []; exec("$smartrunner run src/Calc.php", $out);
PHPUnit_Framework_Assert::assertContains("CalcTest::test_add", implode($out));
PHPUnit_Framework_Assert::assertContains("OtherTest::test_other", implode($out));
PHPUnit_Framework_Assert::assertContains("1..2", implode($out));
