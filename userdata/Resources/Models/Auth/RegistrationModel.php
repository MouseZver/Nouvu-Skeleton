<?php

declare ( strict_types = 1 );

namespace Nouvu\Resources\Models\Auth;

use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Nouvu\Framework\Component\Security\NouvuAuthenticationHandler;
use Nouvu\Resources\Entity\User;
use Nouvu\Resources\Models\{ AbstractModel, Traits };
use Nouvu\Resources\Entity\Database;

use function Nouvu\Resources\System\Helpers\{ app, request, config };

final class RegistrationModel extends AbstractModel
{
	use Traits\GetRequestPhone;
	use Traits\GetRequestEmail;
	use Traits\GetRequestFirstPassword;
	use Traits\GetRequestSecondPassword;
	//use Traits\Roles\Data;
	
	public function getUserForm(): UserInterface
	{
		$user = new User;
		
		$user -> setUsername( mb_strtolower ( $this -> getRequestEmail() ) );
		
		$user -> setEmail( mb_strtolower ( $this -> getRequestEmail() ) );
		
		$user -> setPlainPassword( $this -> getRequestFirstPassword() );
		
		return $user;
	}
	
	public function validation( \Closure $encoder, UserInterface $user ): UserInterface
	{
		foreach ( [ /* '@username-email', '@username', */ '@email', '@password' ] AS $key )
		{
			request() -> request -> set( $key, true );
		}
		
		if ( strcmp ( $this -> getRequestFirstPassword(), $this -> getRequestSecondPassword() ) != 0 )
		{
			request() -> request -> set( '@password', false );
		}
		
		/* if ( ! empty ( $user -> getUsername() ) && strcmp ( mb_strtolower ( $user -> getUsername() ), $user -> getEmail() ) == 0 )
		{
			request() -> request -> set( '@username-email', false );
		} */
		
		// Поиск username или email
		Database\Users :: closureDuplicate( function ( object $data ) use ( $user ): bool
		{
			/* if ( strcmp ( mb_strtolower ( $user -> getUsername() ), mb_strtolower ( $data -> username ) ) == 0 )
			{
				request() -> request -> set( '@username', false );
			} */
			
			if ( strcmp ( $user -> getEmail(), $data -> email ) == 0 )
			{
				request() -> request -> set( '@email', false );
			}
			
			return true;
		}, 
		$user );
		
		app() -> validator -> validate( 'POST', config( 'validator.form.registration' ) );
		
		$encoder( $user );
		
		return $user;
	}
	
	public function sendEmail( UserInterface $user, string $confirm ): void
	{
		app() -> mail -> setTo( $user -> getEmail(), 'Менеджер' );
		
		app() -> mail -> setSubject( 'Регистрация | Nouvu' );
		
		app() -> mail -> setContent( sprintf ( 
			'<p>Регистрация почти завершена.<br>Для активации аккаунта, перейдите по ссылке:</p>' .
				'<p>%s</p>', 
			request() -> getSchemeAndHttpHost() . '/confirm-account?confirm=' . $confirm,
		) );
		
		app() -> mail -> send();
	}
	
	public function save( UserInterface $user, string $confirm ): void
	{
		Database\UsersPre :: add( $user, $confirm );
		
		$id = Database\Users :: add( $user );
		
		
		
		$userProfile = array_map ( fn( string $role ): array => [ $id, 'role', $role ], $user -> getRoles() );
		
		$userProfile[] = [ $id, 'phone', $this -> getRequestPhone() ];
		
		Database\UsersProfile :: add( ...$userProfile );
	}
}
