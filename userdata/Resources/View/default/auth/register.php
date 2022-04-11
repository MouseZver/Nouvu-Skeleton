<!-- Register-->
<div class="d-flex col-lg-4 align-items-center auth-bg px-2 p-lg-5">
	<div class="col-12 col-sm-8 col-md-6 col-lg-12 px-xl-2 mx-auto">
		<h2 class="card-title fw-bold mb-1">Adventure starts here 🚀</h2>
		<p class="card-text mb-2">Make your app management easy and fun!</p>
		{<{errors}>}
		<form class="auth-register-form mt-2" action="/registration" method="POST">
			<div class="mb-1">
				<label class="form-label" for="register-username">Phone</label>
				<input class="form-control" id="register-username" type="text" name="phone" placeholder="+380**********" value="{<{requestPhone}>}" aria-describedby="register-username" autofocus="" tabindex="1" />
			</div>
			<div class="mb-1">
				<label class="form-label" for="register-email">Email</label>
				<input class="form-control" id="register-email" type="email" name="email" placeholder="nouvu@example.com" value="{<{requestEmail}>}" aria-describedby="register-email" tabindex="2" />
			</div>
			<div class="mb-1">
				<label class="form-label" for="register-password">Password</label>
				<div class="input-group input-group-merge form-password-toggle">
					<input class="form-control form-control-merge" id="register-password" type="password" name="password.first" placeholder="************" aria-describedby="register-password" tabindex="3" /><span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
				</div>
			</div>
			<div class="mb-1">
				<div class="d-flex justify-content-between">
					<label class="form-label" for="reset-password-confirm">Confirm Password</label>
				</div>
				<div class="input-group input-group-merge form-password-toggle">
					<input class="form-control form-control-merge" id="reset-password-confirm" type="password" name="password.second" placeholder="************" aria-describedby="reset-password-confirm" tabindex="2"><span class="input-group-text cursor-pointer"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></span>
				</div>
			</div>
			<button class="btn btn-primary w-100" tabindex="5">Sign up</button>
		</form>
		<p class="text-center mt-2"><span>Already have an account?</span><a href="/login"><span>&nbsp;Sign in instead</span></a></p>
	</div>
</div>
<!-- /Register-->