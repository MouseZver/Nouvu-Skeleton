<?php

declare ( strict_types = 1 );

namespace Nouvu\Resources\System;

use Nouvu\Framework\Component\Config\Repository;

class RestApi
{
	protected function __construct ( private Repository $repository )
	{}
	
	public static function notFound(): static
	{
		return new static ( new Repository( [ 'status' => 404, 'header' => [], 'data' => [] ] ) );
	}
	
	public static function serverError(): static
	{
		return new static ( new Repository( [ 'status' => 500, 'header' => [], 'data' => [] ] ) );
	}
	
	public static function success(): static
	{
		return new static ( new Repository( [ 'status' => 'success', 'header' => [], 'data' => [] ] ) );
	}
	
	public function header( mixed ...$header ): self
	{
		$this -> repository -> set( 'header', $header );
		
		return $this;
	}
	
	public function data( mixed ...$data ): self
	{
		$this -> repository -> set( 'data', $data );
		
		return $this;
	}
	
	public function redirect( string $path ): self
	{
		return $this -> header( action: 'redirect', path: $path );
	}
	
	public function errorMessages( string ...$messages ): self
	{
		$this -> header( action: 'message-alert-error' );
		
		return $this -> data( message: $messages );
	}
	
	public function successMessages( string ...$messages ): self
	{
		$this -> header( action: 'message-alert-success' );
		
		return $this -> data( message: $messages );
	}
	
	public function get(): array
	{
		return $this -> repository -> all();
	}
}



/* ajax response:

ошибка в приложении:
// RestApi :: success() -> header( action: 'message' ) -> data( message: [] )
[ 
	'status' => 'success',
	'header' => [
		'action' => 'message',
		//'container' => '.error-body',
	],
	'data' => [
		'message' => [
			'Причина 1',
			'Причина 2',
			'Причина 3',
		],
	]
]

страница не найдена:
// RestApi :: notFound() -> header( action: 'message', path: '00000' ) -> data( message: [ 'Веб-страница не найдена' ] )
[ 
	'status' => 404,
	'header' => [
		'action' => 'location',
		'path' => '/error/404', //$this -> app -> router -> getPathByName( 404 )
	],
	'data' => [
		'message' => [
			'Веб-страница не найдена',
		],
	]
]

ошибка на странице
// RestApi :: serverError() -> header( action: 'location', path: '00000' ) -> data( message: [ 'Ошибка на Веб-странице' ] )
[ 
	'status' => 500,
	'header' => [
		'action' => 'location',
		'path' => '/error/500', //$this -> app -> router -> getPathByName( 500 )
	],
	'data' => [
		'message' => [
			'Ошибка на Веб-странице',
		],
	]
]

редирект
// RestApi :: success() -> header( action: 'redirect', path: '/panel' )
[ 
	'status' => 'success',
	'header' => [
		'action' => 'redirect',
		'path' => '/panel', //$this -> app -> router -> getPathByName( 'admin-panel' )
	],
]

успешный ответ
// RestApi :: success() -> header( action: false, path: '/panel' ) -> data( message: [ 'Причина 1', 'Причина 2', 'Причина 3' ] )
[ 
	'status' => 'success',
	'header' => [
		'action' => false,
		'path' => '/panel', //$this -> app -> router -> getPathByName( 'admin-panel' )
	],
	'data' => [
		'message' => [
			'Причина 1',
			'Причина 2',
			'Причина 3',
		],
	]
]

ответ на запрос страницы
// RestApi :: success() -> header( action: 'update', container: '.content-body' ) -> data( title: '', content: '' )
[ 
	'status' => 'success',
	'header' => [
		'action' => 'update',
		'container' => '.content-body',
	],
	'data' => [
		'title' => '',
		'content' => ''
	]
] */