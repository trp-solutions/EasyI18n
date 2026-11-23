<?php
/*
EasyI18n is licensed under the Apache License 2.0 license
https://github.com/trp-solutions/EasyI18n/blob/main/LICENSE
*/
declare(strict_types=1);
namespace TRP\EasyI18n;

class Locale {
	public static function set(Mapping ...$mappings) : array {
		$set = [];
		foreach($mappings as $mapping) {
			foreach($mapping->category() as $category) {
				$set[$category] = $mapping->locale().'.utf-8';
			}
		}
		return self::setlocale($set);
	}
	public static function setlocale(array $new) : array {
		$change = [];

		/*if(isset($new[LC_ALL])) {
			setlocale(LC_ALL, $new[LC_ALL]);
			putenv('LC_ALL='.$new[LC_ALL]);
			Messages::textdomain();
		}*/
		if(isset($new[LC_COLLATE])) {
			$current = setlocale(LC_COLLATE, '0');
			if($current != $new[LC_COLLATE]) {
				$change[LC_COLLATE] = $current;
				setlocale(LC_COLLATE, $new[LC_COLLATE]);
			}
		}
		if(isset($new[LC_CTYPE])) {
			$current = setlocale(LC_CTYPE, '0');
			if($current != $new[LC_CTYPE]) {
				$change[LC_CTYPE] = $current;
				setlocale(LC_CTYPE, $new[LC_CTYPE]);
			}
		}
		if(isset($new[LC_MESSAGES])) {
			$current = setlocale(LC_MESSAGES, '0');
			if($current != $new[LC_MESSAGES]) {
				$change[LC_MESSAGES] = $current;
				setlocale(LC_MESSAGES, $new[LC_MESSAGES]);
				putenv('LC_MESSAGES='.$new[LC_MESSAGES]);
				Messages::textdomain();
			}
		}
		if(isset($new[LC_NUMERIC])) {
			$current = setlocale(LC_NUMERIC, '0');
			if($current != $new[LC_NUMERIC]) {
				$change[LC_NUMERIC] = $current;
				setlocale(LC_NUMERIC, $new[LC_NUMERIC]);
			}
		}
		if(isset($new[LC_TIME])) {
			$current = setlocale(LC_TIME, '0');
			if($current != $new[LC_TIME]) {
				$change[LC_TIME] = $current;
				setlocale(LC_TIME, $new[LC_TIME]);
			}
		}
		if(isset($new[LC_MONETARY])) {
			$current = setlocale(LC_MONETARY, '0');
			if($current != $new[LC_MONETARY]) {
				$change[LC_MONETARY] = $current;
				setlocale(LC_MONETARY, $new[LC_MONETARY]);
			}
		}
		return $change;
	}
	public static function get(int $category) : string {
		$locale = setlocale($category, '0');
		$locale = str_replace('.utf-8', '', $locale);
		return $locale;
	}
	public static function lang(int $category) : string {
		return str_replace('_','-',self::get($category));
	}
}
