<?php

use Psr\Container\ContainerInterface;
use Nouvu\Resources\Entity\Database;

use function Nouvu\Resources\System\Helpers\{ app, request, response, config, database };

return [
	/*
		- example tool
	*/
	/* name => static function ( ContainerInterface $container ): returnType
	{
		return value;
	}, */
	
	/*
		- 
	*/
	\Container :: class => static function ( ContainerInterface $container ): ContainerInterface
	{
		return $container;
	},
	
	/*
		- 
	*/
	\Helpers :: class => static function ( ContainerInterface $container ): bool
	{
		foreach ( glob ( $container -> get( 'repository' ) -> get( 'app.system.directory.helpers' ) . '*.php' ) AS $helper )
		{
			require_once $helper;
		}
		
		app( $container -> get( 'app' ) );
		
		return true;
	},
	
	/*
		- 
	*/
	\Repository :: class => static function ( ContainerInterface $container )
	{
		// use in each config
		$app = $container -> get( 'app' );
		
		$repository = new \Nouvu\Framework\Component\Config\Repository;
		
		foreach ( glob ( dirname ( __FILE__ ) . '/Configs/*.php' ) AS $file )
		{
			$repository -> set( basename ( $file, '.php' ), include $file );
		}
		
		$repository -> set( 'app.system.directory', [
			'userdata' => dirname ( __FILE__ ) . DIRECTORY_SEPARATOR,
			'root' => dirname ( __DIR__ ) . DIRECTORY_SEPARATOR,
			'view' => dirname ( __FILE__ ) . DIRECTORY_SEPARATOR . 'Resources/View/',
			'helpers' => dirname ( __FILE__ ) . DIRECTORY_SEPARATOR . 'Resources/System/Helpers/',
		] );
		
		return $repository;
	},
	
	/*
		- 
	*/
	\Kernel :: class => static function ( ContainerInterface $container )
	{
		return new \Nouvu\Framework\Http\Kernel( $container -> get( 'app' ) );
	},
	
	/*
		- 
	*/
	\Request :: class => static function ( ContainerInterface $container )
	{
		return \Symfony\Component\HttpFoundation\Request :: createFromGlobals();
	},
	
	/*
		- 
	*/
	\Response :: class => static function ( ContainerInterface $container )
	{
		return new \Symfony\Component\HttpFoundation\Response;
	},
	
	/*
		- 
	*/
	\Database\Instance :: class => static function ( ContainerInterface $container )
	{
		return new \Nouvu\Framework\Component\Database\DatabaseManager( $container -> get( 'app' ) );
	},
	
	/*
		- 
	*/
	\Database :: class => static function ( ContainerInterface $container )
	{
		return $container -> get( \Database\Instance :: class );
	},
	
	/*
		- 
	*/
	\Router :: class => static function ( ContainerInterface $container )
	{
		return new \Nouvu\Framework\Routing\Router( $container -> get( 'app' ) );
	},
	
	/*
		-
	*/
	\Session :: class => static function ( ContainerInterface $container )
	{
		$session = new \Symfony\Component\HttpFoundation\Session\Session;
		
		$session -> start();
		
		request() -> setSession( $session );
		
		return $session;
	},
	
	/*
		- 
	*/
	\View :: class => static function ( ContainerInterface $container )
	{
		$viewer = new \Nouvu\Framework\View\Viewer( request(), response() );
		
		foreach ( [ 'path', 'layout', 'extension', 'title', 'head' ] AS $name )
		{
			$viewer -> { 'set' . ucfirst ( $name ) }( config() );
		}
		
		return $viewer;
	},
	
	/*
		- 
	*/
	\Validator :: class => static function ( ContainerInterface $container )
	{
		$validation = \Symfony\Component\Validator\Validation :: createValidator();
		
		return new \Nouvu\Framework\Component\Validator\Validation( request(), $validation );
	},
	
	/*
		- 
	*/
	\Mail :: class => static function ( ContainerInterface $container )
	{
		return new \Nouvu\Resources\System\MailerFacade( app() );
	},
	
	/*
		- 
	*/
	\Security :: class => static function ( ContainerInterface $container )
	{
		return new \Symfony\Component\Security\Core\Security( $container );
	},
	
	\AuthenticationHandler :: class => static function ( ContainerInterface $container )
	{
		return new \Nouvu\Framework\Component\Security\Http\AuthenticationHandler(
			$container -> get( 'security.memory.user_provider' ),
			$container -> get( 'security.signature_remember_me_hasher' ),
			$container -> get( 'security.token_storage' ),
			$container -> get( \SessionRememberMeHandler :: class ),
			$container -> get( \Database :: class ),
			$container -> get( \Request :: class ),
			config( 'security.secret_key' )
		);
	},
	
	/*
		- 
	*/
	\SessionRememberMeHandler :: class => static function ( ContainerInterface $container )
	{
		return new \Nouvu\Framework\Component\Security\Http\SessionRememberMeHandler( 
			$container -> get( 'security.database.token_provider' ),
			$container -> get( 'security.signature_remember_me_hasher' ),
			$container -> get( \Database :: class ),
			$container -> get( \Request :: class ),
			$container -> get( \Response :: class ),
			$container -> get( \Session :: class ),
			config( 'security.remember_me.name' ), 
			config( 'security.session_name' ),
		);
	},
	
	/*
		- 
	*/
	'encoder.factory' => static function ( ContainerInterface $container )
	{
		return new \Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactory( config( 'security.encoder' )() );
	},
	
	/*
		- RequestStack
	*/
	'request_stack' => static function ( ContainerInterface $container )
	{
		$requestStack = new \Symfony\Component\HttpFoundation\RequestStack();
		
		$requestStack -> push( request() );
		
		return $requestStack;
	},
	
	/*
		- 
	*/
	'security.memory.user_provider' => static function ( ContainerInterface $container )
	{
		return new \Symfony\Component\Security\Core\User\InMemoryUserProvider;
	},
	
	/*
		- 
	*/
	'security.user.roles' => static function ( ContainerInterface $container )
	{
		$requestRole = new \Nouvu\Resources\Entity\Request\Role;
		
		return new \Nouvu\Framework\Component\Security\Core\User\Roles(
			database(),
			new \Nouvu\Framework\Component\Security\Core\User\Roles\Add( database(), $requestRole ),
			new \Nouvu\Framework\Component\Security\Core\User\Roles\Update( database(), $requestRole ),
			new \Nouvu\Framework\Component\Security\Core\User\Roles\Remove( database(), $requestRole ),
			config( 'entity.role' ),
			config( 'entity.user' ),
		);
	},
	
	/*
		- 
	*/
	'security.user.permissions' => static function ( ContainerInterface $container )
	{
		$requestRole = new \Nouvu\Resources\Entity\Request\Permission;
		
		return new \Nouvu\Framework\Component\Security\Core\User\Permissions(
			database(),
			$container -> get( 'security.user.roles' ),
			new \Nouvu\Framework\Component\Security\Core\User\Permissions\Add( database(), $requestRole ),
			new \Nouvu\Framework\Component\Security\Core\User\Permissions\Update( database(), $requestRole ),
			new \Nouvu\Framework\Component\Security\Core\User\Permissions\Remove( database(), $requestRole ),
			config( 'entity.permission' ),
		);
	},
	
	/*
		- 
	*/
	'security.database.user_provider' => static function ( ContainerInterface $container )
	{
		return new \Nouvu\Framework\Component\Security\Core\Provider\DatabaseUserProvider( 
			$container -> get( \Database :: class ),
			config( 'entity.user' )
		);
	},
	
	/*
		- 
	*/
	'security.database.token_provider' => static function ( ContainerInterface $container )
	{
		return new \Nouvu\Framework\Component\Security\Core\Provider\DatabaseTokenProvider( 
			$container -> get( \Database :: class )
		);
	},
	
	/*
		- token_storage
	*/
	'security.token_storage' => static function ( ContainerInterface $container )
	{
		$storage = new \Symfony\Component\Security\Core\Authentication\Token\Storage\UsageTrackingTokenStorage(
			new \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage,
			$container
		);
		
		$container -> get( \SessionRememberMeHandler :: class ) -> push( $storage );
		
		return $storage;
	},
	
	/*
		- AuthenticationUtils
	*/
	'security.authentication_utils' => static function ( ContainerInterface $container )
	{
		return new \Symfony\Component\Security\Http\Authentication\AuthenticationUtils( $container -> get( 'request_stack' ) );
	},
	
	/*
		- 
	*/
	'security.role_hierarchy' => static function ( ContainerInterface $container )
	{
		//$container -> get( 'repository' ) -> get( 'security.hierarchy' )
		//print_r (Database\Roles :: roleHierarchy());exit;
		
		return new \Symfony\Component\Security\Core\Role\RoleHierarchy( Database\Roles :: roleHierarchy() );
	},
	
	/*
		- 
	*/
	'security.role_hierarchy_voter' => static function ( ContainerInterface $container )
	{
		return new \Symfony\Component\Security\Core\Authorization\Voter\RoleHierarchyVoter( 
			$container -> get( 'security.role_hierarchy' )
		);
	},
	
	'security.accessDecisionManager' => static function ( ContainerInterface $container )
	{
		return new \Symfony\Component\Security\Core\Authorization\AccessDecisionManager( [
			/*new \Symfony\Component\Security\Core\Authorization\Voter\AuthenticatedVoter( 
				new \Symfony\Component\Security\Core\Authentication\AuthenticationTrustResolver() 
			),*/
			$container -> get( 'security.role_hierarchy_voter' ) 
		] );
	},
	
	/*
		- Symfony > security > isGranted
	*/
	'security.authorization_checker' => static function ( ContainerInterface $container )
	{
		return new \Symfony\Component\Security\Core\Authorization\AuthorizationChecker(
			$container -> get( 'security.token_storage' ), 
			$container -> get( 'security.accessDecisionManager' ),
		);
	},
	
	/*
		- Symfony > security > Signature > SignatureHasher
	*/
	'security.signature_hasher' => static function ( ContainerInterface $container )
	{
		return new \Symfony\Component\Security\Core\Signature\SignatureHasher(
			\Symfony\Component\PropertyAccess\PropertyAccess :: createPropertyAccessor(), 
			[ 'id', 'email' ], 
			config( 'security.secret_key' )
		);
	},
	
	/*
		- Symfony > security > RememberMe > SignatureRememberMeHandler
	*/
	'security.signature_remember_me_hasher' => static function ( ContainerInterface $container )
	{
		return new \Symfony\Component\Security\Http\RememberMe\SignatureRememberMeHandler( 
			$container -> get( 'security.signature_hasher' ), 
			$container -> get( 'security.memory.user_provider' ), 
			$container -> get( 'request_stack' ), 
			config( 'security.remember_me' )
		);
	},
];
