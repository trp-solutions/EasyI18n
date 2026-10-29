<?php
/*
EasyI18n is licensed under the Apache License 2.0 license
https://github.com/trp-solutions/EasyI18n/blob/main/LICENSE
*/
declare(strict_types=1);
namespace TRP\EasyI18n;

class Detect {
	private static string $locale;

	public static function browser(array|callable|null $supported = null) : ?string {
		$preferences = [];
		$return = null;

		foreach(explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? '') as $entry) {
			$parts = explode(';', trim($entry), 2);
			$tag = trim($parts[0]);
			if(empty($tag) || $tag === '*') continue;

			$locale = \Locale::acceptFromHttp($tag);
			if(empty($locale)) continue;

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

		if(empty($preferences)) {
			return null;
		}

		usort($preferences,fn($a, $b) => $b['quality'] <=> $a['quality']);

		if($supported) {
			$support = is_array($supported) ? $supported : $supported();
			foreach($preferences as $preference) {
				if(in_array($preference['locale'],$support,true)) {
					$return = $preference['locale'];
					break;
				}
				if($match = current(array_filter($support, fn($input) => explode('_', $input)[0] === $preference['locale'])) ?: false) {
					$return = $match;
					break;
				}
			}
		}
		else {
			$return = $preferences[0]['locale'];
		}

		return $return;
	}
}
