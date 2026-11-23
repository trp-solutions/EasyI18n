<?php
/*
EasyI18n is licensed under the Apache License 2.0 license
https://github.com/trp-solutions/EasyI18n/blob/main/LICENSE
*/
declare(strict_types=1);
namespace TRP\EasyI18n;

class Time {
	public static function format(\DateTimeInterface $datetime,array|int|string|null $format = null, $capitalize = true) : string {
		$string = \IntlDateFormatter::formatObject($datetime,$format,Locale::get(LC_TIME));
		if($capitalize) {
			$string = mb_strtoupper(mb_substr($string, 0, 1)).mb_substr($string, 1);
		}
		return $string;
	}
}
