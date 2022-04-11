<div class="modal-header">
	<h5 class="modal-title" id="exampleModalCenterTitle">Подтверждение удаление Роли - <b>{{name}}</b></h5>
	<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
	<div class="alert alert-warning" role="alert">
		<h6 class="alert-heading">Warning!</h6>
		<div class="alert-body">
			Вы действительно хотите удалить эту роль?<br>
			Пожалуйста, обратите внимание, что роль <b>{{name}}</b> будет навсегда удалена повсюду.<br>
			Во избежание проблем, настоятельно рекомендуется убедиться в Ваших действиях. 
		</div>
	</div>
</div>
<div class="modal-footer">
	<button type="button" class="nouvu-event btn btn-primary waves-effect waves-float waves-light" data-nouvu-action="post-modal" href="{{linkRemove}}" data-bs-dismiss="modal">Remove</button>
</div>