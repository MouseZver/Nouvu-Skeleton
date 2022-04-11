<?php

declare ( strict_types = 1 );

namespace Nouvu\Resources\Models\Traits\Roles;

trait Hierarchy
{
	public function getRoleHierarchy( int | string $id ): ?array
	{
		return $this -> getRolesData( $id ) ?-> getRoleHierarchy();
	}
}
