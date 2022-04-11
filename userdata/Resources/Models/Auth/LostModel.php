<?php

declare ( strict_types = 1 );

namespace Nouvu\Resources\Models\Auth;

use Symfony\Component\Security\Core\User\UserInterface;
use Nouvu\Framework\Component\Config\Repository;
use Nouvu\Framework\Component\Validator\Exception\ViolationsException;
use Nouvu\Resources\Models\{ AbstractModel, Traits };
use Nouvu\Resources\Entity\Database;

use function Nouvu\Resources\System\Helpers\{ app, container, isMethodPost, request, config };

final class LostModel extends AbstractModel
{
	use Traits\GetQueryConfirm;
	use Traits\GetRequestFirstPassword;
	use Traits\GetRequestSecondPassword;
	
	public function getDataConfirm(): Repository
	{
		return new Repository( Database\ForgotPassword :: confirm( $this -> getQueryConfirm() ) );
	}
	
	public function validation( \Closure $encoder, Repository $confirm ): UserInterface | null
	{
		if ( strtotime ( $confirm -> get( 'created_at' ) . '  +2 hour' ) < time () )
		{
			$failed = new ViolationsException( 'Validation failed' );
			
			$failed -> setErrors( [ 'confirm' => 'Запрос на восстановления пароля просрочен' ] );
			
			Database\ForgotPassword :: remove( $confirm -> get( 'id' ) );
			
			throw $failed;
		}
		else if ( isMethodPost() )
		{
			request() -> request -> set( 
				'@password', strcmp ( $this -> getRequestFirstPassword(), $this -> getRequestSecondPassword() ) == 0 
			);
			
			app() -> validator -> validate( 'POST', config( 'validator.form.lostPassword' ) );
			
			$user = container( 'security.database.user_provider' ) -> loadUserByIdentifier( $confirm -> get( 'email' ) );
			
			$encoder( $user );
			
			return $user;
		}
		
		return null;
	}
	
	public function sendEmail( UserInterface $user ): void
	{
		app() -> mail -> setTo( $user -> getEmail(), $user -> getUsername() );
		
		app() -> mail -> setSubject( 'Доступ к аккаунту восстановлен | Nouvu' );
		
		app() -> mail -> setContent( sprintf ( 
			'<p>Hello <b>%s</b>!<p>' .
				'<p>Доступ к вашему аккаунту успешно восстановлен. Вы можете войти с новым паролем.</p>', 
			$user -> getUsername(),
		) );
		
		app() -> mail -> send();
	}
	
	public function updateUser( UserInterface $user ): void
	{
		Database\Users :: updatePassword( $user );
		
		Database\ForgotPassword :: removeUser( $user );
	}
}
