<?php

return [
	'form' => [
		/*
			- 
		*/
		'registration' => [
			[ 'phone', 'Length', [ 
				'min' => 3, 'max' => 20, 
				'minMessage' => 'Номер телефона должен содержать не менее {{ limit }} символов',
				'maxMessage' => 'Номер телефона не может быть длиннее {{ limit }} символов'
			] ],
			[ 'phone', 'Regex', [ 
				'pattern' => '/^\+\d+$/i', 
				'message' => 'Номер телефона может содержать только +1234567890 символы',
			] ],
			'email|Email|message:Неверный адрес электронной почты',
			'email|NotBlank|message:Адрес электронной почты не заполнен',
			'password_first|NotBlank|message:Пароль не должен быть пустым',
			[ 'password_first', 'Length', [ 
				'min' => 10, 
				'max' => 100,
				'minMessage' => 'Пароль должен содержать не менее {{ limit }} символов',
				'maxMessage' => 'Пароль превышает {{ limit }} символов',
			] ],
			'password_second',
			//'@username|IsTrue|message:Номер телефона уже используются',
			'@email|IsTrue|message:Адрес электронной почты уже используется',
			'@password|IsTrue|message:Пароль не совпадает с паролем для подтверждения',
			//'@username-email|IsTrue|message:Имя пользователя не должен быть одинаковым с эл. почтой',
		],
		/*
			- 
		*/
		'login' => [
			'@isPasswordValid|IsTrue|message:Неверный логин или пароль',
			'@userFound|IsTrue|message:Пользователь не найден',
			'@account|IsTrue|message:Аккаунт не активирован',
		],
		/*
			- 
		*/
		'forgotPassword' => [
			'email|Email|message:Неверный адрес электронной почты',
			'email|NotBlank|message:Адрес электронной почты не заполнен',
			'@email|IsTrue|message:Адрес электронной почты не найден',
		],
		/*
			- 
		*/
		'lostPassword' => [
			[ 'password_first', 'Length', [ 
				'min' => 10, 
				'max' => 100,
				'minMessage' => 'Пароль должен содержать не менее {{ limit }} символов',
				'maxMessage' => 'Пароль превышает {{ limit }} символов',
			] ],
			'password_second',
			'@password|IsTrue|message:Пароль не совпадает с паролем для подтверждения',
		],
		
		'role' => [
			// https://symfony.com/doc/current/reference/constraints/Collection.html
			/*'name' => Rule :: required() -> customMessage( 'Имя роли не заполнен' ),
			'name' => Rule :: length( 3, 50 ) 
				-> customMinMessage( 'Имя роли содержит менее {{ limit }} символов' ) 
				-> customMaxMessage( 'Имя роли превышает {{ limit }} символов' ),
			'role' => Rule :: required() -> customMessage( 'Тег роли не заполнен' ),
			'role' => Rule :: regex( '/^ROLE_([A-Z_]+)$/' ) -> customMessage( 'Некорректный формат тега роли' ),*/
			
			//'name|NotBlank|message:Имя роли не заполнен',
			[ 'name', 'Length', [
				'min' => 3, 
				'max' => 50,
				'minMessage' => 'Имя роли содержит менее {{ limit }} символов',
				'maxMessage' => 'Имя роли превышает {{ limit }} символов',
			] ],
			[ 'role', 'Regex', [ 
				'pattern' => '/^ROLE_([A-Z_]+)$/', 
				'message' => 'Некорректный формат тега роли',
			] ],
			//'role|NotBlank|message:Role тег не заполнен',
			//'role_hierarchy|Type|type:array,message:The value {{ value }} is not a valid {{ type }}.',
		],
		'permission' => [
			//'name|NotBlank|message:Имя разрешения не заполнен',
			[ 'name', 'Length', [
				'min' => 3, 
				'max' => 50,
				'minMessage' => 'Имя разрешения содержит менее {{ limit }} символов',
				'maxMessage' => 'Имя разрешения превышает {{ limit }} символов',
			] ],
			//'permission|NotBlank|message:Permission тег не заполнен',
			[ 'permission', 'Regex', [ 
				'pattern' => '/^([a-z]+).([a-z]+).([a-z]+)$/', 
				'message' => 'Некорректный формат permission',
			] ],
			//'role|NotBlank|message:Отсутствует роль',
			[ 'role', 'Regex', [ 
				'pattern' => '/^(\d+)$/', 
				'message' => 'Выбранная роль имеет недопустимое значение ID',
			] ],
		],
	],
];