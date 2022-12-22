<!DOCTYPE html>
<html lang="en">

<head>
	<!-- Meta Tags -->
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login</title>
	<!-- Favicon -->
	<link rel="shortcut icon" href="favicon.ico">
	<link rel="icon" href="favicon.ico" type="image/x-icon">
	<link href="<?= base_url()?>public/assets/dist/css/style.css" rel="stylesheet" type="text/css">
	<link href="<?= base_url()?>public/assets/dist/css/villainti.css" rel="stylesheet" type="text/css">
	<style>
		.form-control {
			font-size: 0.9rem;
			line-height: 1.6;
		}

		.text-is-valid {
			color: #00D67F;
		}

		.text-is-invalid {
			color: #ff0000;
		}
	</style>
</head>

<body>
	<!-- Wrapper -->
	<div class="hk-wrapper hk-pg-auth" data-footer="simple">
		<!-- Main Content -->
		<div class="hk-pg-wrapper pt-0 pb-xl-0 pb-5">
			<div class="hk-pg-body pt-0 pb-xl-0">
				<!-- Container -->
				<div class="container-xxl">
					<!-- Row -->
					<div class="row">
						<div class="col-sm-10 position-relative mx-auto">
							<div class="auth-content py-8">
								<form class="w-100" action="<?= base_url()?>login" method="POST">
								<div class="row">
									<div class="col-lg-5 col-md-7 col-sm-10 mx-auto my-auto">
										<div class="text-center mb-7">
											<a class="navbar-brand me-0" href="index.html">
												<img class="brand-img d-inline-block rounded" src="<?= base_url()?>public/image/default/<?= $settings['logo'] ?>" alt="brand">
											</a>
										</div>
										<div class="card card-lg card-border shadow-lg">
											<div class="card-body mt-3 mb-1">
												<h4 class="mb-2 text-center fw-bolder">The Room 88</h4>
												<p class="mb-4 text-center fs-7">Silahkan login untuk memulai sesi.</p>
												<?php
													$message = $this->session->flashdata('message');
													if (isset($message)) {
														echo  $message;
														$this->session->unset_userdata('message');
													}
													?>
													<?= $this->session->flashdata('message'); ?>
													<div class="row gx-3">
														<div class="form-group col-lg-12">
															<div class="form-label-group">
																<label class="title-sm">Email atau username</label>
															</div>

															<span class="input-affix-wrapper">
																<input class="form-control" placeholder="Ketikan email atau username" name="email" value="<?= set_value('email'); ?>" type="email">
																<div id="email-valid" class="input-suffix text-muted">
																	<span class="feather-icon d-none text-is-valid">
                                                                        <i class="form-icon" data-feather="check-circle"></i>
                                                                    </span>
																	<span class="feather-icon d-none text-is-invalid">
                                                                        <i class="form-icon" data-feather="x-circle"></i>
                                                                    </span>
																</div>
															</span>
                                                            <?= form_error('email', '<small class="valid-feedback fs-8 fw-bold" style="display:block;">', '</small>'); ?>
														</div>

														<div class="form-group col-lg-12">
															<div class="form-label-group">
																<label class="title-sm">Password</label>
															</div>
															<div class="input-group password-check">
																<span class="input-affix-wrapper">
																	<input class="form-control" name="password" placeholder="Ketikan password" type="password">
																	<a href="#" class="input-suffix text-muted">
																		<span class="feather-icon">
                                                                            <i class="form-icon" data-feather="eye"></i>
                                                                        </span>
																		<span class="feather-icon d-none">
                                                                            <i class="form-icon" data-feather="eye-off"></i>
                                                                        </span>
																	</a>
																</span>
															</div>
                                                            
                                                            <?= form_error('email', '<small class="valid-feedback fs-8 fw-bold" style="display:block;">', '</small>'); ?>
														</div>
													</div>
													<input type="hidden" name="<?= $this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />
													<button type="submit" class="btn btn-primary btn-block">Masuk</a>
												</div>
											</div>
										</div>
									</form>
									</div>
								</div>
							</div>
						</div>
					<!-- /Row -->
				</div>
				<!-- /Container -->
			</div>
			<!-- /Page Body -->

		</div>
		<!-- /Main Content -->
	</div>
	<!-- /Wrapper -->

	<!-- jQuery -->
	<script src="<?= base_url()?>public/assets/vendors/jquery/dist/jquery.min.js"></script>

	<!-- Bootstrap Core JS -->
	<script src="<?= base_url()?>public/assets/vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

	<!-- FeatherIcons JS -->
	<script src="<?= base_url()?>public/assets/dist/js/feather.min.js"></script>

	<!-- Fancy Dropdown JS -->
	<script src="<?= base_url()?>public/assets/dist/js/init.js"></script>

	<script>
		$(function () {
			checkValidEmail();
			loginClicked();
		})

		const checkValidEmail = function () {
			const inputEmail = "input[type='email']"
			const pattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/
			const validate = $('#email-valid span')
			$(inputEmail).keyup(function () {
				if ($(this).val().match(pattern)) {
					$(this).addClass('is-valid')
					$(this).removeClass('is-invalid')
					validate[0].classList.remove('d-none')
					validate[1].classList.add('d-none')
				} else {
					$(this).removeClass('is-valid')
					$(this).addClass('is-invalid')
					validate[1].classList.remove('d-none')
					validate[0].classList.add('d-none')
				}
			});
		}

		const loginClicked = function () {
			$('#submit').click(function () {
				$(this).html(
					`<div class="spinner-border spinner-border-sm" role="status">
						<span class="sr-only">Loading...</span>
					</div>`
				)
			})
		}
	</script>

</body>

</html>