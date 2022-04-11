<?php

declare ( strict_types = 1 );

namespace Nouvu\Resources\Models\Traits;

use function Nouvu\Resources\System\Helpers\{ request };

trait GetRequestUsername
{
	public function getRequestUsername(): string
	{
		return request() -> request -> get( 'username', '' );
	}
}
