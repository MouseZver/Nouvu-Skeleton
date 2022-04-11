<?php

declare ( strict_types = 1 );

namespace Nouvu\Resources\Models\Auth;

use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Nouvu\Resources\Models\{ AbstractModel, Traits };
use Nouvu\Resources\Entity\Database;

use function Nouvu\Resources\System\Helpers\{ app, container, request, config };

final class ForgotModel extends AbstractModel
{
	use Traits\GetRequestEmail;
	
	public function validation(): UserInterface
	{
		try
		{
			request() -> request -> set( '@email', true );
			
			$user = container( 'security.database.user_provider' ) -> loadUserByIdentifier( $this -> getRequestEmail() );
		}
		catch ( UserNotFoundException )
		{
			if ( ! empty ( $this -> getRequestEmail() ) )
			{
				request() -> request -> set( '@email', false );
			}
		}
		
		app() -> validator -> validate( 'POST', config( 'validator.form.forgotPassword' ) );
		
		return $user;
	}
	
	public function sendEmail( UserInterface $user, string $confirm ): void
	{
		app() -> mail -> setTo( $user -> getEmail(), $user -> getUsername() );
		
		app() -> mail -> setSubject( 'Восстановление пароля' );
		
		app() -> mail -> setContent( sprintf ( 
			'<p>Hello <b>%s</b>!<p>' .
				'<p>Если Вы не запрашивали это письмо, то можете спокойно его <b>проигнорировать</b>.</p>' .
				'<p>Для обновления пароля пройдите по нижеследующей ссылке. Это позволит Вам выбрать новый пароль.</p>' .
				'<h2>Forgot Password</h2>' .
				'<p>%s</p>', 
			$user -> getUsername(),
			request() -> getSchemeAndHttpHost() . '/lost-password?confirm=' . $confirm
		) );
		
		app() -> mail -> send();
	}
	
	public function save( UserInterface $user, string $confirm ): void
	{
		Database\ForgotPassword :: add( $user, $confirm );
	}
}
