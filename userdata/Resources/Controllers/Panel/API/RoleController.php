<?php

declare ( strict_types = 1 );

namespace Nouvu\Resources\Controllers\Panel\Api;

use Nouvu\Framework\Component\Validator\Exception\ViolationsException;
use Nouvu\Framework\Http\Controllers\AbstractController;
use Nouvu\Framework\View\Repository\CommitRepository;
use Nouvu\Framework\View\Builder\Content;
use Nouvu\Resources\System\RestApi;

use function Nouvu\Resources\System\Helpers\{ rolePermission, isAjax, isMethodPost, isGranted, routerPathByName, roles };

final class RoleController extends AbstractController
{
	public function add(): CommitRepository
	{
		if ( ! isGranted( rolePermission( 'panel.roles.add' ) ) )
		{
			return $this -> accessDenied();
		}
		
		if ( ! isAjax() )
		{
			return $this -> redirect( routerPathByName( 'admin-panel-roles-view' ) );
		}
		
		$roles = $this -> model( \Admin\Panel\Roles :: class );
		
		$this -> setThreadTitles( 'Список ролей', 'Панель управления' );
		
		if ( isMethodPost() )
		{
			try
			{
				$roles -> validation();
				
				$this -> model( \Admin\Panel\Roles\Add :: class ) -> add();
			}
			catch ( ViolationsException $e )
			{
				return $this -> customJson( RestApi :: success() -> errorMessages( ...$e -> getErrors() ) );
			}
			
			return $this -> json( 'admin-panel/list-roles', body: '.content-body' );
		}
		
		return $this -> json( 'admin-panel/blocks/roles/add-role', [ 
			'label' => 'Данная роль может унаследовать иерархию следующих ролей:',
			'options' => $roles -> getSelectOptionsAll(),
		], 
		'.nouvu-modal-edit' );
	}
	
	public function update( int $id ): CommitRepository
	{
		if ( ! isGranted( rolePermission( 'panel.roles.update' ) ) )
		{
			return $this -> accessDenied();
		}
		
		if ( ! isAjax() )
		{
			return $this -> redirect( routerPathByName( 'admin-panel-roles-view' ) );
		}
		
		$this -> setThreadTitles( 'Список ролей', 'Панель управления' );
		
		$roles = $this -> model( \Admin\Panel\Roles :: class );
		
		if ( ! roles() -> isRole( $id ) )
		{
			return $this -> render( 'admin-panel/list-roles', 'admin-panel/panel-template', body: '.content-body' );
		}
		
		if ( isMethodPost() )
		{
			try
			{
				$roles -> validation();
				
				$this -> model( \Admin\Panel\Roles\Update :: class ) -> update( $id );
			}
			catch ( ViolationsException $e )
			{
				return $this -> customJson( RestApi :: success() -> errorMessages( ...$e -> getErrors() ) );
			}
			
			return $this -> json( 'admin-panel/list-roles', body: '.content-body' );
		}
		
		return $this -> json( 'admin-panel/blocks/roles/edit-role', [ 
			'linkEdit' => strtr ( routerPathByName( 'api-panel-role-update' ), [ '{id}' => $id ] ),
			'name' => roles() -> get( $id ) -> getName(),
			'label' => roles() -> get( $id ) -> getMessage() ?: 'Роль может унаследовать иерархию других ролей',
			'role' => roles() -> get( $id ) -> getRole(),
			'options' => $roles -> getSelectOptions( $id ),
		], 
		'.nouvu-modal-edit' );
	}
	
	public function remove( int $id ): CommitRepository
	{
		if ( ! isGranted( rolePermission( 'panel.roles.remove' ) ) )
		{
			return $this -> accessDenied();
		}
		
		if ( ! isAjax() )
		{
			return $this -> redirect( routerPathByName( 'admin-panel-roles-view' ) );
		}
		
		$this -> model( \Admin\Panel\Roles :: class );
		
		$this -> setThreadTitles( 'Список ролей', 'Панель управления' );
		
		if ( roles() -> isRole( $id ) )
		{
			if ( isMethodPost() )
			{
				$this -> model( \Admin\Panel\Roles\Remove :: class ) -> remove( $id );
			}
			else
			{
				return $this -> json( 'admin-panel/blocks/roles/confirm-remove', [
					'id' => $id,
					'name' => roles() -> get( $id ) -> getName(),
					'linkRemove' => strtr ( routerPathByName( 'api-panel-role-remove' ), [ '{id}' => $id ] ),
				], 
				'.nouvu-modal-confirm' );
			}
		}
		
		return $this -> render( 'admin-panel/list-roles', 'admin-panel/panel-template', body: '.content-body' );
	}
}
