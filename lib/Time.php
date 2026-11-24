<?php
/*
EasyI18n is licensed under the Apache License 2.0 license
https://github.com/trp-solutions/EasyI18n/blob/main/LICENSE
*/
declare(strict_types=1);
namespace TRP\EasyI18n;

class Time {
	private static array $formatter = [];

	public static function init(int $dateType = \IntlDateFormatter::FULL,int $timeType = \IntlDateFormatter::FULL,?string $pattern = null) : \IntlDateFormatter {
		$key = implode('|', [$dateType, $timeType, $pattern]);
		if(!isset(self::$formatter[$key])) {
			self::$formatter[$key] = new \IntlDateFormatter(Locale::get(Category::TIME), dateType: $dateType, timeType: $timeType, pattern: $pattern);
		}
		return self::$formatter[$key];
	}
	public static function reset() {
		self::$formatter = [];
	}
	public static function format(
		\DateTimeInterface $datetime,
		int $dateType = \IntlDateFormatter::FULL,
		int $timeType = \IntlDateFormatter::FULL,
		?string $pattern = null,
		$capitalize = false,
	) : string {
		$formatter = self::init(dateType: $dateType, timeType: $timeType, pattern: $pattern);
		$string = $formatter->format($datetime);
		if($capitalize) {
			$string = mb_strtoupper(mb_substr($string, 0, 1)).mb_substr($string, 1);
		}
		return $string;
	}
}
