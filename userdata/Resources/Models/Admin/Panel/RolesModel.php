<?php

declare ( strict_types = 1 );

namespace Nouvu\Resources\Models\Admin\Panel;

use Nouvu\Resources\Models\{ AbstractModel, Traits };
use Nouvu\Resources\System\BuilderHtml\{ Builder, CreateMap };
use Nouvu\Resources\Entity\Database;

use function Nouvu\Resources\System\Helpers\{ app, container, routerPathByName, config, roles };

final class RolesModel extends AbstractModel
{
	use Traits\Form\Select\Roles;
	
	public function getListRoles(): string
	{
		$rolesCount = Database\UsersRole :: rolesCount();
		
		$string = '';
		
		$add = 0;
		
		foreach ( roles() -> getList() AS $id => $role )
		{
			if ( ( ++$add ) == 3 )
			{
				$string .= $this -> getInclude( 'admin-panel/blocks/roles/window-add-role' ) . PHP_EOL;
			}
			
			$string .= $this -> getInclude( 'admin-panel/blocks/roles/role', [
				'{{id}}' => $id,
				'{{name}}' => $role -> getName(),
				'{{total}}' => $rolesCount[ $role -> getId() ] ?? 0,
				'{{linkEdit}}' => strtr ( routerPathByName( 'api-panel-role-update' ), [ '{id}' => $id ] ),
				'{{linkRemove}}' => strtr ( routerPathByName( 'api-panel-role-remove' ), [ '{id}' => $id ] ),
			] ) . PHP_EOL;
		}
		
		if ( $add < 3 )
		{
			$string .= $this -> getInclude( 'admin-panel/blocks/roles/window-add-role' ) . PHP_EOL;
		}
		
		return $string;
	}
	
	public function getSelectOptions( int $id ): string
	{
		$hierarchy = roles() -> get( $id ) -> getRoleHierarchy();
		
		$options = [];
		
		foreach ( roles() -> getList() AS $role_id => $role )
		{
			if ( $id == $role_id )
			{
				continue;
			}
			
			$data = [ 'value' => $role_id ];
			
			if ( in_array ( $role -> getRole(), $hierarchy, true ) )
			{
				$data['selected'] = '';
			}
			
			$options[] = CreateMap :: create( 'option' ) -> data( ...$data ) -> content( $role -> getName() );
		}
		
		return ( string ) new Builder( [ 
			CreateMap :: create( 'optgroup' ) -> data( label: 'Список ролей' ) -> content( $options ) 
		] );
	}
	
	public function validation(): void
	{
		app() -> validator -> validate( 'POST', config( 'validator.form.role' ) );
	}
}
