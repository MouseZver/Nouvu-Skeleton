<?php

declare ( strict_types = 1 );

namespace Nouvu\Resources\Entity\Database;

//use Symfony\Component\Security\Core\User\UserInterface;
use Nouvu\Framework\Component\Database\StatementInterface;

use function Nouvu\Resources\System\Helpers\{ database };

class UsersRole
{
	public static function rolesCount(): iterable
	{
		return database() -> select( \UsersRole\RoleId\CountId\Group\RoleId :: class )() -> all( StatementInterface :: FETCH_KEY_PAIR );
	}
	
	public static function usersRole( int ...$roles_id ): iterable
	{
		return database() -> select( \UsersRole\UserId\By\RoleId :: class )( array_map ( fn ( int $id ): array => [ $id ], $roles_id ) ) 
			-> all( StatementInterface :: FETCH_COLUMN );
	}
	
	public static function removeRole( array ...$roles_id ): void
	{
		database() -> delete( \UsersRole\By\RoleId :: class )( $roles_id );
	}
	
	public static function addRows( array ...$rows ): void
	{
		database() -> insert( \UsersRole\Rows :: class )( $rows );
	}
	
	public static function create(): void
	{
		database() -> create( \UsersRole :: class )();
	}
	
	public static function drop(): void
	{
		database() -> drop( \UsersRole :: class )();
	}
}

