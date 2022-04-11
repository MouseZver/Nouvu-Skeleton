<?php

declare ( strict_types = 1 );

namespace Nouvu\Resources\Models\Admin\Panel\Roles;

use Nouvu\Resources\Models\AbstractModel;

use function Nouvu\Resources\System\Helpers\{ roles, container };

final class AddModel extends AbstractModel
{
	public function add(): void
	{
		roles() -> add();
		
		container() -> reset( 'security.user.roles' );
	}
}
