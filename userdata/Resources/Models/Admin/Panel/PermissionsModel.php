<?php

declare ( strict_types = 1 );

namespace Nouvu\Resources\Models\Admin\Panel;

use Nouvu\Resources\Models\{ AbstractModel, Traits };
use Nouvu\Resources\System\BuilderHtml\{ Builder, CreateMap };

use function Nouvu\Resources\System\Helpers\{ app, routerPathByName, config, permissions, roles };

final class PermissionsModel extends AbstractModel
{
	use Traits\Form\Select\Roles;
	
	public function getListPermission(): string
	{
		$string = '';
		
		foreach ( permissions() -> getList() AS $id => $permission )
		{
			$role_id = roles() -> metaRole( $permission -> getRole() );
			
			$string .= $this -> getInclude( 'admin-panel/blocks/permissions/permission', [
				'{{id}}' => $id,
				'{{name}}' => $permission -> getName(),
				'{{permission}}' => $permission -> getPermission(),
				'{{role}}' => ( $role_id ? roles() -> get( $role_id ) -> getName() : $permission -> getRole() ),
				'{{linkEdit}}' => strtr ( routerPathByName( 'api-panel-permission-update' ), [ '{id}' => $id ] ),
				'{{linkRemove}}' => strtr ( routerPathByName( 'api-panel-permission-remove' ), [ '{id}' => $id ] ),
			] ) . PHP_EOL;
		}
		
		return $string ?: ( string ) new Builder ( [
			CreateMap :: create( 'tr' ) -> content( [ 
				CreateMap :: create( 'td' ) -> data( colspan: 3, class: 'text-center' ) -> content( 'Список пуст' )
			] )
		] );
	}
	
	public function getSelectOptions( int $id ): string
	{
		$permissionRole = permissions() -> get( $id ) -> getRole();
		
		$options = [];
		
		foreach ( roles() -> getList() AS $role_id => $role )
		{
			$data = [ 'value' => $role_id ];
			
			if ( $permissionRole === $role -> getRole() )
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
		app() -> validator -> validate( 'POST', config( 'validator.form.permission' ) );
	}
}
