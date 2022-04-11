<?php

/* в блоке аякс устанавливает контент
<div class="modal-body px-5 pb-5">

удалить
id="addRoleModal"

{<{include=admin-panel/blocks/roles/edit-role}>}
{{action-event}}
 */





// Builder
/*Map :: create( 'div' ) 
	-> data( ...[ 'class' => 'modal fade', 'id' => 'nouvu-modal', 'tabindex' => '-1', 'aria-hidden' => 'true' ] )
	-> content( [
		Map :: create( 'div' ) 
			-> data( class: 'modal-dialog modal-lg modal-dialog-centered modal-add-new-role' )
			-> content( [
				Map :: create( 'div' ) -> data( class: 'modal-content nouvu-modal-edit' )
			] )
	] );*/
?>
<div class="modal fade" id="nouvu-modal" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-lg modal-dialog-centered modal-add-new-role">
		<div class="modal-content nouvu-modal-edit">
			
		</div>
	</div>
</div>