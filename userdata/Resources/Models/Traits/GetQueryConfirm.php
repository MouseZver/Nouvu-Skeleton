<?php

declare ( strict_types = 1 );

namespace Nouvu\Resources\Models\Traits;

use function Nouvu\Resources\System\Helpers\{ request };

trait GetQueryConfirm
{
	public function getQueryConfirm(): string
	{
		return request() -> query -> get( 'confirm', '' );
	}
}
