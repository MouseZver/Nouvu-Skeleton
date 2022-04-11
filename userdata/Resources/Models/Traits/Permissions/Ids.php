<?php

declare ( strict_types = 1 );

namespace Nouvu\Resources\Models\Traits\Permissions;

trait Ids
{
	public function getPermissionIds(): array
	{
		return array_keys ( $this -> getPermissionsData() );
	}
}
