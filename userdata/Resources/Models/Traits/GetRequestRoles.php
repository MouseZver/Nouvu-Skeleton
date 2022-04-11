<?php

declare ( strict_types = 1 );

namespace Nouvu\Resources\Models\Traits;

use function Nouvu\Resources\System\Helpers\{ request };

trait GetRequestRoles
{
	public function getRequestRoles(): array
	{
		return request() -> request -> all( 'roles', [] );
	}
}
