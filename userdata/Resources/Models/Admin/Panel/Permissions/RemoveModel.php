<?php

declare ( strict_types = 1 );

namespace Nouvu\Resources\Models\Admin\Panel\Permissions;

use Nouvu\Resources\Models\AbstractModel;

use function Nouvu\Resources\System\Helpers\{ permissions, container };

final class RemoveModel extends AbstractModel
{
	public function remove( int $id ): void
	{
		permissions() -> remove( $id );
		
		container() -> reset( 'security.user.permissions' );
	}
}
