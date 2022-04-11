<?php

declare ( strict_types = 1 );

namespace Nouvu\Resources\Models\Auth;

use Symfony\Component\Security\Core\User\UserInterface;
use Nouvu\Framework\Component\Config\Repository;
use Nouvu\Framework\Component\Validator\Exception\ViolationsException;
use Nouvu\Resources\Models\{ AbstractModel, Traits };
use Nouvu\Resources\Entity\Database;

use function Nouvu\Resources\System\Helpers\{ app, container };

final class ActivationModel extends AbstractModel
{
	use Traits\GetQueryConfirm;
	
	public function getDataConfirm(): Repository
	{
		return new Repository( Database\UsersPre :: preConfirm( $this -> getQueryConfirm() ) );
	}
	
	public function validation( Repository $confirm ): UserInterface
	{
		if ( strtotime ( $confirm -> get( 'created_at' ) . ' +2 hour' ) < time () )
		{
			$failed = new ViolationsException( 'Validation failed' );
			
			$failed -> setErrors( [ 'confirm' => 'Запрос на подтверждение аккаунта просрочен' ] );
			
			Database\UsersPre :: remove( $confirm -> get( 'id' ) );
			
			throw $failed;
		}
		
		return container( 'security.database.user_provider' ) -> loadUserByIdentifier( $confirm -> get( 'email' ) );
	}
	
	public function sendEmail( UserInterface $user ): void
	{
		app() -> mail -> setTo( $user -> getEmail(), $user -> getUsername() );
		
		app() -> mail -> setSubject( 'Регистрация | Nouvu' );
		
		app() -> mail -> setContent( sprintf ( 
			'<p>Hello <b>%s</b>!<p>' .
				'<p>Регистрация успешно завершена. Ваш аккаунт активирован.</p>', 
			$user -> getUsername(),
		) );
		
		app() -> mail -> send();
	}
	
	public function updateUser( UserInterface $user, Repository $confirm ): void
	{
		Database\Users :: updateEnabled( $user );
		
		Database\UsersPre :: remove( $confirm -> get( 'id' ) );
	}
}
