<?php

declare ( strict_types = 1 );

namespace Nouvu\Resources\Controllers;

use Nouvu\Framework\Foundation\ApplicationTrait;
use Nouvu\Framework\View\Repository\CommitRepository;
use Nouvu\Resources\System\RestApi;

use function Nouvu\Resources\System\Helpers\{ isAjax, request };

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

	protected function statisticsCollector(): void
	{
		error_log ( 'IP address: ' . request() -> getClientIp() );

		error_log ( \json_encode ( [ 
			'POST' => request() -> request -> all(),
			'GET' => request() -> query -> all(), 
			'User-Agent' => request() -> headers -> get( 'User-Agent' ) 
		], 480 ) );
	}
}

