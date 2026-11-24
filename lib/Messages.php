<?php
/*
EasyI18n is licensed under the Apache License 2.0 license
https://github.com/trp-solutions/EasyI18n/blob/main/LICENSE
*/
declare(strict_types=1);
namespace TRP\EasyI18n;

class Messages {
	static private string $domain;

	public static function directory(string $directory, string $domain = 'messages') : void {
		if(bindtextdomain($domain, $directory)===false) {
			throw new \Exception('EasyI18: bindtextdomain failed',500);
		}
		self::$domain = $domain;
		self::textdomain();
	}
	public static function textdomain() : void {
		if(isset(self::$domain)) {
			textdomain(self::$domain);
		}
	}
	public static function ln(string $string) : string {
		if(($string[0] ?? null)==='_') {
			return _(substr($string,1));
		}
		else {
			return $string;
		}
	}
}
