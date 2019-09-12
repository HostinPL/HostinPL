<?php
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
?>
<?php include 'application/views/common/menuserver.php';?>
<div class="m-content">
	<div class="row">
		<div class="col-lg-12">
			<div class="m-portlet">
				<div class="m-portlet__head">
					<div class="m-portlet__head-caption">
						<div class="m-portlet__head-title">
							<h3 class="m-portlet__head-text">Настройки</h3>
						</div>
					</div>
				</div>
				<div class="m-portlet__body">
					<div class="m-section m-section--last">
						<div class="m-section__content">
							<div class="row">
								<div class="col-lg-6">
									<div class="m-demo" data-code-preview="true" data-code-html="true" data-code-js="false">
										<div class="m-demo__preview">
											<ul class="m-nav m-nav--active-bg" id="m_nav" role="tablist">
												<li class="m-nav__item m-nav__item--active">
													<a class="m-nav__link" role="tab" id="m_nav_link_1" data-toggle="collapse" href="#m_nav_sub_1" aria-expanded="true">
														<span class="m-nav__link-title">
															<span class="m-nav__link-wrap">
																<span class="m-nav__link-text">MySQL</span>
																<span class="m-nav__link-badge"></span>
														    </span>
														</span>
														<span class="m-nav__link-arrow"></span>
													</a>
													<ul class="m-nav__sub collapse show" id="m_nav_sub_1" role="tabpanel" aria-labelledby="m_nav_link_1" data-parent="#m_nav" style="">
														<li class="m-nav__item">
															<form class="form-horizontal" action="#" id="editFormm" method="POST">
															<div class="m-form__group form-group row">
												                <label class="col-7 col-form-label">Сменить пароль MySQL</label>
												                <div class="col-1">
													                <span class="m-switch m-switch--sm m-switch--icon">
														                <label>
															                <input type="checkbox" id="editpasswordm" name="editpasswordm" onchange="togglePasswordm()">
															                <span></span>
														                </label>
													                </span>
												                </div>
											                </div>
											                <div class="form-group form-md-line-input">
                                                                <input type="text" class="form-control" id="passwordm" name="passwordm" placeholder="Введите пароль" disabled="">
                                                            </div>
                                                            <div class="form-group form-md-line-input">
                                                                <input type="text" class="form-control" id="password2m" name="password2m" placeholder="Повторите ввод пароля" disabled="">
                                                            </div>
                                                            <input type="submit" class="m-btn m-btn--icon m-btn--icon-only btn-block btn btn-info m-btn--air" value="Сохранить">
                                                            </form>
														</li>
													</ul>
												</li>
											</ul>
										</div>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="m-demo" data-code-preview="true" data-code-html="true" data-code-js="false">
										<div class="m-demo__preview">
											<ul class="m-nav m-nav--active-bg" id="m_nav" role="tablist">
												<li class="m-nav__item m-nav__item--active">
													<a class="m-nav__link" role="tab" id="m_nav_link_2" data-toggle="collapse" href="#m_nav_sub_2" aria-expanded="true">
														<span class="m-nav__link-title">
															<span class="m-nav__link-wrap">
																<span class="m-nav__link-text">FTP</span>
																<span class="m-nav__link-badge"></span>
														    </span>
														</span>
														<span class="m-nav__link-arrow"></span>
													</a>
													<ul class="m-nav__sub collapse show" id="m_nav_sub_2" role="tabpanel" aria-labelledby="m_nav_link_2" data-parent="#m_nav" style="">
														<li class="m-nav__item">
															<form class="form-horizontal" action="#" id="editForm" method="POST">
															<div class="m-form__group form-group row">
												                <label class="col-7 col-form-label">Сменить пароль FTP</label>
												                <div class="col-1">
													                <span class="m-switch m-switch--sm m-switch--icon">
														                <label>
															                <input type="checkbox" id="editpassword" name="editpassword" onchange="togglePassword()">
															                <span></span>
														                </label>
													                </span>
												                </div>
											                </div>
											                <div class="form-group form-md-line-input">
                                                                <input type="text" class="form-control" id="password" name="password" placeholder="Введите пароль" disabled="">
                                                            </div>
                                                            <div class="form-group form-md-line-input">
                                                                <input type="text" class="form-control" id="password2" name="password2" placeholder="Повторите ввод пароля" disabled="">
                                                            </div>
                                                            <input type="submit" class="m-btn m-btn--icon m-btn--icon-only btn-block btn btn-info m-btn--air" value="Сохранить">
                                                            </form>
														</li>
													</ul>
												</li>
											</ul>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
				<script>	
					$('#editForm').ajaxForm({ 
						url: '/servers/config/ajax/<?php echo $server['server_id'] ?>',
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
									break;
							}
						},
						beforeSubmit: function(arr, $form, options) {
							$('button[type=submit]').prop('disabled', true);
						}
					});
					
					$('#editFormm').ajaxForm({ 
						url: '/servers/config/ajax/<?php echo $server['server_id'] ?>',
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
									break;
							}
						},
						beforeSubmit: function(arr, $form, options) {
							$('button[type=submit]').prop('disabled', true);
						}
					});
					function sendAction(serverid, action) {
						
						$.ajax({ 
							url: '/servers/config/action/'+serverid+'/'+action,
							dataType: 'text',
							success: function(data) {
								console.log(data);
								data = $.parseJSON(data);
								switch(data.status) {
									case 'error':
										toastr.error(data.error);
										$('#controlBtns button').prop('disabled', false);
										break;
									case 'success':
										toastr.success(data.success);
										setTimeout("reload()", 1500);
										break;
								}
							},
							beforeSend: function(arr, options) {
								<?php foreach($adaps as $item): ?> 
									if(action == "<?echo $item['adap_action']?>") toastr.warning("Идет установка <?echo $item['adap_name']?>, пожалуйста подождите 3 минуты!");
											<?endforeach;?>
									$('#controlBtns button').prop('disabled', true);
								}
						});
					}
					
					function togglePassword() {
						var status = $('#editpassword').is(':checked');
						if(status) {
							$('#password').prop('disabled', false);
							$('#password2').prop('disabled', false);
							$('#passwordm').prop('disabled', true);
							$('#password2m').prop('disabled', true);
						} else {
							$('#password').prop('disabled', true);
							$('#password2').prop('disabled', true);

						}
					}
										function togglePasswordm() {
						var status = $('#editpasswordm').is(':checked');
						if(status) {
							$('#passwordm').prop('disabled', false);
							$('#password2m').prop('disabled', false);
							$('#password').prop('disabled', true);
							$('#password2').prop('disabled', true);
						} else {
							$('#passwordm').prop('disabled', true);
							$('#password2m').prop('disabled', true);
						}
					}
					$('#payForm').ajaxForm({ 
						url: '/servers/pay/ajax/<?php echo $server['server_id'] ?>',
						dataType: 'text',
						success: function(data) {
							console.log(data);
							data = $.parseJSON(data);
							switch(data.status) {
								case 'error':
									toastr.errore(data.error);
									$('button[type=submit]').prop('disabled', false);
									break;
								case 'success':
									toastr.success(data.success);
									break;
							}
						},
						beforeSubmit: function(arr, $form, options) {
							$('button[type=submit]').prop('disabled', true);
						}
					});
						
				</script>

<script type="text/javascript" charset="utf-8">
   $(document).ready(function() {
    $('#elfinder').elfinder({
     url : '/servers/control/getftp/<?php echo $server['server_id']  ?>'
     , lang: 'ru'
    });
   });
</script>
  <script src="/application/public/js/elfinder.full.js"></script>
  <script src="/application/public/js/i18n/elfinder.ru.js"></script>
  <link rel="stylesheet" type="text/css" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.23/themes/smoothness/jquery-ui.css">
  <link rel="stylesheet" type="text/css" href="/application/public/css/elfinder.full.css">
  <link rel="stylesheet" type="text/css" href="/application/public/css/theme.css">
				<!--Page Related Scripts-->
    <script src="/application/public/js/sparkline-chart.js"></script>
	<script src="/application/public/js/easy-pie-chart.js"></script>
	<script src="/application/public/assets/jquery.easy-pie-chart.js"></script>
<?php echo $footer ?>
