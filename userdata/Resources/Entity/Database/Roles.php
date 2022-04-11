<?php

declare ( strict_types = 1 );

namespace Nouvu\Resources\Entity\Database;

//use Symfony\Component\Security\Core\User\UserInterface;
use Nouvu\Framework\Component\Database\StatementInterface;
use Nouvu\Resources\Entity\Role;

use function Nouvu\Resources\System\Helpers\{ database };

class Roles
{
	public static function add( string $name, string $role, array $role_hierarchy ): void
	{
		database() -> insert( \Roles :: class )( $name, $role, json_encode ( $role_hierarchy, JSON_UNESCAPED_SLASHES ) );
	}
	
	public static function addRows( array ...$rows ): void
	{
		foreach ( $rows AS [ $name, $message, $role, &$role_hierarchy ] )
		{
			$role_hierarchy = json_encode ( $role_hierarchy );
		}
		
		database() -> insert( \Roles\Rows :: class )( $rows );
	}
	
	public static function closure( \Closure $closure ): iterable
	{
		return database() -> select( \Roles :: class )() -> all( StatementInterface :: FETCH_FUNC, $closure );
	}
	
	public static function updateRow( int $id, string $name, string $role, array $role_hierarchy ): void
	{
		database() -> update( \Roles :: class )( $id, $name, $role, json_encode ( $role_hierarchy ) );
	}
	
	public static function updateHierarchy( array $hierarchy ): void
	{
		database() -> update( \Roles\Hierarchy\By\Id :: class )( $hierarchy );
	}
	
	public static function update( Role ...$roles ): void
	{
		database() -> update( \Roles :: class )( $roles );
	}
	
	public static function remove( int ...$ids ): void
	{
		$map = array_map ( fn ( int $id ): array => [ $id ], $ids );
		
		database() -> delete( \Roles :: class )( $map );
	}
	
	public static function uniqueId(): iterable
	{
		return database() -> select( \Roles :: class )() -> all( StatementInterface :: FETCH_UNIQUE, 'id' );
	}
	
	public static function roleHierarchy(): iterable
	{
		return database() -> select( \Roles\Group\Role\RoleHierarchy :: class )() 
			-> all( StatementInterface :: FETCH_KEY_PAIR | StatementInterface :: FETCH_FUNC, static function ( string $role, string $role_hierarchy ): array
			{
				return json_decode ( $role_hierarchy, true );
			} );
	}
	
	public static function create(): void
	{
		database() -> create( \Roles :: class )();
	}
	
	public static function drop(): void
	{
		database() -> drop( \Roles :: class )();
	}
}

