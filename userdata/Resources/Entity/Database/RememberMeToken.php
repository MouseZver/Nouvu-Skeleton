<?php

declare ( strict_types = 1 );

namespace Nouvu\Resources\Entity\Database;

//use Symfony\Component\Security\Core\User\UserInterface;

use function Nouvu\Resources\System\Helpers\{ database };

class RememberMeToken
{
	public static function removeSeries( string $series ): void
	{
		database() -> delete( \RememberMeToken\By\Series :: class )( $series );
	}
	
	public static function remove( int ...$ids ): void
	{
		database() -> delete( \RememberMeToken\By\UserId :: class )( array_map ( fn ( int $id ): array => [ $id ], $ids ) );
	}
	
	public static function create(): void
	{
		database() -> create( \RememberMeToken :: class )();
	}
	
	public static function drop(): void
	{
		database() -> drop( \RememberMeToken :: class )();
	}
}

