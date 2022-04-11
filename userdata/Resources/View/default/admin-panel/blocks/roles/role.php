<div class="col-xl-4 col-lg-6 col-md-6">
	<div class="card">
		<div class="card-body">
			<div class="d-flex justify-content-between">
				<span>Total {{total}} users</span>
			</div>
			<div class="d-flex justify-content-between align-items-end mt-1 pt-25">
				<div class="role-heading">
					<h4 class="fw-bolder">{{name}}</h4>
					<a href="{{linkEdit}}" data-nouvu-action="get-modal" class="nouvu-event role-edit-modal" data-bs-toggle="modal" data-bs-target="#nouvu-modal">
						<small class="fw-bolder">Edit Role</small>
					</a>
				</div>
				<a href="{{linkRemove}}" data-nouvu-action="get-modal" class="nouvu-event text-body" data-bs-toggle="modal" data-bs-target="#nouvu-modal-confirm">
					<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-copy font-medium-5">
						<path d="M21 4H8l-7 8 7 8h13a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2z"></path>
						<line x1="18" y1="9" x2="12" y2="15"></line>
						<line x1="12" y1="9" x2="18" y2="15"></line>
					</svg>
				</a>
			</div>
		</div>
	</div>
</div>