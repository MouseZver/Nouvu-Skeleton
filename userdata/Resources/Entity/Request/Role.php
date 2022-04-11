<?php

declare ( strict_types = 1 );

namespace Nouvu\Resources\Entity\Request;

use function Nouvu\Resources\System\Helpers\{ request };

class Role
{
	public function getName(): string
	{
		return request() -> request -> get( 'name', '' );
	}
	
	public function getRole(): string
	{
		return request() -> request -> get( 'role', '' );
	}
	
	public function getRoleHierarchy(): array
	{
		return array_map ( 'intval', request() -> request -> all( 'role_hierarchy', [] ) );
	}
}