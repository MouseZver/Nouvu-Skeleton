<?php

declare ( strict_types = 1 );

namespace Nouvu\Resources\Models\Traits\Roles;

trait Ids
{
	public function getRoleIds(): array
	{
		return array_keys ( $this -> getRolesData() );
	}
}
