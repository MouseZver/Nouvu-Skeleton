<?php

declare ( strict_types = 1 );

namespace Nouvu\Resources\Entity\Database;

use Nouvu\Framework\Component\Database\StatementInterface;
use Symfony\Component\Security\Core\User\UserInterface;

use function Nouvu\Resources\System\Helpers\{ database };

class Users
{
	public static function closureDuplicate( \Closure $closure, UserInterface $user ): iterable
	{
		return database() -> select( \Users\By\Username\Or\Email :: class )( $user -> getUsername(), $user -> getEmail() ) -> all( StatementInterface :: FETCH_FUNC, $closure );
	}
	
	public static function closureById( \Closure $closure, array $data ): iterable
	{
		return database() -> select( \Users\By\Id :: class )( $data ) -> all( StatementInterface :: FETCH_FUNC, $closure );
	}
	
	public static function updateEnabled( UserInterface $user ): void
	{
		database() -> update( \Users\Enabled :: class )( $user -> getId() );
	}
	
	public static function updateRoles( array ...$roles ): void
	{
		database() -> update( \Users\Roles\By\Id :: class )( $roles );
	}
	
	public static function updatePassword( UserInterface $user ): void
	{
		database() -> update( \Users\Password\By\Id :: class )( $user -> getId(), $user -> getPassword() );
	}
	
	public static function update( UserInterface ...$users ): void
	{
		database() -> update( \Users :: class )( $users );
	}
	
	public static function add( UserInterface $user ): int
	{
		return database() -> insert( \Users :: class )( $user -> getUsername(), $user -> getEmail(), $user -> getPassword(), json_encode ( $user -> getRoles() ) );
	}
	
	public static function create(): void
	{
		database() -> create( \Users :: class )();
	}
	
	public static function drop(): void
	{
		database() -> drop( \Users :: class )();
	}
}

