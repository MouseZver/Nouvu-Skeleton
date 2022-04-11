<tr>
	<td>{{ username }}</td>
	<td>{{ email }}</td>
	<td>{{ roles }}</td>
	<td>{{ created }}</td>
	<td>
		<div class="dropdown">
			<button type="button" class="btn btn-sm dropdown-toggle hide-arrow py-0 waves-effect waves-float waves-light" data-bs-toggle="dropdown" aria-expanded="false">
				<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg>
			</button>
			<div class="dropdown-menu dropdown-menu-end" style="">
				<a href="{{ edit }}" data-nouvu-action="get-modal" class="nouvu-event dropdown-item" data-bs-toggle="modal" data-bs-target="#nouvu-modal">
					<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 me-50">
						<path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
					</svg>
					<span>Edit</span>
				</a>
				<a href="{{ remove }}" data-nouvu-action="get-modal" class="nouvu-event dropdown-item" data-bs-toggle="modal" data-bs-target="#nouvu-modal-confirm">
					<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash me-50">
						<polyline points="3 6 5 6 21 6"></polyline>
						<path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
					</svg>
					<span>Delete</span>
				</a>
			</div>
		</div>
	</td>
</tr>