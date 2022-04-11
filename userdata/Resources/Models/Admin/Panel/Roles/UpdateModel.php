<?php

declare ( strict_types = 1 );

namespace Nouvu\Resources\Models\Admin\Panel\Roles;

use Nouvu\Resources\Models\AbstractModel;

use function Nouvu\Resources\System\Helpers\{ roles, container };

final class UpdateModel extends AbstractModel
{
	public function update( int $id ): void
	{
		roles() -> update( $id );
		
		container() -> reset( 'security.user.roles' );
	}
}
