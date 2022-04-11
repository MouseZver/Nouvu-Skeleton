<?php

declare ( strict_types = 1 );

namespace Nouvu\Resources\System\Database\MySQLi;

use Nouvu\Framework\Foundation\Application AS App;
use Nouvu\Framework\Component\Database\DatabaseInterface;
use Nouvu\Database\{ Lerma, LermaStatement, DriverEnum };

use function Nouvu\Resources\System\Helpers\{ config };

final class LermaFacade implements DatabaseInterface
{
	private Lerma $connect;
	
	private LermaStatement $statement;
	
	public function __construct ( private App $app )
	{
		$this -> connect = Lerma :: create( driver: DriverEnum :: MySQLi )
			-> setData( 
				host: config( 'config.database:mysql.host' ), 
				username: config( 'config.database:mysql.username' ), 
				password: config( 'config.database:mysql.password' ) 
			)
			-> setDatabaseName( dbname: config( 'config.database:mysql.dbname' ) )
			-> setCharset( charset: config( 'config.database:mysql.charset' ) )
			-> setPort( port: config( 'config.database:mysql.port' ) )
			-> getLerma();
	}
	
	public function prepare( ...$vars ): void
	{
		$this -> statement = $this -> connect -> prepare( ...$vars );
	}
	
	public function query( ...$vars ): void
	{
		$this -> statement = $this -> connect -> query( ...$vars );
	}
	
	public function execute( array $data ): void
	{
		$this -> connect -> execute( $data );
	}
	
	public function count(): int
	{
		return $this -> statement -> rowCount();
	}
	
	public function get( int $code, callable | string $argument = null ): mixed
	{
		return $this -> statement -> fetch( config( 'database.code' )( $code ), $argument );
	}
	
	public function all( int $code, callable | string $argument = null ): array
	{
		return $this -> statement -> fetchAll( config( 'database.code' )( $code ), $argument );
	}
	
	public function id(): int
	{
		return $this -> connect -> InsertID();
	}
}