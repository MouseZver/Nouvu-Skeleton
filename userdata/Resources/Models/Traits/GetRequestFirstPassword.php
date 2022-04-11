<?php

declare ( strict_types = 1 );

namespace Nouvu\Resources\Models\Traits;

use function Nouvu\Resources\System\Helpers\{ request };

trait GetRequestFirstPassword
{
	public function getRequestFirstPassword(): string
	{
		return request() -> request -> all( 'password' )['first'] ?? '';
	}
}
