<?php

declare ( strict_types = 1 );

namespace Nouvu\Resources\Models\Traits\Roles;

trait Meta
{
	public function getRoleMetaRole( string $role ): ?int
	{
		return $this -> getRolesData( 'meta.roles.' . $role );
	}
	
	public function getRoleMetaRoleHierarchy( string $role ): iterable
	{
		return $this -> getRolesData( 'meta.hierarchy.' . $role ) ?? [];
	}
}
