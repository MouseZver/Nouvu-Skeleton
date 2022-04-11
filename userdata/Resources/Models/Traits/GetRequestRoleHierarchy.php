<?php

declare ( strict_types = 1 );

namespace Nouvu\Resources\Models\Traits;

use function Nouvu\Resources\System\Helpers\{ request };

trait GetRequestRoleHierarchy
{
	public function getRequestRoleHierarchy(): iterable
	{
		return request() -> request -> all( 'role_hierarchy', [] );
	}
}
