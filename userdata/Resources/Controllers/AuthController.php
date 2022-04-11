<?php

declare ( strict_types = 1 );

namespace Nouvu\Resources\Controllers;

use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Nouvu\Framework\Component\Validator\Exception\ViolationsException;
use Nouvu\Framework\Http\Controllers\AbstractController;
use Nouvu\Framework\View\Repository\CommitRepository;
use Nouvu\Resources\System\RestApi;
use Nouvu\Resources\Entity\Database;

use function Nouvu\Resources\System\Helpers\{ request, container, isMethodPost, isAjax, isGranted };

final class AuthController extends AbstractController
{
	/*
		- Авторизация
	*/
	public function login(): CommitRepository
	{
		if ( isGranted( 'ROLE_USER' ) )
		{
			return $this -> redirect( '/' );
		}
		
		$this -> setSingleTitles( 'Авторизация' );
		
		$login = $this -> model( \Auth\Login :: class );
		
		if ( isMethodPost() )
		{
			try
			{
				$user = $login -> validation( function ( UserInterface $user ) use ( $login ): bool
				{
					return $this -> getPasswordHasher( $user ) -> verify( $user -> getPassword(), $login -> getRequestPassword(), $user -> getSalt() );
				} );
				
				$login -> sendEmail( $user );
				
				$login -> authUser( $user );
				
				return $this -> redirect( '/' );
			}
			catch ( ViolationsException $e )
			{
				if ( isAjax() )
				{
					return $this -> customJson( RestApi :: success() -> errorMessages( ...$e -> getErrors() ) );
				}
				
				request() -> attributes -> set( ViolationsException :: class, $e );
			}
		}
		
		return $this -> render( 'auth/login', 'auth/auth-template' );
	}
	
	/*
		- Выход
	*/
	public function logout(): CommitRepository
	{
		container( \SessionRememberMeHandler :: class ) -> clear( container( 'security.token_storage' ) );
		
		return $this -> redirect( '/' );
	}
	
	/*
		- Забыл пароль
	*/
	public function forgotPassword(): CommitRepository
	{
		if ( isGranted( 'ROLE_USER' ) )
		{
			return $this -> redirect( '/' );
		}
		
		$this -> setSingleTitles( 'Восстановление пароля' );
		
		$forgot = $this -> model( \Auth\Forgot :: class );
		
		if ( isMethodPost() )
		{
			try
			{
				$user = $forgot -> validation();
				
				$confirm = md5 ( password_hash ( $user -> getEmail(), \PASSWORD_DEFAULT ) );
				
				$forgot -> sendEmail( $user, $confirm );
				
				$forgot -> save( $user, $confirm );
				
				return $this -> render( 'auth/forgot-password-mail', 'auth/auth-template' );
			}
			catch ( ViolationsException $e )
			{
				if ( isAjax() )
				{
					return $this -> customJson( RestApi :: success() -> errorMessages( ...$e -> getErrors() ) );
				}
				
				request() -> attributes -> set( ViolationsException :: class, $e );
			}
		}
		
		return $this -> render( 'auth/forgot-password', 'auth/auth-template' );
	}
	
	/*
		- Новый пароль
	*/
	public function lostPassword(): CommitRepository
	{
		if ( isGranted( 'ROLE_USER' ) )
		{
			return $this -> redirect( '/' );
		}
		
		$this -> setSingleTitles( 'Сброс пароля' );
		
		$lost = $this -> model( \Auth\Lost :: class );
		
		if ( ! empty ( $lost -> getQueryConfirm() ) )
		{
			$confirm = $lost -> getDataConfirm();
			
			if ( ! $confirm -> has( 'id' ) )
			{
				return $this -> redirect( '/' );
			}
			
			try
			{
				$user = $lost -> validation( function ( UserInterface $user ) use ( $lost ): void
				{
					$password = $this -> getPasswordHasher( $user ) -> hash( $lost -> getRequestFirstPassword(), $user -> getSalt() );
					
					$user -> setPassword( $password );
				}, 
				$confirm );
				
				if ( $user instanceof UserInterface )
				{
					$lost -> sendEmail( $user );
					
					$lost -> updateUser( $user );
					
					return $this -> render( 'auth/lost-password-success', 'auth/auth-template' );
				}
			}
			catch ( ViolationsException $e )
			{
				if ( isAjax() )
				{
					return $this -> customJson( RestApi :: success() -> errorMessages( ...$e -> getErrors() ) );
				}
				
				request() -> attributes -> set( ViolationsException :: class, $e );
			}
			
			return $this -> render( 'auth/lost-password', 'auth/auth-template' );
		}
		
		return $this -> redirect( '/' );
	}
	
	public function register(): CommitRepository
	{
		if ( isGranted( 'ROLE_USER' ) )
		{
			return $this -> redirect( '/' );
		}
		
		$this -> setSingleTitles( 'Регистрация' );
		
		$registration = $this -> model( \Auth\Registration :: class );
		
		if ( isMethodPost() )
		{
			try
			{
				$user = $registration -> validation( function ( UserInterface $user ): void
				{
					$password = $this -> getPasswordHasher( $user ) -> hash( $user -> getPlainPassword(), $user -> getSalt() );
					
					$user -> setPassword( $password );
				}, 
				$registration -> getUserForm() );
				
				$confirm = md5 ( password_hash ( $user -> getEmail(), \PASSWORD_DEFAULT ) );
				
				$registration -> sendEmail( $user, $confirm );
				
				$registration -> save( $user, $confirm );
				
				return $this -> render( 'auth/register-confirm', 'auth/auth-template' );
			}
			catch ( ViolationsException $e )
			{
				if ( isAjax() )
				{
					return $this -> customJson( RestApi :: success() -> errorMessages( ...$e -> getErrors() ) );
				}
				
				request() -> attributes -> set( ViolationsException :: class, $e );
			}
		}
		
		return $this -> render( 'auth/register', 'auth/auth-template' );
	}
	
	public function activation(): CommitRepository
	{
		if ( isGranted( 'ROLE_USER' ) )
		{
			return $this -> redirect( '/' );
		}
		
		$this -> setSingleTitles( 'Активация аккаунта' );
		
		$account = $this -> model( \Auth\Activation :: class );
		
		if ( ! empty ( $account -> getQueryConfirm() ) )
		{
			$confirm = $account -> getDataConfirm();
			
			if ( ! $confirm -> has( 'id' ) )
			{
				return $this -> redirect( '/' );
			}
			
			try
			{
				$user = $account -> validation( $confirm );
				
				$account -> sendEmail( $user );
				
				$account -> updateUser( $user, $confirm );
				
				return $this -> render( 'auth/register-success', 'auth/auth-template' );
			}
			catch ( ViolationsException | UserNotFoundException )
			{
				/*if ( isAjax() )
				{
					return $this -> customJson( errors() );
				}
				
				$this -> app -> request -> attributes -> set( ViolationsException :: class, $e );*/
			}
		}
		
		return $this -> redirect( '/' );
	}
}
