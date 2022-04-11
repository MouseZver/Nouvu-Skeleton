<?php

declare ( strict_types = 1 );

namespace Nouvu\Resources\Models\Admin\Panel\Permissions;

use Nouvu\Resources\Models\AbstractModel;

use function Nouvu\Resources\System\Helpers\{ permissions, container };

final class AddModel extends AbstractModel
{
	public function add(): void
	{
		permissions() -> add();
		
		container() -> reset( 'security.user.permissions' );
	}
}
