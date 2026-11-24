<?php
/*
EasyI18n is licensed under the Apache License 2.0 license
https://github.com/trp-solutions/EasyI18n/blob/main/LICENSE
*/
declare(strict_types=1);
namespace TRP\EasyI18n;

class Numeric {
	private static ?object $formatter = null;

	public static function init() {
		if(self::$formatter) return;
		self::$formatter = new \NumberFormatter(Locale::get(Category::NUMERIC), \NumberFormatter::DECIMAL);
	}
	public static function reset() {
		self::$formatter = null;
	}
	public static function format(int|float $num) : string {
		self::init();
		return self::$formatter->format($num);
	}
}
