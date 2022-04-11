<?php

declare ( strict_types = 1 );

namespace Nouvu\Resources\Entity\Database;

use Symfony\Component\Security\Core\User\UserInterface;
use Nouvu\Framework\Component\Database\StatementInterface;

use function Nouvu\Resources\System\Helpers\{ database };

class UsersPre
{
	public static function preConfirm( string $confirm ): array
	{
		return database() -> select( \UsersPre\By\Confirm :: class )( $confirm ) -> get( StatementInterface :: FETCH_ASSOC ) ?? [];
	}
	
	public static function remove( int $id ): void
	{
		database() -> delete( \UsersPre :: class )( $id );
	}
	
	public static function add( UserInterface $user, string $confirm ): void
	{
		database() -> insert( \UsersPre :: class )( $user -> getEmail(), $confirm );
	}
	
	public static function create(): void
	{
		database() -> create( \UsersPre :: class )();
	}
	
	public static function drop(): void
	{
		database() -> drop( \UsersPre :: class )();
	}
}

