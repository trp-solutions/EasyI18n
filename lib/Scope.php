<?php
/*
EasyI18n is licensed under the Apache License 2.0 license
https://github.com/trp-solutions/EasyI18n/blob/main/LICENSE
*/
declare(strict_types=1);
namespace TRP\EasyI18n;

class Scope {
	private array $change;
	public function __construct(Mapping ...$mappings) {
		$this->change = Locale::set(...$mappings);
	}
	public function restore() : void {
		Locale::setlocale($this->change);
	}
	public static function call(callable $userfunc,Mapping ...$mappings) : mixed {
		$locale = new self(...$mappings);
		$result = $userfunc();
		$locale->restore();
		return $result;
	}
}
