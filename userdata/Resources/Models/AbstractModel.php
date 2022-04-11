<?php

declare ( strict_types = 1 );

namespace Nouvu\Resources\Models;

use Nouvu\Framework\View\Builder\Content;

use function Nouvu\Resources\System\Helpers\{ container, routerPathByName };

class AbstractModel
{
	protected function getInclude( string $path, array $replace = [] ): string
	{
		return strtr ( container( Content :: class ) -> get() -> getInclude( $path ), $replace );
	}
	
	protected function getPathByName( string | int $name ): string
	{
		return routerPathByName( $name );
	}
}