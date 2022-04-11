<?php

use Nouvu\Framework\Foundation\Application AS App;

use function Nouvu\Resources\System\Helpers\{ directoryPath };

return [
	'file' => 'Configs/system/routing.json',
	
	'closure' => static function ( App $app ): array
	{
		$file = directoryPath( 'userdata' ) . $app -> repository -> get( 'router.file' );
		
		if ( /* ! file_exists ( $file ) */ true )
		{
			$array = \Nouvu\Resources\System\RecreateRouting :: create();
			
			//file_put_contents ( $file, json_encode ( $array, 480 ) );
			
			return $array;
		}
		
		return json_decode ( file_get_contents ( $file ), true );
	},
];
