<?php
/*
EasyI18n is licensed under the Apache License 2.0 license
https://github.com/trp-solutions/EasyI18n/blob/main/LICENSE
*/
declare(strict_types=1);

require_once __DIR__ . '/header.php';

use \TRP\EasyI18n;

init_func();

$body = head_func('Test',EasyI18n\Locale::lang());
$center = $body->el('center');

$center->el('label')->te(_('select_language').': ');
$select = $center->el('select');
$select->at(['onchange' => 'window.location.href= "?switch="+this.value']);
foreach(MY_SUPPORTED as $rs) {
	$option = $select->el('option')->te($rs);
	if($rs == EasyI18n\Locale::get(LC_MESSAGES)) {
		$option->at(['selected']);
	}
};

$center->el('br');
$center->te(_('current').': '.EasyI18n\Locale::get(LC_ALL));

foreach(MY_SUPPORTED as $rs) {
	$swap = new EasyI18n\Mapping($rs,LC_NUMERIC,LC_TIME,LC_MESSAGES,LC_CTYPE,LC_CTYPE);

	EasyI18n\Scope::call(
		function() use ($center,$rs) {
			localoutput($center,$rs);
		},
		$swap
	);

	// Or use Scope directly
	// $locale = new EasyI18n\Scope($swap);
	// localoutput($center,$rs);
	// $locale->restore();
}

$center->el('hr');
$center->te(_('current').': '.EasyI18n\Locale::get(LC_ALL));
$center->el('br');
$center->te(_('success'));

function localoutput(object $html,string $locale) : void {
	$html->el('hr');
	$html->el('strong')->te('Scoping: '.$locale);
	$ul = $html->el('ul',['style'=>'list-style: none;']);

	$ul->el('li')->te(_('current').': '.EasyI18n\Locale::get(LC_ALL));

	$ul->el('li')->te(_('messages').': "'.EasyI18n\Messages::ln('_success').'"');

	$now = new \DateTime('now');
	$format = [\IntlDateFormatter::FULL,\IntlDateFormatter::SHORT];
	$ul->el('li')->te(_('time').': '.EasyI18n\Time::format($now, $format));

	$city = ['Aarhus','Kolding','Vejle'];
	EasyI18n\Collate::asort($city);
	$ul->el('li')->te(_('collate').': '.implode(', ',$city));

	$num = 1234567.891234567890000;
	$ul->el('li')->te(_('number').': '.EasyI18n\Numeric::format($num));

	$amount = 1234.56;
	$ul->el('li')->te(_('monetary').': '.EasyI18n\Monetary::format($amount));
}
