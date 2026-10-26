<?php
/*
EasyI18n is licensed under the Apache License 2.0 license
https://github.com/trp-solutions/EasyI18n/blob/main/LICENSE
*/
declare(strict_types=1);

require_once __DIR__ . '/header.php';

init_func();

$body = head_func('Test',TRP\EasyI18n\Locale::lang());
$center = $body->el('center');

$center->el('label')->te(_('select_language').': ');
$select = $center->el('select');
$select->at(['onchange' => 'window.location.href= "?switch="+this.value']);
foreach(get_supported_func() as $rs) {
	$option = $select->el('option')->te($rs);
	if($rs == TRP\EasyI18n\Locale::get()) {
		$option->at(['selected']);
	}
};

$center->el('br');
$center->el('br');
$center->el('strong')->te(_('success'));
$center->el('br');

$date = new DateTime('now');
$string = IntlDateFormatter::formatObject(
	$date,
	[IntlDateFormatter::FULL,IntlDateFormatter::SHORT],
	TRP\EasyI18n\Locale::get()
);

$center->te($string);
