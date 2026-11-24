<?php
/*
EasyI18n is licensed under the Apache License 2.0 license
https://github.com/trp-solutions/EasyI18n/blob/main/LICENSE
*/
declare(strict_types=1);
namespace TRP\EasyI18n;

enum Category : int {
	case ALL = 1;
	case COLLATE = 2;
	case CTYPE = 4;
	case MONETARY = 8;
	case NUMERIC = 16;
	case TIME = 32;
	case MESSAGES = 64;
}
