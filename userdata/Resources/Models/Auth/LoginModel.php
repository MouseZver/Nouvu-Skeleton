<?php

declare ( strict_types = 1 );

namespace Nouvu\Resources\Models\Auth;

use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Nouvu\Resources\Models\{ AbstractModel, Traits };

use function Nouvu\Resources\System\Helpers\{ app, container, request, config };

final class LoginModel extends AbstractModel
{
	use Traits\GetRequestLogin;
	use Traits\GetRequestPassword;
	
	public function validation( \Closure $encoder ): UserInterface
	{
		foreach ( [ '@isPasswordValid', '@userFound', '@account' ] AS $key )
		{
			request() -> request -> set( $key, true );
		}
		
		try
		{
			$user = container( 'security.database.user_provider' ) -> loadUserByIdentifier( $this -> getRequestLogin() );
			
			request() -> request -> set( '@isPasswordValid', $encoder( $user ) );
			
			request() -> request -> set( '@account', $user -> isEnabled() );
		}
		catch ( UserNotFoundException )
		{
			request() -> request -> set( '@userFound', false );
		}
		
		app() -> validator -> validate( 'POST', config( 'validator.form.login' ) );
		
		return $user;
	}
	
	public function sendEmail( UserInterface $user ): void
	{
		app() -> mail -> setTo( $user -> getEmail(), $user -> getUsername() );
		
		app() -> mail -> setSubject( 'Авторизация | Nouvu' );
		
		app() -> mail -> setContent( sprintf ( 
			'Добро пожаловать <b>%s</b>! Это тестовое сообщение в <b>LoginModel</b> и вы успешно авторизовались на сайте', 
			$user -> getUsername(),
		) );
		
		app() -> mail -> send();
	}
	
	public function authUser( UserInterface $user ): void
	{
		container( \AuthenticationHandler :: class ) 
			-> createSession( $user, 'secured_area', request() -> request -> has( 'remember_check' ) );
	}
}
