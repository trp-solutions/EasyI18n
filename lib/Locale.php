<?php
/*
EasyI18n is licensed under the Apache License 2.0 license
https://github.com/trp-solutions/EasyI18n/blob/main/LICENSE
*/
declare(strict_types=1);
namespace TRP\EasyI18n;

class Locale {
	public static function map(Mapping ...$mappings) : array {
		$set = [];
		foreach($mappings as $mapping) {
			foreach($mapping->category() as $category) {
				if(!isset($set[$category->value])) {
					$set[$category->value] = $mapping->locale().'.utf-8';
				}
			}
		}
		return self::set($set);
	}
	public static function get(Category $category) : string {
		$locale = self::getlocale($category);
		if($category != Category::ALL) {
			$locale = str_replace('.utf-8', '', $locale);
		}
		return $locale;
	}
	public static function set(array $new) : array {
		$change = [];
		foreach($new as $key => $value) {
			$return = self::setlocale(Category::from($key),$value);
			if($return) {
				$change[$key] = $return;
			}
		}
		return $change;
	}
	public static function lang(Category $category = Category::MESSAGES) : string {
		return str_replace('_','-',self::get($category));
	}

	private static function setlocale(Category $category,string $locales) : ?string {
		if($category == Category::ALL) {
			setlocale(LC_ALL, self::osset($locales));
			if(in_array(PHP_OS_FAMILY,['Windows','Darwin'])) {
				putenv('LC_ALL='.$locales);
				Messages::textdomain();
			}
			return null;
		}
		$current = self::getlocale($category);
		if($current != $locales) {
			switch($category) {
				case Category::COLLATE:
					$locales = setlocale(LC_COLLATE, self::osset($locales));
					break;
				case Category::CTYPE:
					$locales = setlocale(LC_CTYPE, self::osset($locales));
					break;
				case Category::MONETARY:
					$locales = setlocale(LC_MONETARY, self::osset($locales));
					break;
				case Category::NUMERIC:
					$locales = setlocale(LC_NUMERIC, self::osset($locales));
					break;
				case Category::TIME:
					$locales = setlocale(LC_TIME, self::osset($locales));
					break;
				case Category::MESSAGES:
					if(defined('LC_MESSAGES')) {
						$locales = setlocale(LC_MESSAGES, self::osset($locales));
					}
					if(in_array(PHP_OS_FAMILY,['Windows','Darwin'])) {
						putenv('LC_MESSAGES='.$locales);
						Messages::textdomain();
					}
					break;
				default:
					throw new \Exception('EasyI18: unknown Category',500);
			}
			return $current;
		}
		return null;
	}
	private static function getlocale(Category $category) : string {
		switch($category) {
			case Category::ALL:
				return setlocale(LC_ALL, '0');
			case Category::COLLATE:
				return self::osget(setlocale(LC_COLLATE, '0'));
			case Category::CTYPE:
				return self::osget(setlocale(LC_CTYPE, '0'));
			case Category::MONETARY:
				return self::osget(setlocale(LC_MONETARY, '0'));
			case Category::NUMERIC:
				return self::osget(setlocale(LC_NUMERIC, '0'));
			case Category::TIME:
				return self::osget(setlocale(LC_TIME, '0'));
			case Category::MESSAGES:
				if(defined('LC_MESSAGES')) {
					return self::osget(setlocale(LC_MESSAGES, '0'));
				}
				else {
					$value = getenv('LC_MESSAGES');
					if($value === false) return 'C';
					return $value;
				}
			default:
				throw new \Exception('EasyI18: unknown Category',500);
		}
	}

	private static function osget(string $input) : string {
		if(PHP_OS_FAMILY=='Windows') {
			return preg_replace('/-/', '_', $input, 1);
		}
		return $input;
	}
	private static function osset(string $input) : string {
		if(PHP_OS_FAMILY=='Windows') {
			return preg_replace('/_/', '-', $input, 1);
		}
		return $input;
	}
}
