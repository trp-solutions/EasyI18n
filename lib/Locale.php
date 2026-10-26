<?php
/*
EasyI18n is licensed under the Apache License 2.0 license
https://github.com/trp-solutions/EasyI18n/blob/main/LICENSE
*/
declare(strict_types=1);
namespace TRP\EasyI18n;

class Locale {
	private static string $locale;

	public static function set(string $locale) : void {
		self::$locale = $locale;
	}

	public static function get() : string {
		return self::$locale;
	}

	public static function detect(callable $supported, string $default = 'en_US') : void {
		$preferences = [];

		foreach(explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? '') as $entry) {
			$parts = explode(';', trim($entry), 2);
			$tag = trim($parts[0]);
			if(empty($tag) || $tag === '*') continue;
			$locale = \Locale::acceptFromHttp($tag);
			if($locale === null) continue;

			$quality = 1.0;
			if(isset($parts[1])) {
				$quality = (float) trim(substr(trim($parts[1]), 2));
			}
			if($quality <= 0) continue;

			$preferences[] = [
				'locale' => $locale,
				'quality' => $quality,
			];
		}

		usort($preferences,fn($a, $b) => $b['quality'] <=> $a['quality']);

		$support = $supported();
		foreach($preferences as $preference) {
			if(in_array($preference['locale'],$support,true)) {
				self::set($preference['locale']);
				return;
			}
			if($match = current(array_filter($support, fn($input) => explode('_', $input)[0] === $preference['locale'])) ?: false) {
				self::set($match);
				return;
			}
		}

		self::set($default);
		return;
	}

	public static function lang() : string {
		return str_replace('_','-',self::$locale);
	}
}
