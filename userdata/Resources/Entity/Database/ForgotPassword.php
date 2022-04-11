<?php

declare ( strict_types = 1 );

namespace Nouvu\Resources\Entity\Database;

use Nouvu\Framework\Component\Database\StatementInterface;
use Symfony\Component\Security\Core\User\UserInterface;

use function Nouvu\Resources\System\Helpers\{ database };

class ForgotPassword
{
	public static function add( UserInterface $user, string $confirm ): void
	{
		database() -> insert( \ForgotPassword :: class )( $user -> getId(), $user -> getEmail(), $confirm );
	}
	
	public static function remove( int $id ): void
	{
		database() -> delete( \ForgotPassword :: class )( $id );
	}
	
	public static function removeUser( UserInterface $user ): void
	{
		database() -> delete( \ForgotPassword\By\UserId :: class )( $user -> getId() );
	}
	
	public static function confirm( string $confirm ): array
	{
		return database() -> select( \ForgotPassword\By\Confirm :: class )( $confirm ) -> get( StatementInterface :: FETCH_ASSOC ) ?? [];
	}
	
	public static function create(): void
	{
		database() -> create( \ForgotPassword :: class )();
	}
	
	public static function drop(): void
	{
		database() -> drop( \ForgotPassword :: class )();
	}
}

