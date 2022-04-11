<?php

use Nouvu\Framework\Component\Database\StatementInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

use function Nouvu\Resources\System\Helpers\{ config, database };

return [
	/*
		- 
	*/
	'database' => [
		'select' => [
			/*
				- Поиск Дубликата юзера
				'users@username|email'
			*/
			\Users\By\Username\Or\Email :: class => static function ( string $username, string $email ): StatementInterface
			{
				$prefix_ = config( 'database.prefix' );
				
				return database() -> prepare( "SELECT * FROM {$prefix_}users WHERE `username` IN( :username, :email ) OR `email` = :email", 
					compact ( 'username', 'email' )
				);
			},
			
			/*
				- Выбрать токен по серийному номеру
				'rememberme_token@by_series'
			*/
			\RememberMeToken\By\Series :: class => static function ( string $series ): StatementInterface
			{
				$prefix_ = config( 'database.prefix' );
				
				return database() -> prepare( "SELECT `id`, `token` FROM {$prefix_}rememberme_token WHERE `series` = ?", 
				[
					$series
				] );
			},
			
			/*
				- 'forgot_pass@by_confirm'
			*/
			\ForgotPassword\By\Confirm :: class => static function ( string $confirm ): StatementInterface
			{
				$prefix_ = config( 'database.prefix' );
				
				return database() -> prepare( "SELECT * FROM {$prefix_}forgot_pass WHERE `confirm` = ?", 
				[
					$confirm
				] );
			},
			
			/*
				- 'users_pre@by_confirm'
			*/
			\UsersPre\By\Confirm :: class => static function ( string $confirm ): StatementInterface
			{
				$prefix_ = config( 'database.prefix' );
				
				return database() -> prepare( "SELECT * FROM {$prefix_}users_pre WHERE `confirm` = ?", 
				[
					$confirm
				] );
			},
			
			/*
				- 'roles@group-roles_hierarchy'
			*/
			\Roles\Group\Role\RoleHierarchy :: class => static function (): StatementInterface
			{
				$prefix_ = config( 'database.prefix' );
				
				return database() -> query( "SELECT role, role_hierarchy FROM {$prefix_}roles" );
			},
			
			/*
				- 'users_profile@value_count_by_name_group-by_value'
			*/
			\UsersProfile\Value\Count\By\Name\Group\Value :: class => static function ( string $name ): StatementInterface
			{
				$prefix_ = config( 'database.prefix' );
				
				return database() -> prepare( "SELECT `value`, COUNT( `id` ) as `count` FROM {$prefix_}users_profile WHERE `name` = ? GROUP BY `value`", 
				[
					$name
				] );
			},
			
			/*
				- 'users_profile@user-id_by_name_value'
			*/
			\UsersProfile\UserId\By\Name\Value :: class => static function ( string $name, string $value ): StatementInterface
			{
				$prefix_ = config( 'database.prefix' );
				
				return database() -> prepare( "SELECT `user_id` FROM {$prefix_}users_profile WHERE `name` = ? AND `value` = ?", 
				[
					$name, $value
				] );
			},
			
			/*
				- 
			*/
			\UsersRole\UserId\By\RoleId :: class => static function ( array $roles_id ): StatementInterface
			{
				$prefix_ = config( 'database.prefix' );
				
				return database() -> prepare( "SELECT `user_id` FROM {$prefix_}users_role WHERE `role_id` = ?", $roles_id );
			},
			
			\UsersRole\RoleId\CountId\Group\RoleId :: class => static function (): StatementInterface
			{
				$prefix_ = config( 'database.prefix' );
				
				return database() -> query( "SELECT `role_id`, COUNT( `id` ) as `count` FROM {$prefix_}users_role GROUP BY `role_id`" );
			},
			
			/*
				- 'users_profile@by_name_value'
			*/
			\UsersProfile\By\Name\Value :: class => static function ( string $name, string $value ): StatementInterface
			{
				$prefix_ = config( 'database.prefix' );
				
				return database() -> prepare( 
					"SELECT * FROM {$prefix_}users_profile WHERE `name` = ? AND value = ?", 
					[
						$name, $value
					]
				);
			},
			
			/*
				- Роли для разрешения
				'permissions@roles_by_permission'
			*/
			\Permissions\Role\By\Permission :: class => static function ( string $permission ) use ( $app ): StatementInterface
			{
				$prefix_ = config( 'database.prefix' );
				
				return $app -> database -> prepare( "SELECT `role` FROM {$prefix_}permissions WHERE `permission` = ?", [ $permission ] );
			},
			
			/*
				- Роли
			*/
			\Roles :: class => static function (): StatementInterface
			{
				$prefix_ = config( 'database.prefix' );
				
				return database() -> query( "SELECT * FROM {$prefix_}roles" );
			},
			
			/*
				- 'users@by_ids'
			*/
			\Users\By\Id :: class => static function ( array $ids ): StatementInterface
			{
				$prefix_ = config( 'database.prefix' );
				
				return database() -> prepare( "SELECT * FROM {$prefix_}users WHERE id = ?", $ids );
			},
			
			/*
				- Список разрешений
			*/
			\Permissions :: class => static function (): StatementInterface
			{
				$prefix_ = config( 'database.prefix' );
				
				return database() -> query( "SELECT * FROM {$prefix_}permissions" );
			},
		],
		'insert' => [
			/*
				- Подтверждение регистрации нового пользователя
				'users_pre'
			*/
			\UsersPre :: class => static function ( string $email, string $confirm ): void
			{
				$prefix_ = config( 'database.prefix' );
				
				database() -> prepare( "INSERT INTO {$prefix_}users_pre ( `confirm`, `email` ) VALUES ( ?,? )",
				[ 
					$confirm, $email
				] );
			},
			
			/*
				- Регистрация нового пользователя
			*/
			\Users :: class => static function ( string $username, string $email, string $password, string $roles ): int
			{
				$prefix_ = config( 'database.prefix' );
				
				$result = database() -> prepare( "INSERT INTO {$prefix_}users ( `username`, `email`, `password`, `roles` ) VALUES ( ?,?,?,? )",
				[ 
					$username, $email, $password, $roles
				] );
				
				return $result -> id();
			},
			
			/*
				- Добавить запись "Запомнить меня"
			*/
			\RememberMeToken :: class => static function ( TokenInterface $token, string $name ) use ( $app ): void
			{
				$prefix_ = $app -> repository -> get( 'database.prefix' );
				
				$app -> database -> prepare( 
					"INSERT INTO {$prefix_}rememberme_token 
						( `series`, `token`, `user_id` )
					VALUES
						( ?,?,? )",
					[
						$name,
						serialize ( $token ),
						$token -> getUser() -> getId()
					]
				);
			},
			
			/*
				- Добавить запись "Запомнить меня"
				'forgot_pass'
			*/
			\ForgotPassword :: class => static function ( int $user_id, string $email, string $confirm ): void
			{
				$prefix_ = config( 'database.prefix' );
				
				database() -> prepare( 
					"INSERT INTO {$prefix_}forgot_pass ( `user_id`, `email`, `confirm` ) VALUES ( ?,?,? )",
					[ ...func_get_args () ]
				);
			},
			
			/*
				- Добавить данные профиля
				'users_profile'
			*/
			\UsersProfile :: class => static function ( array $addRows ): void
			{
				$prefix_ = config( 'database.prefix' );
				
				database() -> prepare( "INSERT INTO {$prefix_}users_profile ( `user_id`, `name`, `value` ) VALUES ( ?,?,? )", $addRows );
			},
			
			/*
				- 
			*/
			\UsersRole :: class => static function ( array $addRows ): void
			{
				$prefix_ = config( 'database.prefix' );
				
				database() -> prepare( "INSERT INTO {$prefix_}users_role ( `user_id`, `role_id` ) VALUES ( ?,? )", $addRows );
			},
			
			/*
				- Добавить новую роль
				'role'
			*/
			\Roles :: class => static function ( string $name, string $role, string $role_hierarchy ): void
			{
				$prefix_ = config( 'database.prefix' );
				
				database() -> prepare( 
					"INSERT INTO {$prefix_}roles ( `name`, `role`, `role_hierarchy` ) VALUES ( ?,?,? )", 
					[ ...func_get_args () ]
				);
			},
			
			/*
				- Добавить роли
			*/
			\Roles\Rows :: class => static function ( array $rows ): void
			{
				$prefix_ = config( 'database.prefix' );
				
				database() -> prepare( "INSERT INTO {$prefix_}roles ( `name`, `message`, `role`, `role_hierarchy` ) VALUES ( ?,?,?,? )", $rows );
			},
			
			/*
				- 
			*/
			\UsersRole\Rows :: class => static function ( array $rows ): void
			{
				$prefix_ = config( 'database.prefix' );
				
				database() -> prepare( "INSERT INTO {$prefix_}users_role ( `user_id`, `role_id` ) VALUES ( ?,? )", $rows );
			},
			
			/*
				- 'permission'
			*/
			\Permissions :: class => static function ( string $name, string $permission, string $role ): void
			{
				$prefix_ = config( 'database.prefix' );
				
				database() -> prepare(  "INSERT INTO {$prefix_}permissions ( `name`, `permission`, `role` ) VALUES ( ?,?,? )", [
					$name, $permission, $role,
				] );
			},
			
			/*
				- 
			*/
			\Permissions\Rows :: class => static function ( array $rows ): void
			{
				$prefix_ = config( 'database.prefix' );
				
				database() -> prepare( "INSERT INTO {$prefix_}permissions ( `name`, `permission`, `role` ) VALUES ( ?,?,? )", $rows );
			},
		],
		'update' => [
			/*
				- 
			*/
			\RememberMeToken\Series\By\Series :: class => static function ( string $after, string $before ): void
			{
				$prefix_ = config( 'database.prefix' );
				
				database() -> prepare( "UPDATE {$prefix_}rememberme_token SET `series` = ? WHERE `series` = ?", [ $after, $before ] );
			},
			
			\Users :: class => static function ( iterable $users ): void
			{
				$prefix_ = config( 'database.prefix' );
				
				$stmt = database() -> prepare( "UPDATE {$prefix_}users SET `username` = ?, `email` = ?, `password` = ?, `roles` = ? WHERE `id` = ?" );
				
				foreach ( $users AS $user )
				{
					$stmt -> execute( [
						$user -> getUsername(),
						$user -> getEmail(),
						$user -> getPassword(),
						json_encode ( $user -> getRoles() ),
						$user -> getId()
					] );
				}
			},
			
			/*
				- Обновить пароль у пользователя
				'users@password_by_id'
			*/
			\Users\Password\By\Id :: class => static function ( int $id, string $password ): void
			{
				$prefix_ = config( 'database.prefix' );
				
				database() -> prepare( "UPDATE {$prefix_}users SET `password` = :password WHERE `id` = :id", 
					compact ( 'id', 'password' ) 
				);
			},
			
			/*
				- 'users@update-roles_by_id'
			*/
			\Users\Roles\By\Id :: class => static function ( array $roles ): void
			{
				$prefix_ = config( 'database.prefix' );
				
				database() -> prepare( "UPDATE {$prefix_}users SET `roles` = :roles WHERE `id` = :id", $roles );
			},
			
			/*
				- Активировать аккаунт пользователю
				'users@email_confirmed_by_id'
			*/
			\Users\Enabled :: class => static function ( int $id ): void
			{
				$prefix_ = config( 'database.prefix' );
				
				database() -> query( [ "UPDATE {$prefix_}users SET `enabled` = 1 WHERE `id` = %d", $id ] );
			},
			
			/*
				- Обновить роль
				'role'
			*/
			\Roles :: class => static function ( array $roles ) use ( $app ): void
			{
				$prefix_ = config( 'database.prefix' );
				
				$stmt = database() -> prepare( "UPDATE {$prefix_}roles SET `name` = ?, `message` = ?, `role` = ?, `role_hierarchy` = ? WHERE `id` = ?" );
				
				foreach ( $roles AS $role )
				{
					$stmt -> execute( [
						$role -> getName(),
						$role -> getMessage(),
						$role -> getRole(),
						json_encode ( $role -> getRoleHierarchy() ),
						$role -> getId()
					] );
				}
			},
			
			/*
				- 
			*/
			\Permissions :: class => static function ( array $permissions ): void
			{
				$prefix_ = config( 'database.prefix' );
				
				$stmt = database() -> prepare( "UPDATE {$prefix_}permissions SET `name` = ?, `permission` = ?, `role` = ? WHERE `id` = ?" );
				
				foreach ( $permissions AS $permission )
				{
					$stmt -> execute( [
						$permission -> getName(),
						$permission -> getPermission(),
						$permission -> getRole(),
						$permission -> getId()
					] );
				}
			},
			
			/*
				- Обновить Permission
				'permission'
			*/
			\Permissions\By\Id :: class => static function ( int $id, string $name, string $permission, string $role ): void
			{
				$prefix_ = config( 'database.prefix' );
				
				database() -> prepare( 
					"UPDATE {$prefix_}permissions SET `name` = :name, `permission` = :permission, `role` = :role WHERE `id` = :id", 
					compact ( 'id', 'name', 'permission', 'role' )
				);
			},
			
			/*
				- 'permissions@roles_by_id'
			*/
			\Permissions\Role\By\Id :: class => static function ( array $roles ): void
			{
				$prefix_ = config( 'database.prefix' );
				
				database() -> prepare( "UPDATE {$prefix_}permissions SET `role` = :role WHERE `id` = :id", $roles );
			},
			
			/*
				- 
			*/
			\Permissions\Role\By\Role :: class => static function ( array $roles ): void
			{
				$prefix_ = config( 'database.prefix' );
				
				database() -> prepare( "UPDATE {$prefix_}permissions SET `role` = ? WHERE `role` = ?", $roles );
			},
			
			/*
				- 'users_profile@update-value_by_array-ids'
			*/
			\UsersProfile\Value\By\Id :: class => static function ( array $ids, string $value ): void
			{
				$prefix_ = config( 'database.prefix' );
				
				$stmt = database() -> prepare( "UPDATE {$prefix_}users_profile SET `value` = ? WHERE `id` = ?" );
				
				foreach ( $ids AS $id )
				{
					$stmt -> execute( [ $value, $id ] );
				}
			},
			
			/*
				- 'roles@update-hierarchy_by_id'
			*/
			\Roles\Hierarchy\By\Id :: class => static function ( array $hierarchy ): void
			{
				$prefix_ = config( 'database.prefix' );
				
				database() -> prepare( "UPDATE {$prefix_}roles SET `role_hierarchy` = :hierarchy WHERE `id` = :id", $hierarchy );
			},
		],
		'delete' => [
			/*
				- Удаление просроченной записи "Запомнить меня"
				'rememberme_token@clearing-expired-tokens'
			*/
			\RememberMeToken\Expired :: class => static function (): void
			{
				$prefix_ = config( 'database.prefix' );
				
				database() -> query( "DELETE FROM {$prefix_}rememberme_token WHERE `lastUsed` < NOW() - INTERVAL 15 DAY" );
			},
			
			/*
				- Удаление записи "Запомнить меня" по серии
				'rememberme_token@by_series'
			*/
			\RememberMeToken\By\Series :: class => static function ( string $series ) use ( $app ): void
			{
				$prefix_ = config( 'database.prefix' );
				
				$app -> database -> prepare( 
					"DELETE FROM {$prefix_}rememberme_token WHERE `series` = ?",
					[
						$series
					]
				);
			},
			
			/*
				- Удаление записи "Запомнить меня" по users_id
				'rememberme_token@by-array_users_id'
			*/
			\RememberMeToken\By\UserId :: class => static function ( array $users_id ): void
			{
				$prefix_ = config( 'database.prefix' );
				
				database() -> prepare( "DELETE FROM {$prefix_}rememberme_token WHERE `user_id` = ?", $users_id );
			},
			
			/*
				- Удаление всех записей по восстановлению пароля у пользователя
			*/
			\ForgotPassword\By\UserId :: class => static function ( int $user_id ): void
			{
				$prefix_ = config( 'database.prefix' );
				
				database() -> query( [ "DELETE FROM {$prefix_}forgot_pass WHERE `user_id` = %d", $user_id ] );
			},
			
			/*
				- Удаление одной выбранной записи по восстановлению пароля
				'forgot_pass@by_id'
			*/
			\ForgotPassword :: class => static function ( int $id ): void
			{
				$prefix_ = config( 'database.prefix' );
				
				database() -> query( [ "DELETE FROM {$prefix_}forgot_pass WHERE `id` = %d", $id ] );
			},
			
			/*
				- Удаление одной выбранной записи по восстановлению пароля
				'users_pre@by_id'
			*/
			\UsersPre :: class => static function ( int $id ): void
			{
				$prefix_ = config( 'database.prefix' );
				
				database() -> query( [ "DELETE FROM {$prefix_}users_pre WHERE `id` = %d", $id ] );
			},
			
			/*
				- 'roles@by_id'
			*/
			\Roles :: class => static function ( array $ids ): void
			{
				$prefix_ = config( 'database.prefix' );
				
				database() -> prepare( "DELETE FROM {$prefix_}roles WHERE `id` = ?", $ids );
			},
			
			/*
				- 'permissions@by_id'
			*/
			\Permissions :: class => static function ( array $ids ): void
			{
				$prefix_ = config( 'database.prefix' );
				
				database() -> prepare( "DELETE FROM {$prefix_}permissions WHERE `id` = ?", $ids );
			},
			
			/*
				- 
			*/
			\UsersRole\By\RoleId :: class => static function ( array $roles_id ): void
			{
				$prefix_ = config( 'database.prefix' );
				
				database() -> prepare( "DELETE FROM {$prefix_}users_role WHERE `role_id` = ?", $roles_id );
			},
			
			/*
				- 'users_profile@by_name_value'
			*/
			\UsersProfile\By\Name\Value :: class => static function ( string $name, string $value ): void
			{
				$prefix_ = config( 'database.prefix' );
				
				database() -> prepare( "DELETE FROM {$prefix_}users_profile WHERE `name` = ? AND `value` = ?", [ $name, $value ] );
			},
		],
		'file' => [],
		'create' => [
			/*
				- 
			*/
			\Users :: class => static function (): void
			{
				$prefix_ = config( 'database.prefix' );
				
				database() -> query(
					"CREATE TABLE {$prefix_}users (
						`id` int(11) NOT NULL AUTO_INCREMENT,
						`username` tinytext NOT NULL,
						`email` text NOT NULL,
						`password` text NOT NULL,
						`roles` json NOT NULL,
						`enabled` tinyint(1) NOT NULL DEFAULT 0,
						`created_at` datetime NULL DEFAULT CURRENT_TIMESTAMP,
						PRIMARY KEY (`id`)
					) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4"
				);
			},
			
			/*
				- 
			*/
			\UsersPre :: class => static function (): void
			{
				$prefix_ = config( 'database.prefix' );
				
				database() -> query(
					"CREATE TABLE {$prefix_}users_pre (
						`id` int(11) NOT NULL AUTO_INCREMENT,
						`confirm` varchar(32) NOT NULL,
						`email` text NOT NULL,
						`created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
						PRIMARY KEY (`id`)
					) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4"
				);
			},
			
			/*
				- 
			*/
			\UsersProfile :: class => static function (): void
			{
				$prefix_ = config( 'database.prefix' );
				
				database() -> query(
					"CREATE TABLE {$prefix_}users_profile (
						`id` int(11) NOT NULL AUTO_INCREMENT,
						`user_id` int(11) NOT NULL,
						`name` text NOT NULL,
						`value` text NOT NULL,
						`created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
						PRIMARY KEY (`id`)
					) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4"
				);
			},
			
			/*
				- 
			*/
			\UsersRole :: class => static function (): void
			{
				$prefix_ = config( 'database.prefix' );
				
				database() -> query(
					"CREATE TABLE {$prefix_}users_role (
						`id` int(11) NOT NULL AUTO_INCREMENT,
						`user_id` int(11) NOT NULL,
						`role_id` int(11) NOT NULL,
						PRIMARY KEY (`id`)
					) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4"
				);
			},
			
			/*
				- 
			*/
			\Roles :: class => static function (): void
			{
				$prefix_ = config( 'database.prefix' );
				
				database() -> query(
					"CREATE TABLE {$prefix_}roles (
						`id` int(11) NOT NULL AUTO_INCREMENT,
						`name` text NOT NULL,
						`message` text,
						`role` text NOT NULL,
						`role_hierarchy` text NOT NULL,
						`created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
						PRIMARY KEY (`id`)
					) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4"
				);
			},
			
			/*
				- 
			*/
			\RememberMeToken :: class => static function (): void
			{
				$prefix_ = config( 'database.prefix' );
				
				database() -> query(
					"CREATE TABLE {$prefix_}rememberme_token (
						`id` int(11) NOT NULL AUTO_INCREMENT,
						`user_id` int(11) NOT NULL,
						`series` text NOT NULL,
						`token` text NOT NULL,
						`lastUsed` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
						`created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
						PRIMARY KEY (`id`)
					) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4"
				);
			},
			
			/*
				- 
			*/
			\Permissions :: class => static function (): void
			{
				$prefix_ = config( 'database.prefix' );
				
				database() -> query(
					"CREATE TABLE {$prefix_}permissions (
						`id` int(11) NOT NULL AUTO_INCREMENT,
						`name` text NOT NULL,
						`permission` text NOT NULL,
						`role` text NOT NULL,
						`created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
						PRIMARY KEY (`id`)
					) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4"
				);
			},
			
			/*
				- 
			*/
			\ForgotPassword :: class => static function (): void
			{
				$prefix_ = config( 'database.prefix' );
				
				database() -> query(
					"CREATE TABLE {$prefix_}forgot_pass (
						`id` int(11) NOT NULL AUTO_INCREMENT,
						`confirm` varchar(32) NOT NULL,
						`user_id` int(11) NOT NULL,
						`email` text NOT NULL,
						`created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
						PRIMARY KEY (`id`)
					) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4"
				);
			},
		],
		'alter' => [],
		'index' => [],
		'drop' => [
			\Users :: class => static function (): void
			{
				$prefix_ = config( 'database.prefix' );
				
				database() -> query( "DROP TABLE IF EXISTS {$prefix_}users" );
			},
			
			\UsersPre :: class => static function (): void
			{
				$prefix_ = config( 'database.prefix' );
				
				database() -> query( "DROP TABLE IF EXISTS {$prefix_}users_pre" );
			},
			
			\UsersProfile :: class => static function (): void
			{
				$prefix_ = config( 'database.prefix' );
				
				database() -> query( "DROP TABLE IF EXISTS {$prefix_}users_profile" );
			},
			
			\UsersRole :: class => static function (): void
			{
				$prefix_ = config( 'database.prefix' );
				
				database() -> query( "DROP TABLE IF EXISTS {$prefix_}users_role" );
			},
			
			\Roles :: class => static function (): void
			{
				$prefix_ = config( 'database.prefix' );
				
				database() -> query( "DROP TABLE IF EXISTS {$prefix_}roles" );
			},
			
			\Permissions :: class => static function (): void
			{
				$prefix_ = config( 'database.prefix' );
				
				database() -> query( "DROP TABLE IF EXISTS {$prefix_}permissions" );
			},
			
			\RememberMeToken :: class => static function (): void
			{
				$prefix_ = config( 'database.prefix' );
				
				database() -> query( "DROP TABLE IF EXISTS {$prefix_}rememberme_token" );
			},
			
			\ForgotPassword :: class => static function (): void
			{
				$prefix_ = config( 'database.prefix' );
				
				database() -> query( "DROP TABLE IF EXISTS {$prefix_}forgot_pass" );
			},
			
		],
		'CreateTemporaryTables' => [],
		'LockTables' => [],
	],
];