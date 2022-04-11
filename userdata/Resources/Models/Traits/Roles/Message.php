<?php

declare ( strict_types = 1 );

namespace Nouvu\Resources\Models\Traits\Roles;

trait Message
{
	public function getRoleMessage( int | string $id ): ?string
	{
		return $this -> getRolesData( $id ) ?-> getMessage();
	}
}
