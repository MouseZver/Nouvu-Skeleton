<h3>Permissions List</h3>
<p>Each category (Basic, Professional, and Business) includes the four predefined roles shown below.</p>

<!-- Permission Table -->
<div class="card">
	<div class="card-datatable table-responsive">
		<div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
			<div class="d-flex justify-content-between align-items-center header-actions text-nowrap mx-1 row mt-75 mb-75">
				<div class="col-sm-12">
					<div class="dt-action-buttons d-flex align-items-center justify-content-lg-end justify-content-center flex-md-nowrap flex-wrap">
						<div class="dt-buttons btn-group flex-wrap">
							<button href="{<{@routerPathByName=api-panel-permission-add}>}" data-nouvu-action="get-modal" class="nouvu-event btn add-new btn-primary mt-50" tabindex="0" aria-controls="DataTables_Table_0" type="button" data-bs-toggle="modal" data-bs-target="#nouvu-modal">
								<span>Add Permission</span>
							</button>
						</div>
					</div>
				</div>
			</div>
			<div class="text-nowrap">
				<div>
					<table class="datatables-permissions table dataTable no-footer dtr-column">
						<thead>
							<tr>
								<th>Name</th>
								<th>Permission</th>
								<th>Role</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							{<{ListPermission}>}
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<!--/ Permission Table -->
{<{include=admin-panel/blocks/modal}>}
{<{include=admin-panel/blocks/modal-confirm}>}