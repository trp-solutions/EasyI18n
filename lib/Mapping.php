<?php
/*
EasyI18n is licensed under the Apache License 2.0 license
https://github.com/trp-solutions/EasyI18n/blob/main/LICENSE
*/
declare(strict_types=1);
namespace TRP\EasyI18n;

class Mapping {
	const PATTERN = '^([a-z]{2,3})[-_]([A-Z]{2})$';
	private string $locale;
	private array $category;

	function __construct(string $locale,Category ...$category) {
		if(!preg_match('/'.self::PATTERN.'/u', $locale)) {
			throw new \Exception('EasyI18: invalid locale',500);
		}
		$locale = preg_replace('/'.self::PATTERN.'/u',"$1_$2", $locale);
		$locale = \Locale::acceptFromHttp($locale);
		if(!$locale) {
			throw new \Exception('EasyI18: '.$locale.' not installed',500);
		};
		$this->locale = $locale;
		$this->category = $category;
	}

	public function category() : array {
		return $this->category;
	}
	public function locale() : string {
		return $this->locale;
	}
}
