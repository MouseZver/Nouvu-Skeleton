<?php

declare ( strict_types = 1 );

namespace Nouvu\Resources\Models\Traits;

use function Nouvu\Resources\System\Helpers\{ request };

trait GetRequestPassword
{
	public function getRequestPassword(): string
	{
		return request() -> request -> get( 'password', '' );
	}
}
