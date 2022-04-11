<?php

declare ( strict_types = 1 );

namespace Nouvu\Resources\Controllers\Panel\Api;

use Nouvu\Framework\Component\Validator\Exception\ViolationsException;
use Nouvu\Framework\Http\Controllers\AbstractController;
use Nouvu\Framework\View\Repository\CommitRepository;
use Nouvu\Framework\View\Builder\Content;
use Nouvu\Resources\System\RestApi;

use function Nouvu\Resources\System\Helpers\{ rolePermission, isAjax, isMethodPost, isGranted, routerPathByName, permissions };

final class PermissionController extends AbstractController
{
	public function add(): CommitRepository
	{
		if ( ! isGranted( rolePermission( 'panel.permission.add' ) ) )
		{
			return $this -> accessDenied();
		}
		
		if ( ! isAjax() )
		{
			return $this -> redirect( routerPathByName( 'admin-panel-permissions-view' ) );
		}
		
		$permissions = $this -> model( \Admin\Panel\Permissions :: class );
		
		$this -> setThreadTitles( 'Список разрешений', 'Панель управления' );
		
		if ( isMethodPost() )
		{
			try
			{
				$permissions -> validation();
				
				$this -> model( \Admin\Panel\Permissions\Add :: class ) -> add();
			}
			catch ( ViolationsException $e )
			{
				return $this -> customJson( RestApi :: success() -> errorMessages( ...$e -> getErrors() ) );
			}
			
			return $this -> json( 'admin-panel/list-permissions', body: '.content-body' );
		}
		
		return $this -> json( 'admin-panel/blocks/permissions/add-permission', [ 
			'options' => $permissions -> getSelectOptionsAll(),
		], 
		'.nouvu-modal-edit' );
	}
	
	public function update( int $id ): CommitRepository
	{
		if ( ! isGranted( rolePermission( 'panel.permission.update' ) ) )
		{
			return $this -> accessDenied();
		}
		
		if ( ! isAjax() )
		{
			return $this -> redirect( routerPathByName( 'admin-panel-permissions-view' ) );
		}
		
		$this -> setThreadTitles( 'Список разрешений', 'Панель управления' );
		
		$permissions = $this -> model( \Admin\Panel\Permissions :: class );
		
		if ( ! permissions() -> isPermission( $id ) )
		{
			return $this -> render( 'admin-panel/list-permissions', 'admin-panel/panel-template', body: '.content-body' );
		}
		
		if ( isMethodPost() )
		{
			try
			{
				$permissions -> validation();
				
				$this -> model( \Admin\Panel\Permissions\Update :: class ) -> update( $id );
			}
			catch ( ViolationsException $e )
			{
				return $this -> customJson( RestApi :: success() -> errorMessages( ...$e -> getErrors() ) );
			}
			
			return $this -> json( 'admin-panel/list-permissions', body: '.content-body' );
		}
		
		return $this -> json( 'admin-panel/blocks/permissions/edit-permission', [ 
			'linkEdit' => strtr ( routerPathByName( 'api-panel-permission-update' ), [ '{id}' => $id ] ),
			'name' => permissions() -> get( $id ) -> getName(),
			'permission' => permissions() -> get( $id ) -> getPermission(),
			'options' => $permissions -> getSelectOptions( $id ),
		], 
		'.nouvu-modal-edit' );
	}
	
	public function remove( int $id ): CommitRepository
	{
		if ( ! isGranted( rolePermission( 'panel.permission.remove' ) ) )
		{
			return $this -> accessDenied();
		}
		
		if ( ! isAjax() )
		{
			return $this -> redirect( routerPathByName( 'admin-panel-permissions-view' ) );
		}
		
		$this -> model( \Admin\Panel\Permissions :: class );
		
		$this -> setThreadTitles( 'Список разрешений', 'Панель управления' );
		
		if ( permissions() -> isPermission( $id ) )
		{
			if ( isMethodPost() )
			{
				$this -> model( \Admin\Panel\Permissions\Remove :: class ) -> remove( $id );
			}
			else
			{
				return $this -> json( 'admin-panel/blocks/permissions/confirm-remove', [
					'id' => $id,
					'name' => permissions() -> get( $id ) -> getName(),
					'linkRemove' => strtr ( routerPathByName( 'api-panel-permission-remove' ), [ '{id}' => $id ] ),
				], 
				'.nouvu-modal-confirm' );
			}
		}
		
		return $this -> render( 'admin-panel/list-permissions', 'admin-panel/panel-template', body: '.content-body' );
	}
}
