<?php

declare ( strict_types = 1 );

namespace Nouvu\Resources\Controllers\Panel;

use Nouvu\Framework\Http\Controllers\AbstractController;
use Nouvu\Framework\View\Repository\CommitRepository;

use function Nouvu\Resources\System\Helpers\{ rolePermission, isGranted };

final class AdminController extends AbstractController
{
	public function index(): CommitRepository
	{
		/*if ( ! isGranted( rolePermission( 'panel.index.view' ) ) )
		{
			return $this -> accessDenied();
		}
		
		$this -> setThreadTitles( 'Главная', 'Панель управления' );
		
		$this -> model( \Admin\Panel\Roles :: class );
		
		return $this -> render( 'admin-panel/list-roles', 'admin-panel/panel-template', body: '.content-body' );
		
		return $this -> roles();*/
	}
	
	public function roles(): CommitRepository
	{
		if ( ! isGranted( rolePermission( 'panel.roles.view' ) ) )
		{
			return $this -> accessDenied();
		}
		
		$this -> setThreadTitles( 'Список ролей', 'Панель управления' );
		
		$this -> model( \Admin\Panel\Roles :: class );
		
		return $this -> render( 'admin-panel/list-roles', 'admin-panel/panel-template', body: '.content-body' );
	}
	
	public function permissions(): CommitRepository
	{
		if ( ! isGranted( rolePermission( 'panel.permissions.view' ) ) )
		{
			return $this -> accessDenied();
		}
		
		$this -> setThreadTitles( 'Список разрешений', 'Панель управления' );
		
		$this -> model( \Admin\Panel\Permissions :: class );
		
		return $this -> render( 'admin-panel/list-permissions', 'admin-panel/panel-template', body: '.content-body' );
	}
	
	public function admins(): CommitRepository
	{
		if ( ! isGranted( rolePermission( 'panel.admins.view' ) ) )
		{
			return $this -> accessDenied();
		}
		
		$this -> setThreadTitles( 'Список администрации', 'Панель управления' );
		
		$this -> model( \Admin\Panel\Permissions :: class );
		
		return $this -> render( 'admin-panel/list-admins', 'admin-panel/panel-template', body: '.content-body' );
	}
}
