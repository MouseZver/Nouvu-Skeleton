<?php

declare ( strict_types = 1 );

namespace Nouvu\Resources\Controllers;

use Nouvu\Framework\Http\Controllers\AbstractController;
use Nouvu\Framework\View\Repository\CommitRepository;
use Nouvu\Resources\System\RestApi;

use function Nouvu\Resources\System\Helpers\{ isAjax, routerPathByName };

final class MainController extends AbstractController
{
	public function index(): CommitRepository
	{
		$this -> setThreadTitles( 'Главная', 'Не главная' );
		
		return $this -> render( 'index' );
	}
	
	public function err404( string | int $_route ): CommitRepository
	{
		$this -> setThreadTitles( 'Страница не найдена' );
		
		if ( isAjax() )
		{
			return $this -> customJson( RestApi :: notFound() -> redirect( routerPathByName( $_route ) ) );
		}
		
		return $this -> render( 'error.404', 'error-template' );
	}
	
	public function err500( string | int $_route ): CommitRepository
	{
		$this -> setThreadTitles( 'Ошибка сервера' );
		
		if ( isAjax() )
		{
			return $this -> customJson( RestApi :: serverError() -> redirect( routerPathByName( $_route ) ) );
		}
		
		return $this -> render( 'error.500', 'error-template' );
	}
}
