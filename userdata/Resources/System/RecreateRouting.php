<?php

declare ( strict_types = 1 );

namespace Nouvu\Resources\System;

final class RecreateRouting
{
	private static array $data = [
		404 => [
			'edit' => false,
		],
		500 => [
			'edit' => false,
			'route' => [
				'path' => '/error/500',
				'controller' => [ '_controller' => [ \Main :: class, 'err500' ] ],
			],
		],
		'index' => [
			'route' => [
				'path' => '/',
				'controller' => [ '_controller' => [ \Main :: class, 'index' ] ],
			]
		],
		/*
			- Auth
		*/
		'register' => [
			'route' => [
				'path' => '/registration',
				'controller' => [ '_controller' => [ \Auth :: class, 'register' ] ],
				'methods' => [ 'GET', 'POST' ],
			]
		],
		'account-activation' => [
			'route' => [
				'path' => '/confirm-account',
				'controller' => [ '_controller' => [ \Auth :: class, 'activation' ] ],
				'methods' => [ 'GET' ],
			]
		],
		'login' => [
			'route' => [
				'path' => '/login',
				'controller' => [ '_controller' => [ \Auth :: class, 'login' ] ],
				'methods' => [ 'GET', 'POST' ],
			]
		],
		'logout' => [
			'route' => [
				'path' => '/logout',
				'controller' => [ '_controller' => [ \Auth :: class, 'logout' ] ],
			]
		],
		'forgot-password' => [
			'route' => [
				'path' => '/forgot-password',
				'controller' => [ '_controller' => [ \Auth :: class, 'forgotPassword' ] ],
				'methods' => [ 'GET', 'POST' ],
			]
		],
		'lost-password' => [
			'route' => [
				'path' => '/lost-password',
				'controller' => [ '_controller' => [ \Auth :: class, 'lostPassword' ] ],
				'methods' => [ 'GET', 'POST' ],
			]
		],
		/*
			- AdminPanel
		*/
		'admin-panel' => [
			'route' => [
				'path' => '/panel',
				'controller' => [ '_controller' => [ \Panel\Admin :: class, 'roles' ] ],
				'methods' => [ 'GET', 'POST' ],
			]
		],
		'admin-panel-roles-view' => [
			'route' => [
				'path' => '/panel/roles',
				'controller' => [ '_controller' => [ \Panel\Admin :: class, 'roles' ] ],
				'methods' => [ 'GET', 'POST' ],
			]
		],
		'admin-panel-permissions-view' => [
			'route' => [
				'path' => '/panel/permissions',
				'controller' => [ '_controller' => [ \Panel\Admin :: class, 'permissions' ] ],
				'methods' => [ 'GET', 'POST' ],
			]
		],
		'admin-panel-routing-view' => [
			'route' => [
				'path' => '/panel/routing',
				'controller' => [ '_controller' => [ \Panel\Admin :: class, 'routing' ] ],
				'methods' => [ 'GET', 'POST' ],
			]
		],
		'admin-panel-admins-view' => [
			'route' => [
				'path' => '/panel/admins',
				'controller' => [ '_controller' => [ \Panel\Admin :: class, 'admins' ] ],
				'methods' => [ 'GET', 'POST' ],
			]
		],
		'admin-panel-users-view' => [
			'route' => [
				'path' => '/panel/users',
				'controller' => [ '_controller' => [ \Panel\Admin :: class, 'users' ] ],
				'methods' => [ 'GET', 'POST' ],
			]
		],
		/*
			- API AdminPanel 
		*/
		/*
			- Role
		*/
		'api-panel-role-add' => [
			'route' => [
				'path' => '/panel/api/role/add',
				'controller' => [ '_controller' => [ \Panel\API\Role :: class, 'add' ] ],
				'methods' => [ 'GET', 'POST' ],
			]
		],
		'api-panel-role-update' => [
			'route' => [
				'path' => '/panel/api/role/update/{id}',
				'controller' => [ '_controller' => [ \Panel\API\Role :: class, 'update' ] ],
				'methods' => [ 'GET', 'POST' ],
				'requirements' => [ 'id' => '\d+' ],
				//'defaults' => [ 'id' => 1 ],
			]
		],
		'api-panel-role-remove' => [
			'route' => [
				'path' => '/panel/api/role/remove/{id}',
				'controller' => [ '_controller' => [ \Panel\API\Role :: class, 'remove' ] ],
				'methods' => [ 'GET', 'POST' ],
				'requirements' => [ 'id' => '\d+' ],
				//'defaults' => [ 'id' => 1 ],
			]
		],
		/*
			- Permission
		*/
		'api-panel-permission-add' => [
			'route' => [
				'path' => '/panel/api/permission/add',
				'controller' => [ '_controller' => [ \Panel\API\Permission :: class, 'add' ] ],
				'methods' => [ 'GET', 'POST' ],
			]
		],
		'api-panel-permission-update' => [
			'route' => [
				'path' => '/panel/api/permission/update/{id}',
				'controller' => [ '_controller' => [ \Panel\API\Permission :: class, 'update' ] ],
				'methods' => [ 'GET', 'POST' ],
				'requirements' => [ 'id' => '\d+' ],
				//'defaults' => [ 'id' => 1 ],
			]
		],
		'api-panel-permission-remove' => [
			'route' => [
				'path' => '/panel/api/permission/remove/{id}',
				'controller' => [ '_controller' => [ \Panel\API\Permission :: class, 'remove' ] ],
				'methods' => [ 'GET', 'POST' ],
				'requirements' => [ 'id' => '\d+' ],
				//'defaults' => [ 'id' => 1 ],
			]
		],
		/*
			- Admins
		*/
		
	];
	
	private static array $template = [
		'edit' => true,
		'active' => true,
		'route' => [
			'path' => '/error/404',
			'controller' => [ '_controller' => [ \Main :: class, 'err404' ] ],
			'requirements' => [],
			'options' => [],
			'host' => '',
			'schemes' => [],
			'methods' => [ 'GET' ],
			'condition' => '',
		]
	];
	
	protected static function map(): iterable
	{
		foreach ( self :: $data AS $name => $route )
		{
			yield $name => array_replace_recursive ( self :: $template, $route );
		}
	}
	
	public static function create(): array
	{
		return iterator_to_array ( self :: map() );
	}
}