<?php

declare ( strict_types = 1 );

namespace Nouvu\Resources\Models\Traits\Permissions;

trait Name
{
	public function getPermissionName( int $id ): string | null
	{
		return $this -> getPermissionsData( $id . '.name' );
	}
}
