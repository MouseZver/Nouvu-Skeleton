<?php

use Symfony\Component\PasswordHasher\Hasher\MessageDigestPasswordHasher;

return [
	/*
		- Кодировщик Пароля
	*/
	'encoder' => static function (): array
	{
		return [
			\Nouvu\Resources\Entity\User :: class => new MessageDigestPasswordHasher( 'sha512', true, 4000 ),
		];
	},
	
	/*
		- куки ( запомнить меня )
	*/
	'remember_me' => [
		'path' => '/',
		'name' => 'nouvu_user',
		'domain' => null,
		'secure' => false,
		'httponly' => true,
		'lifetime' => strtotime ( '30 days', 0 ),
		'always_remember_me' => true,
		'remember_me_parameter' => '_remember_me'
	],
	
	/*
		- имя токена в сессии авторизованного пользователя
	*/
	'session_name' => '_security_token',
	
	/*
		- контроль доступа
	*/
	/*'hierarchy' => [
		'ROLE_SUPER_ADMIN' => [ 'ROLE_ADMIN', 'ROLE_USER' ],
		'ROLE_ADMIN' => [ 'ROLE_USER' ],
	],*/
	
	/*
		- 
	*/
	'secret_key' => 'secret_string',
];