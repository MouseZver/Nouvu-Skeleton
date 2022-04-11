<?php

declare ( strict_types = 1 );

namespace Nouvu\Resources\Models\Admin\Panel\Permissions;

use Nouvu\Resources\Models\AbstractModel;

use function Nouvu\Resources\System\Helpers\{ permissions, container };

final class UpdateModel extends AbstractModel
{
	public function update( int $id ): void
	{
		permissions() -> update( $id );
		
		container() -> reset( 'security.user.permissions' );
	}
}
