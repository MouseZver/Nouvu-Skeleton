<?php

declare ( strict_types = 1 );

namespace Nouvu\Resources\Models\Traits\Roles;

use Nouvu\Resources\Entity\{ Database, Role };

use function Nouvu\Resources\System\Helpers\{ config };

trait Data
{
	private function getRolesData( int | string $offset = null ): mixed
	{
		if ( ! config() -> has( 'app.system.roles' ) )
		{
			$this -> resetDataRoles();
		}
		
		if ( ! is_null ( $offset ) )
		{
			return config( 'app.system.roles.' . $offset );
		}
		
		$map = config( 'app.system.roles' );
		
		unset ( $map['meta'] );
		
		return $map;
	}
	
	private function resetDataRoles(): void
	{
		$map = [];
		
		Database\Roles :: closure( function ( object $std ) use ( &$map ): bool
		{
			$role = new Role;
			
			config( 'entity.role' ) -> call( $role, $std );
			
			$map['meta']['roles'][ $role -> getRole() ] = $role -> getId();
			
			foreach ( $role -> getRoleHierarchy() AS $role_hierarchy )
			{
				$map['meta']['hierarchy'][ $role_hierarchy ][] = $role -> getId();
			}
			
			$map[ $role -> getId() ] = $role;
			
			return true;
		} );
		
		config() -> set( 'app.system.roles', $map );
	}
	
	public function isRole( int | string $id ): bool
	{
		return ! empty ( $this -> getRolesData( $id ) );
	}
}
