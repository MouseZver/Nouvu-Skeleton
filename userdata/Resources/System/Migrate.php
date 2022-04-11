<?php

declare ( strict_types = 1 );

namespace Nouvu\Resources\System;

use Nouvu\Framework\Foundation\Application;
use Nouvu\Resources\Entity\{ Database, User };

use function Nouvu\Resources\System\Helpers\{ config };

final class Migrate
{
	private const LIST_TABLES = [ 
		Database\Users :: class,
		Database\UsersPre :: class,
		Database\UsersProfile :: class,
		Database\UsersRole :: class,
		Database\Roles :: class,
		Database\Permissions :: class,
		Database\RememberMeToken :: class,
		Database\ForgotPassword :: class 
	];
	
	public function __construct ( Application $app )
	{
		$app -> container -> get( \Helpers :: class );
	}
	
	public function run(): void
	{
		$this -> dropTables();
		
		$this -> createTables();
		
		Database\Roles :: addRows(
			[ 'User (Default) - Не Удалять', 'Default роль - не изменять', 'ROLE_USER', [] ],
			[ 'Manager - Не Удалять', null, 'ROLE_MANAGER', [ 'ROLE_USER' ] ],
			[ 'Senior manager - Не Удалять', null, 'ROLE_SENIOR_MANAGER', [ 'ROLE_MANAGER' ] ],
			[ 'Administrator - Не Удалять', null, 'ROLE_ADMIN', [ 'ROLE_SENIOR_MANAGER' ] ],
			[ 'Super administrator - Не Удалять', null, 'ROLE_SUPER_ADMIN', [ 'ROLE_ADMIN' ] ],
			[ 'TEST', null, 'ROLE_TEST', [ 'ROLE_ADMIN', 'ROLE_SENIOR_MANAGER' ] ],
			[ 'TEST2', null, 'ROLE_TEST_TWO', [ 'ROLE_TEST' ] ],
		);
		
		Database\Permissions :: addRows(
			[ 'Панель - главная', 'panel.index.view', 'ROLE_ADMIN' ],
			[ 'Панель - роли', 'panel.roles.view', 'ROLE_ADMIN' ],
			[ 'Панель - разрешения', 'panel.permissions.view', 'ROLE_ADMIN' ],
			[ 'Роль - новая роль', 'panel.roles.add', 'ROLE_ADMIN' ],
			[ 'Роль - обновить/редактировать', 'panel.roles.update', 'ROLE_ADMIN' ],
			[ 'Роль - удалить', 'panel.roles.remove', 'ROLE_ADMIN' ],
			[ 'Разрешение - добавить', 'panel.permission.add', 'ROLE_ADMIN' ],
			[ 'Разрешение - обновить/редактировать', 'panel.permission.update', 'ROLE_ADMIN' ],
			[ 'Разрешение - удалить', 'panel.permission.remove', 'ROLE_ADMIN' ],
		);
		
		// 1 - user, 4 - Role
		Database\UsersRole :: addRows( [ 1, 4 ], [ 1, 6 ], [ 1, 7 ] );
		
		
		
		$hasher = config( 'security.encoder' )()[\Nouvu\Resources\Entity\User :: class];
		
		$user = new User;
		
		$user -> setUsername( '[Admin] MouseZver' );
		
		$user -> setEmail( 'mouse-zver@xaker.ru' );
		
		$user -> setRoles( [ 'ROLE_ADMIN', 'ROLE_TEST', 'ROLE_TEST_TWO' ] );
		
		$user -> setPassword( $hasher -> hash( '1234567890' ) );
		
		Database\Users :: add( $user );
	}
	
	private function dropTables(): void
	{
		foreach ( self :: LIST_TABLES AS $table )
		{
			$table :: drop();
		}
	}
	
	private function createTables(): void
	{
		foreach ( self :: LIST_TABLES AS $table )
		{
			$table :: create();
		}
	}
}