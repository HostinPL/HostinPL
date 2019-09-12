<?php
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
?>
<?php echo $admheader ?>
<div class="col-12">
    <div class="m-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="m-portlet m-portlet--brand m-portlet--head-solid-bg">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <span class="m-portlet__head-icon">
                                    <i class="flaticon-map-location"></i>
                                </span>
                                <h3 class="m-portlet__head-text">
                                    Создание локации
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        <form class="form-group form-md-line-input" action="#" id="createForm" method="POST">
                        <div class="form-group form-md-line-input">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Введите название локации">
                        </div>
                        <div class="form-group form-md-line-input">
                            <input type="text" class="form-control" id="ip2" name="ip2" placeholder="Введите IP (Который видит пользователь)">
                        </div>
                        <div class="form-group form-md-line-input">
                            <input type="text" class="form-control" id="ip" name="ip" placeholder="Введите IP (По которому подключаются)">
                        </div>
                        <div class="form-group form-md-line-input">
                            <input type="text" class="form-control" id="user" name="user" placeholder="Введите имя пользователя">
                        </div>
                        <div class="form-group form-md-line-input">
                            <input type="text" class="form-control" id="password" name="password" placeholder="Пароль">
                        </div>
                        <div class="form-group form-md-line-input">
                            <input type="text" class="form-control" id="password2" name="password2" placeholder="Повторите пароль">
                        </div>
                        <div class="m-portlet__foot">
                            <div class="m--align-center">
                                <a href="/admin/locations" class="btn btn-secondary m-btn m-btn--icon m-btn--wide m-btn--md m--margin-right-10 m-btn--air">
                                    <span>
                                        <i class="la la-arrow-left"></i>
                                        <span>Отмена</span>
                                    </span>
                                </a>
                                <button type="submit" class="btn btn-brand  m-btn m-btn--icon m-btn--wide m-btn--md m-btn--air">
                                    <span>
                                        <i class="la la-check"></i>
                                        <span>Создать</span>
                                    </span>
                                </button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
					$('#createForm').ajaxForm({ 
						url: '/admin/locations/create/ajax',
						dataType: 'text',
						success: function(data) {
							console.log(data);
							data = $.parseJSON(data);
							switch(data.status) {
								case 'error':
									showError(data.error);
									$('button[type=submit]').prop('disabled', false);
									break;
								case 'success':
									showSuccess(data.success);
									setTimeout("redirect('/admin/locations')", 1500);
									break;
							}
						},
						beforeSubmit: function(arr, $form, options) {
							$('button[type=submit]').prop('disabled', true);
						}
					});
</script>
<?php echo $footer ?>
