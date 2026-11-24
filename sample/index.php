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

$body->el('label')->te(_('select_language').': ');
$select = $body->el('select');
$select->at(['onchange' => 'window.location.href= "?switch="+this.value']);
foreach(MY_SUPPORTED as $rs) {
	$option = $select->el('option')->te($rs);
	if($rs == EasyI18n\Locale::get(EasyI18n\Category::MESSAGES)) {
		$option->at(['selected']);
	}
};

$body->el('br');
$body->te(_('current').': '.EasyI18n\Locale::get(EasyI18n\Category::ALL));

foreach(MY_SUPPORTED as $rs) {
	$swap = new EasyI18n\Mapping($rs,EasyI18n\Category::NUMERIC,EasyI18n\Category::TIME,EasyI18n\Category::MESSAGES,EasyI18n\Category::CTYPE);

	EasyI18n\Scope::call(
		function() use ($body,$rs) {
			localoutput($body,$rs);
		},
		$swap
	);

	// Or use Scope directly
	// $scope = new EasyI18n\Scope($swap);
	// localoutput($body,$rs);
	// $scope->restore();
}

$body->el('hr');
$body->te(_('current').': '.EasyI18n\Locale::get(EasyI18n\Category::ALL));
$body->el('br');
$body->te(_('success'));

function localoutput(object $html,string $locale) : void {
	$html->el('hr');
	$html->el('strong')->te('Scoping: '.\Locale::getDisplayName($locale, EasyI18n\Locale::get(EasyI18n\Category::MESSAGES)));
	$ul = $html->el('ul',['style'=>'list-style: none;']);

	$ul->el('li')->te(_('current').': '.EasyI18n\Locale::get(EasyI18n\Category::ALL));

	$ul->el('li')->te(_('messages').': "'.EasyI18n\Messages::ln('_success').'"');

	$now = new \DateTimeImmutable('now');
	$ul->el('li')->te(_('time').': '.EasyI18n\Time::format($now, \IntlDateFormatter::FULL, \IntlDateFormatter::SHORT, capitalize: true));

	$city = ['Aarhus','Kolding','Vejle'];
	EasyI18n\Collate::asort($city);
	$ul->el('li')->te(_('collate').': '.implode(', ',$city));

	$num = 1234567.891234567890000;
	$ul->el('li')->te(_('number').': '.EasyI18n\Numeric::format($num));

	$amount = 1234.56;
	$ul->el('li')->te(_('monetary').': '.EasyI18n\Monetary::format($amount));
}
