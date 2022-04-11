<?php

declare ( strict_types = 1 );

namespace Nouvu\Resources\Models\Traits\Permissions;

trait Permission
{
	public function getPermissionPermission( int $id ): string | null
	{
		return $this -> getPermissionsData( $id . '.permission' );
	}
}
