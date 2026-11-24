<?php
/*
EasyI18n is licensed under the Apache License 2.0 license
https://github.com/trp-solutions/EasyI18n/blob/main/LICENSE
*/
declare(strict_types=1);
use \TRP\EasyI18n;

require_once __DIR__ . '/../lib/autoload.php';

header('Content-Type:text/plain');

$map = new EasyI18n\Mapping('da_DK', EasyI18n\Category::ALL);
EasyI18n\Locale::map($map);

$now = new \DateTime('now');
$dateType = IntlDateFormatter::FULL;
$timeType = IntlDateFormatter::SHORT;
$amount = 1234.56;

$start = microtime(true);

for($i=1;$i<100000;$i++) {
	$out = EasyI18n\Numeric::format($amount);
	//$out = EasyI18n\Monetary::format($amount);
	//$out = EasyI18n\Time::format($now, dateType: $dateType, timeType: $timeType);
	//echo $out.PHP_EOL;
	//echo '. ';
}

$elapsed = microtime(true) - $start;

echo "Time: ".$elapsed;
