<?php
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
?>
<html lang="en">

	<!-- begin::Head -->
	<head>
		<meta charset="utf-8" />
		<title><?php echo $title ?> | <?php echo $description ?></title>
		<meta name="description" content="<?php echo $description ?>">
        <meta name="keywords" content="<?php echo $keywords ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">

		<!--begin::Web font -->
		<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
		<script>
			WebFont.load({
				google: {
					"families": ["Poppins:300,400,500,600,700", "Roboto:300,400,500,600,700"]
				},
				active: function() {
					sessionStorage.fonts = true;
				}
			});
		</script>

		<!--end::Web font -->

		<!--begin::Base Styles -->
		<link href="/assets/vendors/base/vendors.bundle.css" rel="stylesheet" type="text/css" />

		<!--RTL version:<link href="../../../assets/vendors/base/vendors.bundle.rtl.css" rel="stylesheet" type="text/css" />-->
		<link href="/assets/demo/default/base/style.bundle.css" rel="stylesheet" type="text/css" />

		<!--RTL version:<link href="../../../assets/demo/default/base/style.bundle.rtl.css" rel="stylesheet" type="text/css" />-->

		<!--end::Base Styles -->
		<link rel="shortcut icon" href="/favicon.ico" />
	</head>

	<!-- end::Head -->

	<!-- begin::Body -->
	<body class="m--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">

		<!-- begin:: Page -->
		<div class="m-grid m-grid--hor m-grid--root m-page">
			<div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor m-login m-login--signin m-login--2 m-login-2--skin-3" id="m_login" style="background-image: url(../../../assets/app/media/img//bg/bg-2.jpg);">
				<div class="m-grid__item m-grid__item--fluid	m-login__wrapper">
					<div class="m-login__container">
						<div class="m-login__logo">
							<a href="#">
								<img src="<?php echo $logo ?>">
							</a>
						</div>
						<div class="m-login__signin">
							<div class="m-login__head">
								<h3 class="m-login__title">Авторизация</h3>
							</div>
							<form id="samirForm" method="POST" class="m-login__form m-form" action="">
								<div class="form-group m-form__group">
									<input class="form-control m-input" type="text" id="email" name="email" placeholder="Введите свой E-Mail">
								</div>
								<div class="form-group m-form__group">
									<input class="form-control m-input m-login__form-input--last" type="password" name="password"" placeholder="Введите свой Пароль">
								</div>
								<div class="row m-login__form-sub">
									<div class="col m--align-left m-login__form-left">
										<a data-toggle="modal" data-target="#hostin_supports" class="m-link">Нужна помощь ?</a>
									</div>
									<div class="col m--align-right m-login__form-right">
										<a href="javascript:;" id="m_login_forget_password" class="m-link">Забыли Пароль ?</a>
									</div>
								</div>
								<div class="m-divider">
									<span></span>
									<span>Капча</span>
									<span></span>
								</div>
								<br>
								<div class="recaptcha">
			                        <center><div class="g-recaptcha" data-sitekey="<?php echo $recaptcha ?>"></div></center>
			                    </div>
								<div class="m-login__form-action">
									<button type="submit" class="btn btn-info m-btn m-btn--pill m-btn--custom m-btn--air  m-login__btn">
										<span>
											<i class="flaticon-user-ok"></i>
											<span>Войти</span>
									    </span>
									</button>
									<?if($vk_stat == 1):?>
									<button href="#" onclick="VK.Auth.login(authInfo); return false;" class="btn btn-outline-info m-btn m-btn--pill m-btn--custom m-btn--air  m-login__btn">
										<span>
											<i class="fa socicon-vkontakte"></i>
									    </span>
									</button>
									<?endif;?>
								</div>
							</form>
						</div>
						<div class="m-login__signup">
							<div class="m-login__head">
								<h3 class="m-login__title">Регистрация</h3>
								<div class="m-login__desc">Введите свои данные для создания учетной записи:</div>
							</div>
							<form id="registerForm" method="GET" class="m-login__form m-form" action="">
								<div class="form-group m-form__group">
									<input class="form-control m-input" type="text" id="ref" name="ref" disabled placeholder="<?php
if(isset($_GET['ref'])) {
    echo 'Приглашение от: '.$user['user_firstname'].'('.$_GET['ref'].')';
}else echo 'Без приглашения';
?>">
								</div>
								<div class="form-group m-form__group">
									<input class="form-control m-input" type="text" id="firstname" name="firstname" placeholder="Введите Ваше Имя">
								</div>
								<div class="form-group m-form__group">
									<input class="form-control m-input" type="text" id="lastname" name="lastname" placeholder="Введите Вашу Фамилию">
								</div>
								<div class="form-group m-form__group">
									<input class="form-control m-input" type="text" id="email" name="email" placeholder="Введите Ваш E-Mail">
								</div>
								<div class="form-group m-form__group">
									<input class="form-control m-input m-login__form-input--last" type="password" id="password" name="password" placeholder="Введите Ваш Пароль">
								</div>
								<div class="form-group m-form__group">
									<input class="form-control m-input m-login__form-input--last" type="password" id="password2" name="password2" placeholder="Повторите Ваш Пароль">
								</div>
								<input type="hidden" name="ref" id="ref" value="<?echo $_GET['ref']?>">
								<br>
								<div class="m-divider">
									<span></span>
									<span>Капча</span>
									<span></span>
								</div>
								<br>
								<div class="recaptcha">
			                        <center><div class="g-recaptcha" data-sitekey="<?php echo $recaptcha ?>"></div></center>
			                    </div>
								<div class="m-login__form-action">
									<button type="submit" class="btn btn-info m-btn m-btn--pill m-btn--custom m-btn--air  m-login__btn">
										<span>
											<i class="flaticon-user-add"></i>
											<span>Зарегистрироваться</span>
									    </span>
									</button>
									<button id="m_login_signup_cancel" class="btn btn-outline-info m-btn m-btn--pill m-btn--custom m-btn--air  m-login__btn">
										<span>
											<i class="flaticon-reply"></i>
											<span>Отмена</span>
									    </span>
									</button>
								</div>
							</form>
						</div>
						<div class="m-login__forget-password">
							<div class="m-login__head">
								<h3 class="m-login__title">Восстановить пароль</h3>
								<div class="m-login__desc">Введите адрес электронной почты, чтобы сбросить пароль:</div>
							</div>
							<form id="restoreForm" method="POST" class="m-login__form m-form" action="">
								<div class="form-group m-form__group">
									<input class="form-control m-input" tid="email" name="email" placeholder="Введите свой E-Mail">
								</div>
								<br>
								<div class="m-divider">
									<span></span>
									<span>Капча</span>
									<span></span>
								</div>
								<br>
								<div class="recaptcha">
			                        <center><div class="g-recaptcha" data-sitekey="<?php echo $recaptcha ?>"></div></center>
			                    </div>
								<div class="m-login__form-action">
									<button type="submit" class="btn btn-info m-btn m-btn--pill m-btn--custom m-btn--air  m-login__btn">
										<span>
											<i class="flaticon-user-settings"></i>
											<span>Восстановить<span>
									    </span>
									</button>
								    <button id="m_login_forget_password_cancel" class="btn btn-outline-info m-btn m-btn--pill m-btn--custom m-btn--air  m-login__btn">
									    <span>
											<i class="flaticon-reply"></i>
											<span>Отмена</span>
									    </span>
								    </button>
								</div>
							</form>
						</div>
						<div class="m-login__account">
							<span class="m-login__account-msg">
								У вас ещё нет аккаунта?
							</span>&nbsp;&nbsp;
							<a href="javascript:;" id="m_login_signup" class="m-link m-link--light m-login__account-link">Зарегистрироваться</a>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- end:: Page -->

		<!--begin::Base Scripts -->
		<script src="/assets/vendors/base/vendors.bundle.js" type="text/javascript"></script>
		<script src="../../../assets/demo/default/base/scripts.bundle.js" type="text/javascript"></script>

		<!--end::Base Scripts -->

		<!--begin::Page Snippets -->
		<script src="/assets/snippets/custom/pages/user/login.js" type="text/javascript"></script>

		<!--end::Page Snippets -->
		<!-- END PAGE LEVEL SCRIPTS -->
        <script src="/application/public/js/jquery.form.min.js"></script>
        <script src="/application/public/js/jquery.form.js"></script>
        <script src="/application/public/js/main.js"></script>
        <!-- END PAGE LEVEL SCRIPTS -->
        <script type="text/javascript" src="/ckeditor/ckeditor.js"></script>
        <script src='https://www.google.com/recaptcha/api.js'></script>
        <!--begin::Modal-->
        <div class="modal fade" id="hostin_supports" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Обратная связь</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                    </div>
                    <div class="modal-body">
                        <form id="sendForm" method="POST" class="form_0" style="padding:0px; margin:0px;">
                            <div class="form-group m-form__group">
								<input class="form-control m-input" type="text" id="firstname" name="firstname" placeholder="Введите ваше имя..">
							</div>
							<div class="form-group m-form__group">
								<input class="form-control m-input" id="lastname" name="lastname" placeholder="Введите вашу фамилию..">
							</div>
							<div class="form-group m-form__group">
								<input class="form-control m-input" type="email" id="email" name="email" placeholder="Введите ваш email..">
							</div>
							<div class="form-group form-md-line-input">
                            <select class="form-control" id="subject" name="subject" size="1" aria-required="true" aria-invalid="false" aria-describedby="delivery-error">
					            <option value="Вопроос">Вопрос</option>
					            <option value="Проблемы с сервером">Проблемы с сервером</option>
					            <option value="Проблемы с аккаунтом">Проблемы с аккаунтом</option>
					            <option value="Сотрудничество">Сотрудничество</option>
                            </select>
                            </div>
							<div class="form-group form-md-line-input">
                            <textarea class="form-control" id="msg" name="msg" rows="3" placeholder="Сообщение..."></textarea>
                            </div>
                            <div class="recaptcha">
			                <center><div class="g-recaptcha" data-sitekey="<?php echo $recaptcha ?>"></div></center>
			                </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                        <input class="btn m-btn--square  btn-info" type="submit" value="Отправить">
                    </div>
                        </form>
                </div>
            </div>
        </div>
        <!--end::Modal-->
	</body>

	<!-- end::Body -->
</html>
<script>
	$('#sendForm').ajaxForm({ 
		url: '/common/loginheader/ajax_infobox',
		dataType: 'text',
		success: function(data) {
			console.log(data);
			data = $.parseJSON(data);
			switch(data.status) {
				case 'error':
					toastr.error(data.error);
					$('button[type=submit]').prop('disabled', false);
					break;
				case 'success':
					toastr.success(data.success);
					setTimeout("redirect('/')", 1500);
					break;
			}
		},
		beforeSubmit: function(arr, $form, options) {
			Command: toastr["info"]("Ожидайте!");
		}
	});
</script>
<!-- InfoBOX counter -->				
<script src="//vk.com/js/api/openapi.js" type="text/javascript"></script>
				<!-- Yandex.Metrika counter -->
<script type="text/javascript">
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter35431120 = new Ya.Metrika({
                    id:35431120,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true
                });
            } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/watch.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/35431120" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->

	<script>
		VK.init({
				apiId: <?php echo $vk_id ?>
			});
			function authInfo(response) {
				if(response.session) {
					$.ajax({ 
						url: "/account/login/vk",
						type: "POST",
						data: {auth: true, response: response},
						success: function (data) {
							console.log(data);
							data = $.parseJSON(data);
							switch(data.status) {
								case 'auth_error':								
									toastr.error(data.auth_error);									
								break;
								case 'success':
									toastr.info(data.success);
									setTimeout("redirect('/')", 1500);
								break;
							}
						}
					});
				}
			}
	</script>
	
