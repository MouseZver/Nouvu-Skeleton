<?php

declare ( strict_types = 1 );

namespace Nouvu\Resources\Models\Traits\Permissions;

trait Roles
{
	public function getPermissionRole( int | string $id ): ?string
	{
		return $this -> getPermissionsData( $id ) ?-> getRole();
	}
}
