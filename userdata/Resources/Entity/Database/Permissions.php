<?php

declare ( strict_types = 1 );

namespace Nouvu\Resources\Entity\Database;

use Symfony\Component\Security\Core\User\UserInterface;
use Nouvu\Framework\Component\Database\StatementInterface;

use function Nouvu\Resources\System\Helpers\{ database };

class Permissions
{
	public static function rolePermission( string $permission ): string | null
	{
		return database() -> select( \Permissions\Role\By\Permission :: class )( $permission ) -> get( StatementInterface :: FETCH_COLUMN );
	}
	
	public static function closure( \Closure $closure ): iterable
	{
		return database() -> select( \Permissions :: class )() -> all( StatementInterface :: FETCH_FUNC, $closure );
	}
	
	public static function add( string $name, string $permission, string $role ): void
	{
		database() -> insert( \Permissions :: class )( $name, $permission, $role );
	}
	
	public static function addRows( array ...$rows ): void
	{
		database() -> insert( \Permissions\Rows :: class )( $rows );
	}
	
	public static function remove( int $id ): void
	{
		database() -> delete( \Permissions\By\Id :: class )( $id );
	}
	
	public static function updateRow( int $id, string $name, string $permission, string $role ): void
	{
		database() -> update( \Permissions\By\Id :: class )( $id, $name, $permission, $role );
	}
	
	public static function updateRoles( array $roles ): void
	{
		database() -> update( \Permissions\Role\By\Id :: class )( $roles );
	}
	
	public static function replaceRoles( array ...$replaceRoles ): void
	{
		database() -> update( \Permissions\Role\By\Role :: class )( $replaceRoles );
	}
	
	public static function uniqueId(): iterable
	{
		return database() -> select( \Permissions :: class )() -> all( StatementInterface :: FETCH_UNIQUE, 'id' );
	}
	
	public static function create(): void
	{
		database() -> create( \Permissions :: class )();
	}
	
	public static function drop(): void
	{
		database() -> drop( \Permissions :: class )();
	}
}

