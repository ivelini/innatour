<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Вход</title>

	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="../../../../global_assets/css/icons/icomoon/styles.min.css" rel="stylesheet" type="text/css">
	<link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="assets/css/bootstrap_limitless.min.css" rel="stylesheet" type="text/css">
	<link href="assets/css/layout.min.css" rel="stylesheet" type="text/css">
	<link href="assets/css/components.min.css" rel="stylesheet" type="text/css">
	<link href="assets/css/colors.min.css" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->

	<!-- Core JS files -->
	<script src="../../../../global_assets/js/main/jquery.min.js"></script>
	<script src="../../../../global_assets/js/main/bootstrap.bundle.min.js"></script>
	<script src="../../../../global_assets/js/plugins/loaders/blockui.min.js"></script>
	<!-- /core JS files -->

	<!-- Theme JS files -->
	<script src="../../../../global_assets/js/plugins/forms/styling/uniform.min.js"></script>

	<script src="assets/js/app.js"></script>
	<script src="../../../../global_assets/js/demo_pages/login.js"></script>
	<!-- /theme JS files -->

</head>

<body>

	<!-- Page content -->
	<div class="page-content">

		<!-- Main content -->
		<div class="content-wrapper">

			<!-- Content area -->
			<div class="content d-flex justify-content-center align-items-center">

				<!-- Registration form -->
				<form method="post" class="login-form" action="{{ route('register') }}">
					@csrf
					<div class="card mb-0">
						<div class="card-body">
							<div class="text-center mb-3">
								<i class="icon-plus3 icon-2x text-success border-success border-3 rounded-round p-3 mb-3 mt-1"></i>
								<h5 class="mb-0">Регистрация</h5>
							</div>

							<div class="form-group text-center text-muted content-divider">
								<span class="px-2">Ваши данные</span>
							</div>

							<div class="form-group form-group-feedback form-group-feedback-left">
								<input type="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Логин">
								<div class="form-control-feedback">
									<i class="icon-user-check text-muted"></i>
								</div>

								@error('name')
									<span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
								@enderror
							</div>

							<div class="form-group form-group-feedback form-group-feedback-left">
								<input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="Почта">
								<div class="form-control-feedback">
									<i class="icon-mention text-muted"></i>
								</div>

								@error('email')
									<span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
								@enderror
							</div>

							<div class="form-group form-group-feedback form-group-feedback-left">
								<input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Пароль">
								<div class="form-control-feedback">
									<i class="icon-user-lock text-muted"></i>
								</div>

								@error('password')
									<span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
								@enderror
							</div>

							<div class="form-group text-center text-muted content-divider">
								<span class="px-2">Правила</span>
							</div>

							<div class="form-group form-group-feedback form-group-feedback-left">
								<div class="form-check">
									<label class="form-check-label">
										<input type="checkbox" name="chekOkService" class="form-input-styled" {{ old('chekOkService') ? 'checked' : '' }} data-fouc>
										Я принимаю <a href="#">условия использования</a>
									</label>
								</div>

								@error('chekOkService')
									<span class="invalid-feedback" style="display: block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
								@enderror
							</div>

							<button type="submit" class="btn bg-teal-400 btn-block">Регистрация <i class="icon-circle-right2 ml-2"></i></button>


							<span class="form-text text-center text-muted">Есть учетная запись? <a href="{{ route('login') }}">Войти</a></span>

					</div>
					</div>
				</form>
				<!-- /registration form -->

			</div>
			<!-- /content area -->

		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->

</body>
</html>
