<div class="modal-header bg-transparent">
	<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body px-5 pb-5">
	<div class="text-center mb-4">
		<h1 class="role-title">Add New Permission</h1>
		<p>Set permission structure</p>
	</div>
	<!-- Add Permission form -->
	<form class="nouvu-event-form row" data-nouvu-action="form-modal" action="{<{@routerPathByName=api-panel-permission-add}>}" method="post">
		<div class="col-12">
			<h4 class="mt-2 pt-50">Я хз что тут писать</h4>
			<!-- Permission table -->
			<div>
				<table class="table table-flush-spacing">
					<tbody>
						<tr>
							<td class="text-nowrap fw-bolder">
								Наименование разрешения
							</td>
							<td>
								<input class="form-control" type="text" name="name" placeholder="Разрешение">
							</td>
						</tr>
						<tr>
							<td class="text-nowrap fw-bolder">
								Наименование тега
							</td>
							<td>
								<input class="form-control" type="text" name="permission" placeholder="example.permission.view">
							</td>
						</tr>
						<tr>
							<td colspan="2">
								<label class="form-label" for="select-list-permission-multiple">Выдать разрешение для роли:</label>
								<select class="select2 form-select" id="select-list-permission-multiple" name="role">
									{{options}}
								</select>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<!-- Permission table -->
		</div>
		<div class="col-12 text-center mt-2">
			<button type="submit" class="btn btn-primary me-1 waves-effect waves-float waves-light">Submit</button>
			<button type="reset" class="btn btn-outline-secondary waves-effect" data-bs-dismiss="modal" aria-label="Close">
				Discard
			</button>
		</div>
	</form>
	<!--/ Add Permission form -->
</div>