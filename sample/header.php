<?php
/*
EasyI18n is licensed under the Apache License 2.0 license
https://github.com/trp-solutions/EasyI18n/blob/main/LICENSE
*/
declare(strict_types=1);

require_once __DIR__ . '/../lib/autoload.php';
require_once __DIR__ . '/../../HealDocument/lib/autoload.php';

define('MY_SUPPORTED',['en_US','da_DK','it_IT']);

use \TRP\EasyI18n;

function init_func() : void {
	EasyI18n\Messages::directory(__DIR__.'/../translation/');

	if(!empty($_GET['switch'])) {
		$gui = $_GET['switch'];
	}
	elseif(!empty($_COOKIE['mylang'])) {
		$gui = $_COOKIE['mylang'];
	}
	else {
		$gui = EasyI18n\Detect::browser(supported: 'get_supported_func') ?? 'en_US';
	}
	setcookie('mylang', $gui, time()+3600*24);

	$gui_map = new EasyI18n\Mapping($gui, EasyI18n\Category::NUMERIC, EasyI18n\Category::TIME, EasyI18n\Category::MESSAGES, EasyI18n\Category::CTYPE);
	$glo_map = new EasyI18n\Mapping('da_DK', EasyI18n\Category::COLLATE, EasyI18n\Category::MONETARY);
	EasyI18n\Locale::map($gui_map,$glo_map);
}

function get_supported_func() : array {
	return MY_SUPPORTED;
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
	$body->el('center')->el('h2')->te('EasyI18n :: '.$title.' ('.PHP_OS_FAMILY.')');
	return $body;
}

function echo_func() {
	global $doc;
	echo $doc;
}
