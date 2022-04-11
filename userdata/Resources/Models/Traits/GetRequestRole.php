<?php

declare ( strict_types = 1 );

namespace Nouvu\Resources\Models\Traits;

use function Nouvu\Resources\System\Helpers\{ request };

trait GetRequestRole
{
	public function getRequestRole(): string
	{
		return request() -> request -> get( 'role', '' );
	}
}
