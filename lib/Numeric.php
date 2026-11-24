<?php
/*
EasyI18n is licensed under the Apache License 2.0 license
https://github.com/trp-solutions/EasyI18n/blob/main/LICENSE
*/
declare(strict_types=1);
namespace TRP\EasyI18n;

class Numeric {
	public static function format(int|float $num) : string {
		$fmt = new \NumberFormatter(Locale::get(Category::NUMERIC), \NumberFormatter::DECIMAL);
		return $fmt->format($num);
	}
}
