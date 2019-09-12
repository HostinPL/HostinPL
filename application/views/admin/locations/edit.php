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
									Редактирование локации
								</h3>
							</div>
						</div>
						<div class="m-portlet__head-tools">
							<a href="/admin/servers/index?locationid=<?php echo $location['location_id'] ?>" class="btn btn-accent m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill m-btn--air">
								<i class="flaticon-delete-2"></i>
							</a>
						</div>
					</div>
					<div class="m-portlet__body">
						<form class="form-group form-md-line-input" action="#" id="editForm" method="POST">
						<div class="form-group form-md-line-input">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Введите название локации" value="<?php echo $location['location_name'] ?>">
                        </div>
                        <div class="form-group form-md-line-input">
                            <input type="text" class="form-control" id="ip2" name="ip2" placeholder="IP(Который видит пользователь)" value="<?php echo $location['location_ip2'] ?>">
                        </div>
                        <div class="form-group form-md-line-input">
                            <input type="text" class="form-control" id="ip" name="ip" placeholder="Введите IP(По которому подключаются)" value="<?php echo $location['location_ip'] ?>">
                        </div>
                        <div class="form-group form-md-line-input">
                            <input type="text" class="form-control" id="user" name="user" placeholder="Введите имя пользователя" value="<?php echo $location['location_user'] ?>">
                        </div>
                        <hr>
                        <div class="m-form__group form-group">
                            <label class="m-checkbox m-checkbox--bold m-checkbox--state-brand">
					            <input type="checkbox" id="editpassword" name="editpassword" onChange="togglePassword()"> Изменить пароль
					            <span></span>
				            </label>
				        </div>
				        <div class="form-group form-md-line-input">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Пароль" disabled>
                        </div>
                        <div class="form-group form-md-line-input">
                            <input type="password" class="form-control" id="password2" name="password2" placeholder="Повторите пароль" disabled>
                        </div>
                        <hr>
                        <div class="form-group form-md-line-input">
                            <select class="form-control" id="status" name="status" aria-required="true" aria-invalid="false" aria-describedby="delivery-error">
                                <option value="1"<?php if($location['location_status'] == 1): ?> selected="selected"<?php endif; ?>>Включена</option>
                                <option value="0"<?php if($location['location_status'] == 0): ?> selected="selected"<?php endif; ?>>Выключена</option>
                            </select>
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
                                        <span>Изменить</span>
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
					$('#editForm').ajaxForm({ 
						url: '/admin/locations/edit/ajax/<?php echo $location['location_id'] ?>',
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
									setTimeout("redirect('/admin/locations')", 1500);
									break;
							}
						},
						beforeSubmit: function(arr, $form, options) {
							$('button[type=submit]').prop('disabled', true);
						}
					});
					function togglePassword() {
						var status = $('#editpassword').is(':checked');
						if(status) {
							$('#password').prop('disabled', false);
							$('#password2').prop('disabled', false);
						} else {
							$('#password').prop('disabled', true);
							$('#password2').prop('disabled', true);
						}
					}
</script>
<?php echo $footer ?>
