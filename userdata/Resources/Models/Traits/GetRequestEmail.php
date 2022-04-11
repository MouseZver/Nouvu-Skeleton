<?php

declare ( strict_types = 1 );

namespace Nouvu\Resources\Models\Traits;

use function Nouvu\Resources\System\Helpers\{ request };

trait GetRequestEmail
{
	public function getRequestEmail(): string
	{
		return request() -> request -> get( 'email', '' );
	}
}
