<?php

declare ( strict_types = 1 );

namespace Nouvu\Resources\Models\Admin\Panel\Roles;

use Nouvu\Resources\Models\AbstractModel;

use function Nouvu\Resources\System\Helpers\{ roles, container };

final class RemoveModel extends AbstractModel
{
	public function remove( int $id ): void
	{
		roles() -> remove( $id );
		
		container() -> reset( 'security.user.roles' );
	}
}
