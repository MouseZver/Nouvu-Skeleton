<?php

declare ( strict_types = 1 );

namespace Nouvu\Resources\Models\Traits\Form\Select;

use Nouvu\Resources\System\BuilderHtml\{ Builder, CreateMap };

use function Nouvu\Resources\System\Helpers\{ roles };

trait Roles
{
	public function getSelectOptionsAll(): string
	{
		$options = [];
		
		foreach ( roles() -> getList() AS $role_id => $role )
		{
			$options[] = CreateMap :: create( 'option' ) -> data( value: $role_id ) -> content( $role -> getName() );
		}
		
		return ( string ) new Builder( [ 
			CreateMap :: create( 'optgroup' ) -> data( label: 'Список ролей' ) -> content( $options ) 
		] );
	}
}
