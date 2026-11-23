<?php
/*
EasyI18n is licensed under the Apache License 2.0 license
https://github.com/trp-solutions/EasyI18n/blob/main/LICENSE
*/
declare(strict_types=1);
namespace TRP\EasyI18n;

class Monetary {
	public static function format(float $amount) : string {
		$fmt = new \NumberFormatter(Locale::get(LC_MONETARY), \NumberFormatter::CURRENCY);
		$currency = $fmt->getSymbol(\NumberFormatter::INTL_CURRENCY_SYMBOL);
		if($currency === '¤¤') {
			throw new \Exception('EasyI18: INTL_CURRENCY_SYMBOL failed',500);
		}
		$formatter = new \NumberFormatter(Locale::get(LC_MESSAGES), \NumberFormatter::CURRENCY);
		return $formatter->formatCurrency($amount, $currency);
	}
}
