<?php

declare ( strict_types = 1 );

namespace Nouvu\Resources\Models\Traits;

use function Nouvu\Resources\System\Helpers\{ request };

trait GetRequestSecondPassword
{
	public function getRequestSecondPassword(): string
	{
		return request() -> request -> all( 'password' )['second'] ?? '';
	}
}
