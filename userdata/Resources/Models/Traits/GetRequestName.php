<?php

declare ( strict_types = 1 );

namespace Nouvu\Resources\Models\Traits;

use function Nouvu\Resources\System\Helpers\{ request };

trait GetRequestName
{
	public function getRequestName(): string
	{
		return request() -> request -> get( 'name', '' );
	}
}
