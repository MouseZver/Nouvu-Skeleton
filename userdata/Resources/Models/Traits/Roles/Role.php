<?php

declare ( strict_types = 1 );

namespace Nouvu\Resources\Models\Traits\Roles;

trait Role
{
	public function getRoleRole( int | string $id ): ?string
	{
		return $this -> getRolesData( $id ) ?-> getRole();
	}
}
