<?php

declare ( strict_types = 1 );

namespace Nouvu\Resources\Models\Traits\Permissions;

use Nouvu\Resources\Entity\{ Database, Permission };

use function Nouvu\Resources\System\Helpers\{ config };

trait Data
{
	private function getPermissionsData( string $offset = null ): mixed
	{
		if ( ! config() -> has( 'app.system.permissions' ) )
		{
			$this -> resetDataPermissions();
		}
		
		if ( is_string ( $offset ) )
		{
			return config( 'app.system.permissions.' . $offset );
		}
		
		$map = config( 'app.system.permissions' );
		
		unset ( $map['meta'] );
		
		return $map;
	}
	
	private function resetDataPermissions(): void
	{
		$map = [];
		
		Database\Permissions :: closure( function ( object $std ) use ( &$map ): bool
		{
			$permission = new Permission;
			
			config( 'entity.permission' ) -> call( $permission, $std );
			
			$map['meta']['roles'][ $permission -> getRole() ][] = $permission -> getId();
			
			$map[ $permission -> getId() ] = $permission;
			
			return true;
		} );
		
		config() -> set( 'app.system.roles', $map );
		
		
		$map = [];
		
		Database\Permissions :: closure( function ( object $std ) use ( &$map ): bool
		{
			$map['meta']['roles'][ $std -> role ][] = $std -> id;
			
			$map[$std -> id] = new \ArrayObject( $std, \ArrayObject :: ARRAY_AS_PROPS );
			
			return true;
		} );
		
		config() -> set( 'app.system.permissions', $map );
	}
	
	public function isPermission( int | string $id ): bool
	{
		return ! empty ( $this -> getPermissionsData( ( string ) $id ) );
	}
}
