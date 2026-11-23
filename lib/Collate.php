<?php
/*
EasyI18n is licensed under the Apache License 2.0 license
https://github.com/trp-solutions/EasyI18n/blob/main/LICENSE
*/
declare(strict_types=1);
namespace TRP\EasyI18n;

class Collate {
	public static function asort(array &$array) : void {
		asort($array,SORT_LOCALE_STRING);
	}
}
