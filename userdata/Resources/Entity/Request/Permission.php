<?php

declare ( strict_types = 1 );

namespace Nouvu\Resources\Entity\Request;

use function Nouvu\Resources\System\Helpers\{ request };

class Permission
{
	public function getName(): string
	{
		return request() -> request -> get( 'name', '' );
	}
	
	public function getPermission(): string
	{
		return request() -> request -> get( 'permission', '' );
	}
	
	public function getRole(): string
	{
		return request() -> request -> get( 'role', '' );
	}
}