<script>
			$('#samirForm').ajaxForm({ 
				url: '/account/login/ajax',
				dataType: 'text',
				success: function(data) {
					console.log(data);
					data = $.parseJSON(data);
					switch(data.status) {
						case 'error':
							toastr.error(data.error);
							$('button[type=submit]').prop('disabled', false);
							break;
						case 'success':
							toastr.success(data.success);
							setTimeout("redirect('/')", 1500);
							break;
					}
				},
				beforeSubmit: function(arr, $form, options) {
					$('button[type=submit]').prop('disabled', true);
				}
			});

			
			$('#registerForm').ajaxForm({ 
				url: '/common/loginheader/ajax',
				dataType: 'text',
				success: function(data) {
					console.log(data);
					data = $.parseJSON(data);
					switch(data.status) {
						case 'error':
							toastr.error(data.error);
							reloadImage('#captchaimage');
							$('button[type=submit]').prop('disabled', false);
							break;
						case 'success':
							toastr.success(data.success);
							setTimeout("redirect('/')", 1500);
							break;
					}
				},
				beforeSubmit: function(arr, $form, options) {
					$('button[type=submit]').prop('disabled', true);
				}
			});
			$('.captcha img').click(function() {
				reloadImage(this);
			});
			
			$('#restoreForm').ajaxForm({ 
				url: '/account/restore/ajax',
				dataType: 'text',
				success: function(data) {
					console.log(data);
					data = $.parseJSON(data);
					switch(data.status) {
						case 'error':
							toastr.error(data.error);
							$('button[type=submit]').prop('disabled', false);
							break;
						case 'success':
							toastr.success(data.success);
							setTimeout("redirect('/')", 1500);
							break;
					}
				},
				beforeSubmit: function(arr, $form, options) {
					$('button[type=submit]').prop('disabled', true);
				}
			});
		</script>
 
 		<?php if(isset($error)): ?><script>toastr.error('<?php echo $error ?>');</script><?php endif; ?> 
		<?php if(isset($warning)): ?><script>toastr.warning('<?php echo $warning ?>');</script><?php endif; ?> 
		<?php if(isset($success)): ?><script>toastr.success('<?php echo $success ?>');</script><?php endif; ?> 