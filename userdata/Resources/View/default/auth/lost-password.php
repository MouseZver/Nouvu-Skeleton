<!-- Reset password-->
<div class="d-flex col-lg-4 align-items-center auth-bg px-2 p-lg-5">
	<div class="col-12 col-sm-8 col-md-6 col-lg-12 px-xl-2 mx-auto">
		<h2 class="card-title fw-bold mb-1">Reset Password 🔒</h2>
		<p class="card-text mb-2">Your new password must be different from previously used passwords</p>
		{<{errors}>}
		<form class="auth-reset-password-form mt-2" action="/lost-password?confirm={<{queryConfirm}>}" method="POST">
			<div class="mb-1">
				<div class="d-flex justify-content-between">
					<label class="form-label" for="reset-password-new">New Password</label>
				</div>
				<div class="input-group input-group-merge form-password-toggle">
					<input class="form-control form-control-merge" id="reset-password-new" type="password" name="password[first]" placeholder="************" aria-describedby="reset-password-new" autofocus="" tabindex="1" /><span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
				</div>
			</div>
			<div class="mb-1">
				<div class="d-flex justify-content-between">
					<label class="form-label" for="reset-password-confirm">Confirm Password</label>
				</div>
				<div class="input-group input-group-merge form-password-toggle">
					<input class="form-control form-control-merge" id="reset-password-confirm" type="password" name="password[second]" placeholder="************" aria-describedby="reset-password-confirm" tabindex="2" /><span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
				</div>
			</div>
			<button class="btn btn-primary w-100" tabindex="3">Set New Password</button>
		</form>
		<p class="text-center mt-2"><a href="/login"><i data-feather="chevron-left"></i> Back to login</a></p>
	</div>
</div>
<!-- /Reset password-->