<?php

use Nouvu\Framework\Component\Database\StatementInterface AS Nouvu;
use Nouvu\Database\Lerma;

return [
	'code' => static function ( int $code ): int
	{
		return [
			Nouvu :: FETCH_NUM => Lerma :: FETCH_NUM,
			Nouvu :: FETCH_OBJ => Lerma :: FETCH_OBJ,
			Nouvu :: FETCH_FUNC => Lerma :: FETCH_FUNC,
			Nouvu :: FETCH_ASSOC => Lerma :: FETCH_ASSOC,
			Nouvu :: FETCH_NAMED => Lerma :: FETCH_NAMED,
			Nouvu :: FETCH_GROUP => Lerma :: FETCH_GROUP,
			Nouvu :: FETCH_COLUMN => Lerma :: FETCH_COLUMN,
			Nouvu :: FETCH_UNIQUE => Lerma :: FETCH_UNIQUE,
			Nouvu :: FETCH_KEY_PAIR => Lerma :: FETCH_KEY_PAIR,
			Nouvu :: MYSQL_FETCH_BIND => Lerma :: MYSQL_FETCH_BIND,
			Nouvu :: MYSQL_FETCH_FIELD => Lerma :: MYSQL_FETCH_FIELD,
			
			Nouvu :: FETCH_GROUP | Nouvu :: FETCH_COLUMN => Lerma :: FETCH_GROUP | Lerma :: FETCH_COLUMN,
			Nouvu :: FETCH_KEY_PAIR | Nouvu :: FETCH_FUNC => Lerma :: FETCH_KEY_PAIR | Lerma :: FETCH_FUNC,
			Nouvu :: MYSQL_FETCH_BIND | Nouvu :: FETCH_COLUMN => Lerma :: MYSQL_FETCH_BIND | Lerma :: FETCH_COLUMN,
		]
		[$code] ?? Lerma :: FETCH_OBJ;
	},
	'class' => \Nouvu\Resources\System\Database\MySQLi\LermaFacade :: class,
	
	'prefix' => 'uvu_',
];
