<?php

return [
	/*
		- Данные для подключения к MySQL БД
		- dsn синтаксис используется инструментом https://github.com/MouseZver/Lerma
		- Настройка для PDO или для других инструментов, находится в файле userdata/tools.php
	*/
	'database:mysql' => [
		//'dsn'		=> 'mysql:dbname=%s;username=%s;password=%s;host=%s;charset=%s',
		'dbname'	=> '00000000000',
		'username'	=> '00000000000',
		'password'	=> '00000000000',
		'host'		=> '00000000000',
		'charset'	=> 'utf8',
		'port'		=> 3306,
	],
	
	/*
		- Почта
	*/
	'mailer' => [
		'debug' => false,
		'smtp' => false,
		'html' => true,
		'from' => [ 'noreply@nouvu.com', 'Nouvu' ],
		'host' => [
			'Host'			=> 'smtp.gmail.com',
			'SMTPAuth'		=> true,
			'Username'		=> 'Username',
			'Password'		=> 'Password',
			'SMTPSecure'	=> 'tls', //\PHPMailer\PHPMailer\PHPMailer :: ENCRYPTION_STARTTLS,
			'Port'			=> 587,
			'CharSet'		=> 'utf-8', //\PHPMailer\PHPMailer\PHPMailer :: CHARSET_UTF8,
			'Encoding'		=> 'base64', //\PHPMailer\PHPMailer\PHPMailer :: ENCODING_BASE64,
		],
	],
	
	/*
		- Настройка Часового пояса. Список поддерживаемых временных зон:
		- https://www.php.net/manual/ru/timezones.php
		- Для использования default зоны, следует установить значение false
	*/
	'timezone' => 'Europe/Moscow',
	
	/*
		- Обработка ошибок.
		- Настоятельно рекомендуется, на боевом сайте, изменить значение атрибута @display на false
	*/
	'debug' => [
		'error' => true,
		'display' => true,
		'error_log' => 'Logs/Debug-%s.log',
		'log_errors_max_len' => 0,
		'ignore_repeated_errors' => false,
		'ignore_repeated_source' => false,
		'html' => true,
	],
	
	/*
		- 
	*/
	'default_charset' => 'UTF-8',
	
	/*
		- Локализация
	*/
	'locale' => 'ru',
	
	/*
		- Стандартная тема View/{theme}
	*/
	'theme' => 'default',
	
	/*
		- Стандартный шаблон страниц
	*/
	'default_template' => 'default-template',
	
	'default_title' => [
		'list' => [ 'Nouvu' ],
		'delimiter' => ' | ',
	],
];
