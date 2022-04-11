<?php

declare ( strict_types = 1 );

namespace Nouvu\Resources\Models\Traits\Roles;

trait Name
{
	public function getRoleName( int | string $id ): ?string
	{
		return $this -> getRolesData( $id ) ?-> getName();
	}
}
