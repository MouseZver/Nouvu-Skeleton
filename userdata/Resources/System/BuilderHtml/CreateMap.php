<?php

declare ( strict_types = 1 );

namespace Nouvu\Resources\System\BuilderHtml;

use Nouvu\Framework\Component\Config\Repository;

class CreateMap
{
	protected function __construct ( private Repository $repository )
	{}
	
	public static function create( string $name ): static
	{
		return new static ( new Repository( [ 'tag' => $name, 'data' => [], 'content' => [] ] ) );
	}
	
	public function data( mixed ...$data ): self
	{
		$this -> repository -> set( 'data', $data );
		
		return $this;
	}
	
	public function content( string | array $content ): self
	{
		$this -> repository -> set( 'content', $content );
		
		return $this;
	}
	
	public function get(): array
	{
		return $this -> repository -> all();
	}
}
