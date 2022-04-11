<?php

declare ( strict_types = 1 );

namespace Nouvu\Resources\System\Helpers;

use Nouvu\Framework\Foundation\Application;
use Nouvu\Framework\Component\{
	Config\Repository,
	Database\DatabaseManager,
	Validator\Exception\ViolationsException
};
use Nouvu\Resources\Entity\Database\{ Permissions };
use Symfony\Component\HttpFoundation\{ Request, Response, Session\SessionInterface };
use Symfony\Component\Security\Core\{ Security, User\UserInterface, Exception\AuthenticationException };

function app( Application $data = null ): Application
{
	static $app;
	
	return $app ??= $data;
}

function container( string $offset = null ): mixed
{
	if ( is_null ( $offset ) )
	{
		return app() -> container;
	}
	
	return app() -> container -> get( $offset );
}

function config( string $offset = null ): mixed
{
	if ( is_null ( $offset ) )
	{
		return app() -> repository;
	}
	
	return app() -> repository -> get( $offset );
}

function database(): DatabaseManager
{
	return app() -> database;
}

function request(): Request
{
	return app() -> request;
}

function response(): Response
{
	return app() -> response;
}

function session(): SessionInterface
{
	return app() -> session;
}

function roles()
{
	return container( 'security.user.roles' );
}

function permissions()
{
	return container( 'security.user.permissions' );
}

function isMethodPost(): bool
{
	return request() -> isMethod( 'POST' );
}

function isMethodGet(): bool
{
	return request() -> isMethod( 'GET' );
}

function isAjax(): bool
{
	return request() -> isXmlHttpRequest();
}

function routerPathByName( string $name ): string
{
	return app() -> router -> getPathByName( $name ) ?? throw new \LogicException( "Not found routing name by '{$name}'" );;
}

function rolePermission( string $permission ): string
{
	return Permissions :: rolePermission( $permission ) ?? 'ROLE_ZERO';//throw new \LogicException( "Not found permission '{$permission}'" );
}

function errors(): string
{
	$errors = request() -> attributes -> get( ViolationsException :: class );
	
	if ( $errors instanceof ViolationsException )
	{
		return implode ( PHP_EOL, array_map ( 
			fn( $message ) => "<p style=\"background-color: #ff959580;padding: 10px;font-size: 9pt;border-radius: 10px;\">{$message}</p>", 
			$errors -> getErrors() 
		) );
	}
	
	return '';
}

function locale(): string
{
	return config( 'config.locale' );
}

function charset(): string
{
	return config( 'config.default_charset' );
}

function directoryPath( string $name ): string | null
{
	return config( 'app.system.directory.' . $name );
}

function lastUsername(): string
{
	return app() -> session -> get( Security :: LAST_USERNAME, '' );
}

function isGranted( string $attribute, $subject = null ): bool
{
	try
	{
		//var_dump (app() -> security -> isGranted( $attribute, $subject ));exit;
		
		return app() -> security -> isGranted( $attribute, $subject );
	}
	catch ( AuthenticationException )
	{
		return false;
	}
}

function addFilemtime( string $file ): string
{
	if ( config() -> has( 'app.system.directory.site' ) && file_exists ( config( 'app.system.directory.site' ) . $file ) )
	{
		$file .= '?' . filemtime ( config( 'app.system.directory.site' ) . $file );
	}
	
	return $file;
}

