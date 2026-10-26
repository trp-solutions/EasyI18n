<?php
/*
EasyI18n is licensed under the Apache License 2.0 license
https://github.com/trp-solutions/EasyI18n/blob/main/LICENSE
*/
declare(strict_types=1);
namespace TRP\EasyI18n;

class Messages {
	public static function directory(string $directory, string $domain = 'messages') : void {
		if(bindtextdomain($domain, $directory)===false) {
			throw new \Exception('EasyI18: bindtextdomain failed',500);
		}
		textdomain($domain);
	}
	public static function set(string $locale) : void {
		putenv('LC_MESSAGES='.$locale.'.utf-8');
		setlocale(LC_MESSAGES,$locale.'.utf-8');
	}
}
