<?php

declare ( strict_types = 1 );

namespace Nouvu\Resources\Models\Traits;

use function Nouvu\Resources\System\Helpers\{ request };

trait GetRequestPermission
{
	public function getRequestPermission(): string
	{
		return request() -> request -> get( 'permission', '' );
	}
}
