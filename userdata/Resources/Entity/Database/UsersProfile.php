<?php

declare ( strict_types = 1 );

namespace Nouvu\Resources\Entity\Database;

//use Symfony\Component\Security\Core\User\UserInterface;
use Nouvu\Framework\Component\Database\StatementInterface;

use function Nouvu\Resources\System\Helpers\{ database };

class UsersProfile
{
	public static function rolesCount(): iterable
	{
		return database() -> select( \UsersProfile\Value\Count\By\Name\Group\Value :: class )( 'role' ) -> all( StatementInterface :: FETCH_KEY_PAIR );
	}
	
	public static function usersIdByRole( string $role ): iterable
	{
		return database() -> select( \UsersProfile\UserId\By\Name\Value :: class )( 'role', $role ) -> all( StatementInterface :: FETCH_COLUMN );
	}
	
	public static function updateValue( string $role, string | int ...$ids ): void
	{
		database() -> update( \UsersProfile\Value\By\Id :: class )( $ids, $role );
	}
	
	public static function removeRole( string $role ): void
	{
		database() -> delete( \UsersProfile\By\Name\Value :: class )( 'role', $role );
	}
	
	public static function groupRole( string $role ): iterable
	{
		return database() -> select( \UsersProfile\By\Name\Value :: class )( 'role', $role ) -> all( StatementInterface :: FETCH_GROUP, 'value' );
	}
	
	public static function add( array ...$rows ): void
	{
		database() -> insert( \UsersProfile :: class )( $rows );
	}
	
	public static function create(): void
	{
		database() -> create( \UsersProfile :: class )();
	}
	
	public static function drop(): void
	{
		database() -> drop( \UsersProfile :: class )();
	}
}

