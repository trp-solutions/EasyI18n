<?php
/*
EasyI18n is licensed under the Apache License 2.0 license
https://github.com/trp-solutions/EasyI18n/blob/main/LICENSE
*/
declare(strict_types=1);

require_once __DIR__ . '/../lib/autoload.php';
require_once __DIR__ . '/../../HealDocument/lib/autoload.php';

function init_func() : void {
	if(!empty($_GET['switch'])) {
		TRP\EasyI18n\Locale::set($_GET['switch']);
	}
	elseif(!empty($_COOKIE['mylang'])) {
		TRP\EasyI18n\Locale::set($_COOKIE['mylang']);
	}
	else {
		$accept = TRP\EasyI18n\Detect::browser(supported: 'get_supported_func');
		TRP\EasyI18n\Locale::set($accept ?? 'en_US');
	}
	setcookie('mylang', TRP\EasyI18n\Locale::get(), time()+3600*24);

	TRP\EasyI18n\Messages::directory(__DIR__.'/../translation/');
	TRP\EasyI18n\Messages::set(TRP\EasyI18n\Locale::get());
}

function get_supported_func() : array {
	return ['en_US','da_DK','bi_VU'];
}

function head_func(string $title, string $lang) : TRP\HealDocument\Element {
	global $doc;
	$doc = new \TRP\HealDocument\HealDocument();
	register_shutdown_function('echo_func');

	$html = $doc->el('html',['lang' => $lang]);
	$head = $html->el('head');
	$head->el('meta')->at(['charset'=>'utf-8']);
	$head->el('title')->te('EasyI18n :: '.$title);
	$body = $html->el('body');
	$body->el('center')->el('h1')->te('EasyI18n :: '.$title);
	return $body;
}

function echo_func() {
	global $doc;
	echo $doc;
}
