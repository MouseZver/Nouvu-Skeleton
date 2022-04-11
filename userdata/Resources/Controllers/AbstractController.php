<?php

declare ( strict_types = 1 );

namespace Nouvu\Resources\Controllers;

use Nouvu\Framework\Foundation\ApplicationTrait;
use Nouvu\Framework\View\Repository\CommitRepository;
use Nouvu\Resources\System\RestApi;

use function Nouvu\Resources\System\Helpers\{ isAjax };

class AbstractController
{
	//use ApplicationTrait;
	
	public function accessDenied(): CommitRepository
	{
		$this -> setSingleTitles( 'Access denied' );
		
		if ( isAjax() )
		{
			return $this -> customJson( RestApi :: success() -> errorMessages( 'Access denied' ) );
		}
		
		return $this -> render( 'auth/access-denied', 'auth/auth-template' );
	}
}

