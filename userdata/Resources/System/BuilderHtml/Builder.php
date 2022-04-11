<?php

declare ( strict_types = 1 );

namespace Nouvu\Resources\System\BuilderHtml;

class Builder implements \Stringable
{
	const VOID_TAGS = [ 'area','base','br','col','embed','hr','img','input','link','meta','param','source','track','wbr'];
	
	public array $noEnd = [
		'meta', 'link', 'img', 'input', 
	];
	
	public array $slashEnd = [
	
	];
	
	public array $solo = [
		'br', 'hr',
	];
	
	public function __construct ( CreateMap | array $data = [] )
	{
		$this -> create( $data );
	}
	
	public function create( CreateMap | array $data ): void
	{
		$this -> data = ( $data Instanceof CreateMap ? $data -> get() : $data );
	}
	
	//[ 'tag' => 'meta', 'data' => [ 'charset' => fn() => $app -> getCharset() ] ]
	protected function compile( CreateMap | array | string $data ): string
	{
		if ( is_string ( $data ) )
		{
			return $data;
		}
		
		if ( isset ( $data[0] ) )
		{
			$array = array_map ( function ( array | string | CreateMap $row ): string
			{
				if ( $row instanceof CreateMap )
				{
					$row = $row -> get();
				}
				
				return $this -> compile( $row ) . PHP_EOL;
			}, 
			$data );
			
			return implode ( ' ', $array );
		}
		
		$data = ( object ) $data;
		
		$content = '';
		
		if ( ! empty ( $data -> content ) )
		{
			if ( $data -> content Instanceof \Closure )
			{
				$data -> content = ( $data -> content )();
			}
			
			$content = $this -> compile( $data -> content );
			
			unset ( $data -> content );
		}
		
		$template = match ( true )
		{
			in_array ( $data -> tag, self :: VOID_TAGS ) => "<{$data -> tag} %s>",
			default => "<{$data -> tag} %s>%s</{$data -> tag}>",
		};
		
		$atributes = implode ( ' ', iterator_to_array ( $this -> atributes( $data -> data ) ) );
		
		return sprintf ( $template, $atributes, $content );
	}
	
	protected function atributes( array $args ): iterable
	{
		foreach ( $args AS $name => $value )
		{
			yield sprintf ( '%s = "%s"', $name, ( $value Instanceof \Closure ? $value() : $value ) );
		}
	}
	
	public function __toString(): string
	{
		return $this -> compile( $this -> data );
	}
}
