<?php
/*
EasyI18n is licensed under the Apache License 2.0 license
https://github.com/trp-solutions/EasyI18n/blob/main/LICENSE
*/
declare(strict_types=1);
namespace TRP\EasyI18n;

class Locale {
	const PATTERN = '^([a-z]{2,3})[-_]([A-Z]{2})$';
	private static string $locale;

	public static function set(string $locale) : void {
		if(!preg_match('/'.self::PATTERN.'/u', $locale)) {
			throw new \Exception('EasyI18: invalid locale',500);
		}
		$locale = preg_replace('/'.self::PATTERN.'/u',"$1_$2", $locale);
		$locale = \Locale::acceptFromHttp($locale);
		if(!$locale) {
			throw new \Exception('EasyI18: locale not installed',500);
		};
		self::$locale = $locale;
	}

	public static function get() : string {
		if(empty(self::$locale)) {
			throw new \Exception('EasyI18: locale not set',500);
		}
		return self::$locale;
	}

	public static function lang() : string {
		return str_replace('_','-',self::get());
	}
}
