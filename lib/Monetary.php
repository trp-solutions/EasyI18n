<?php
/*
EasyI18n is licensed under the Apache License 2.0 license
https://github.com/trp-solutions/EasyI18n/blob/main/LICENSE
*/
declare(strict_types=1);
namespace TRP\EasyI18n;

class Monetary {
	private static ?object $formatter = null;
	private static string $currency;

	public static function init() {
		if(self::$formatter===null) {
			$fmt = new \NumberFormatter(Locale::get(Category::MONETARY), \NumberFormatter::CURRENCY);
			self::$currency = $fmt->getSymbol(\NumberFormatter::INTL_CURRENCY_SYMBOL);
			if(self::$currency === '¤¤') {
				throw new \Exception('EasyI18: INTL_CURRENCY_SYMBOL failed',500);
			}
			self::$formatter = new \NumberFormatter(Locale::get(Category::NUMERIC), \NumberFormatter::CURRENCY);
		}
	}
	public static function reset() {
		self::$formatter = null;
	}
	public static function format(float $amount) : string {
		self::init();
		return self::$formatter->formatCurrency($amount, self::$currency);
	}
}
