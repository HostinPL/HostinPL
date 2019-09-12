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
									<i class="flaticon-cogwheel-2"></i>
								</span>
								<h3 class="m-portlet__head-text">
									Настройки
								</h3>
							</div>
						</div>
					</div>
					<div class="m-portlet__body">
						<ul class="m-widget27__nav-items nav nav-pills nav-fill" role="tablist">
							<li class="m-widget27__nav-item nav-item">
								<a class="nav-link active show" data-toggle="pill" href="#hostinpl1">Общие настройки</a>
							</li>
							<li class="m-widget27__nav-item nav-item">
								<a class="nav-link" data-toggle="pill" href="#hostinpl2">Платежные системы</a>
							</li>
							<li class="m-widget27__nav-item nav-item">
								<a class="nav-link" data-toggle="pill" href="#hostinpl3">Прочие настройки</a>
							</li>
							<li class="m-widget27__nav-item nav-item">
								<a class="nav-link" data-toggle="pill" href="#hostinpl4">Информация о компании</a>
							</li>
						</ul>
						<hr>
						<form class="form-group form-md-line-input" id="settings" method="post" action="" novalidate="novalidate">
						<div class="m-widget27__tab tab-content m-widget27--no-padding">
							<div id="hostinpl1" class="tab-pane active show">
								<div class="form-group form-md-line-input">
									<label class="form-control-label">* URL сайта</label>
                                    <input type="text" class="form-control" id="url" name="url" placeholder="Введите URL сайта" value="<?php echo $settings['url'] ?>">
                                </div>
                                <div class="form-group form-md-line-input">
                                	<label class="form-control-label">* Название сайта</label>
                                    <input type="text" class="form-control" id="title" name="title" placeholder="Введите название сайта" value="<?php echo $settings['title'] ?>">
                                </div>
                                <div class="form-group form-md-line-input">
                                	<label class="form-control-label">* Описание сайта</label>
                                    <input type="text" class="form-control" id="description" name="description" placeholder="Введите описание сайта" value="<?php echo $settings['description'] ?>">
                                </div>
                                <div class="form-group form-md-line-input">
                                	<label class="form-control-label">* Ключевые слова</label>
                                    <input type="text" class="form-control" id="keywords" name="keywords" placeholder="Введите ключевые слова" value="<?php echo $settings['keywords'] ?>">
                                </div>
                                <div class="form-group form-md-line-input">
                                	<label class="form-control-label">* Имя отправителя</label>
                                    <input type="text" class="form-control" id="mail_sender" name="mail_sender" placeholder="Введите имя отправителя" value="<?php echo $settings['mail_sender'] ?>">
                                </div>
                                <div class="form-group form-md-line-input">
                                	<label class="form-control-label">* E-mail Службы поддержки</label>
                                    <input type="text" class="form-control" id="mail_from" name="mail_from" placeholder="Введите E-mail Службы поддержки" value="<?php echo $settings['mail_from'] ?>">
                                </div>
                                <div class="form-group form-md-line-input">
                                	<label class="form-control-label">* ID Вашей группы ВКонтакте</label>
                                    <input type="text" class="form-control" id="public" name="public" placeholder="Введите ID Вашей группы ВКонтакте" value="<?php echo $settings['public'] ?>">
                                </div>
                                <div class="form-group form-md-line-input">
                                	<label class="form-control-label">* Cсылка на ваш логотип</label>
                                    <input type="text" class="form-control" id="logo" name="logo" placeholder="Введите ссылку на ваш логотип" value="<?php echo $settings['logo'] ?>">
                                </div>
							</div>
							<div id="hostinpl2" class="tab-pane">
								<div class="form-group form-md-line-input">
									<label class="form-control-label">* Платежная система: Freekassa</label>
                                    <select class="form-control" id="robokassa" name="robokassa" aria-required="true" aria-invalid="false" aria-describedby="delivery-error">
                                        <option value="1"<?php if($settings['robokassa'] == 1): ?> selected="selected"<?php endif; ?>>Включена</option>
                                        <option value="0"<?php if($settings['robokassa'] == 0): ?> selected="selected"<?php endif; ?>>Выключена</option>
                                    </select>
                                </div>
                                <div class="form-group form-md-line-input">
                                	<label class="form-control-label">* Платежная система: Unitpay</label>
                                    <select class="form-control" id="unitpay" name="unitpay" aria-required="true" aria-invalid="false" aria-describedby="delivery-error">
                                        <option value="0"<?php if($settings['unitpay'] == 0): ?> selected="selected"<?php endif; ?>>Выключена</option>
                                        <option value="1"<?php if($settings['unitpay'] == 1): ?> selected="selected"<?php endif; ?>>Включена</option>
                                    </select>
                                </div>
                                <div class="form-group form-md-line-input">
                                	<label class="form-control-label">* Платежная система: Interkassa</label>
                                    <select class="form-control" id="interkassa" name="interkassa" aria-required="true" aria-invalid="false" aria-describedby="delivery-error">
                                        <option value="0"<?php if($settings['interkassa'] == 0): ?> selected="selected"<?php endif; ?>>Выключена</option>
                                        <option value="1"<?php if($settings['interkassa'] == 1): ?> selected="selected"<?php endif; ?>>Включена</option>
                                    </select>
                                </div>
                                <div class="form-group form-md-line-input">
                                    <label class="form-control-label">* Платежная система: Yandex</label>
                                    <select class="form-control" id="yandexkassa" name="yandexkassa" aria-required="true" aria-invalid="false" aria-describedby="delivery-error">
                                        <option value="0"<?php if($settings['yandexkassa'] == 0): ?> selected="selected"<?php endif; ?>>Выключена</option>
                                        <option value="1"<?php if($settings['yandexkassa'] == 1): ?> selected="selected"<?php endif; ?>>Включена</option>
                                    </select>
                                </div>
                                <hr>
                                <label class="form-control-label">* Платежная система: Freekassa</label>
                                <div class="form-group form-md-line-input">
                                    <input type="text" class="form-control" id="rk_login" name="rk_login" placeholder="Введите ID" value="<?php echo $settings['rk_login'] ?>">
                                    <label for="name">Freekassa ID</label>
                                </div>
                                <div class="form-group form-md-line-input">
                                    <input type="text" class="form-control" id="rk_password1" name="rk_password1" placeholder="Введите секречный ключ №1" value="<?php echo $settings['rk_password1'] ?>">
                                    <label for="name">Freekassa Key 1</label>
                                </div>
                                <div class="form-group form-md-line-input">
                                    <input type="text" class="form-control" id="rk_password2" name="rk_password2" placeholder="Введите секречный ключ №2" value="<?php echo $settings['rk_password2'] ?>">
                                    <label for="name">Freekassa Key 2</label>
                                </div>
                                <hr>
                                <label class="form-control-label">* Платежная система: Unitpay</label>
                                <div class="form-group form-md-line-input">
                                    <input type="text" class="form-control" id="unitpay_url" name="unitpay_url" placeholder="Введите URL" value="<?php echo $settings['unitpay_url'] ?>">
                                    <label for="name">Unitpay URL</label>
                                </div>
                                <div class="form-group form-md-line-input">
                                    <input type="text" class="form-control" id="unitpay_secret" name="unitpay_secret" placeholder="Введите секретный ключ" value="<?php echo $settings['unitpay_secret'] ?>">
                                    <label for="name">Unitpay секретный ключ</label>
                                </div>
                                <hr>
                                <label class="form-control-label">* Платежная система: Interkassa</label>
                                <div class="form-group form-md-line-input">
                                    <input type="text" class="form-control" id="ik_shopid" name="ik_shopid" placeholder="Введите ID" value="<?php echo $settings['ik_shopid'] ?>">
                                    <label for="name">Interkassa ID (ik_shopid)</label>
                                </div>
                                <div class="form-group form-md-line-input">
                                    <input type="text" class="form-control" id="ik_secretkey" name="ik_secretkey" placeholder="Введите секретный ключ" value="<?php echo $settings['ik_secretkey'] ?>">
                                    <label for="name">Interkassa Key (ik_secretkey)</label>
                                </div>
                                <hr>
                                <label class="form-control-label">* Платежная система: Yandex</label>
                                <div class="form-group form-md-line-input">
                                    <input type="text" class="form-control" id="yk_login" name="yk_login" placeholder="Введите login" value="<?php echo $settings['yk_login'] ?>">
                                    <label for="name">Login</label>
                                </div>
                                <div class="form-group form-md-line-input">
                                    <input type="text" class="form-control" id="yk_password1" name="yk_password1" placeholder="Введите pass" value="<?php echo $settings['yk_password1'] ?>">
                                    <label for="name">Pass</label>
                                </div>
							</div>
							<div id="hostinpl3" class="tab-pane">
								<div class="form-group form-md-line-input">
									<label class="form-control-label">* Тестовый период</label>
                                    <select class="form-control" id="serv_test" name="serv_test" aria-required="true" aria-invalid="false" aria-describedby="delivery-error">
                                        <option value="0"<?php if($settings['serv_test'] == 0): ?> selected="selected"<?php endif; ?>>Заказ запрещен</option>
                                        <option value="1"<?php if($settings['serv_test'] == 1): ?> selected="selected"<?php endif; ?>>Заказ разрешен (по одобрению)</option>
                                    </select>
                                </div>
                                <div class="form-group form-md-line-input">
                                	<label class="form-control-label">* Подтверждение E-mail</label>
                                    <select class="form-control" id="register" name="register" aria-required="true" aria-invalid="false" aria-describedby="delivery-error">
                                        <option value="0"<?php if($settings['register'] == 0): ?> selected="selected"<?php endif; ?>>Включен</option>
                                        <option value="1"<?php if($settings['register'] == 1): ?> selected="selected"<?php endif; ?>>Выключен</option>
                                    </select>
                                </div>
                                <hr>
                                <label class="form-control-label">* Тех.работы</label>
                                <div class="form-group form-md-line-input">
                                    <select class="form-control" id="offline" name="offline" aria-required="true" aria-invalid="false" aria-describedby="delivery-error">
                                        <option value="0"<?php if($settings['offline'] == 0): ?> selected="selected"<?php endif; ?>>Хостинг доступен</option>
                                        <option value="1"<?php if($settings['offline'] == 1): ?> selected="selected"<?php endif; ?>>Хостинг закрыт на тех.работы</option>
                                    </select>
                                    <label for="name">Статус тех.работ</label>
                                </div>
                                <div class="form-group form-md-line-input">
                                    <input type="text" class="form-control" id="offline_res" name="offline_res" placeholder="Введите сообщение тех.работ" value="<?php echo $settings['offline_res'] ?>">
                                    <label for="name">Сообщение тех.работ</label>
                                </div>
                                <hr>
                                <label class="form-control-label">* Настройка SMSAERO</label>
                                <div class="form-group form-md-line-input">
                                    <input type="text" class="form-control" id="email_smsaero" name="email_smsaero" placeholder="Введите E-mail" value="<?php echo $settings['email_smsaero'] ?>">
                                    <label for="name">E-mail</label>
                                </div>
                                <div class="form-group form-md-line-input">
                                    <input type="text" class="form-control" id="secret_smsaero" name="secret_smsaero" placeholder="Введите секретный ключ" value="<?php echo $settings['secret_smsaero'] ?>">
                                    <label for="name">Cекретный ключ</label>
                                </div>
                                <hr>
                                <label class="form-control-label">* Авторизация VK</label>
                                <div class="form-group form-md-line-input">
                                    <input type="text" class="form-control" id="vk_id" name="vk_id" placeholder="Введите ID приложения" value="<?php echo $settings['vk_id'] ?>">
                                    <label for="name">ID приложения</label>
                                </div>
                                <div class="form-group form-md-line-input">
                                    <select class="form-control" id="vk_stat" name="vk_stat" aria-required="true" aria-invalid="false" aria-describedby="delivery-error">
                                        <option value="0"<?php if($settings['vk_stat'] == 0): ?> selected="selected"<?php endif; ?>>Выключен</option>
                                        <option value="1"<?php if($settings['vk_stat'] == 1): ?> selected="selected"<?php endif; ?>>Включен</option>
                                    </select>
                                    <label for="form_control_1">Статус авторизаци</label>
                                </div>
                                <hr>
                                <label class="form-control-label">* VK BOT</label>
                                <div class="form-group form-md-line-input">
                                    <select class="form-control" id="VK_bot" name="VK_bot" aria-required="true" aria-invalid="false" aria-describedby="delivery-error">
                                        <option value="0"<?php if($settings['VK_bot'] == 0): ?> selected="selected"<?php endif; ?>>Выключен</option>
                                        <option value="1"<?php if($settings['VK_bot'] == 1): ?> selected="selected"<?php endif; ?>>Включен</option>
                                    </select>
                                    <label for="form_control_1">Статус бота</label>
                                </div>
                                <div class="form-group form-md-line-input">
                                    <input type="text" class="form-control" id="VK_confirmationToken" name="VK_confirmationToken" placeholder="ConfirmationToken" value="<?php echo $settings['VK_confirmationToken'] ?>">
                                    <label for="name">ConfirmationToken</label>
                                </div>
                                <div class="form-group form-md-line-input">
                                    <input type="text" class="form-control" id="VK_token" name="VK_token" placeholder="Введите Token" value="<?php echo $settings['VK_token'] ?>">
                                    <label for="name">Token</label>
                                </div>
                                <div class="form-group form-md-line-input">
                                    <input type="text" class="form-control" id="VK_secretKey" name="VK_secretKey" placeholder="Введите секретный ключ" value="<?php echo $settings['VK_secretKey'] ?>">
                                    <label for="name">Секретный ключ</label>
                                </div>
                                <hr>
                                <div class="form-group form-md-line-input">
                                	<label class="form-control-label">* Стоимость смены порта</label>
                                    <input type="text" class="form-control" id="portPrice" name="portPrice" placeholder="Введите стоимость смены порта" value="<?php echo $settings['portPrice'] ?>">
                                </div>
							</div>
							<div id="hostinpl4" class="tab-pane">
								<div class="form-group form-md-line-input">
									<label class="form-control-label">* Улица компании</label>
                                    <input type="text" class="form-control" id="homed" name="homed" placeholder="Введите улицу" value="<?php echo $settings['homed'] ?>">
                                </div>
                                <div class="form-group form-md-line-input">
                                	<label class="form-control-label">* Город компании</label>
                                    <input type="text" class="form-control" id="city_country" name="city_country" placeholder="Введите город" value="<?php echo $settings['city_country'] ?>">
                                </div>
                                <div class="form-group form-md-line-input">
                                	<label class="form-control-label">* Контактый номер</label>
                                    <input type="text" class="form-control" id="phone" name="phone" placeholder="Введите номер" value="<?php echo $settings['phone'] ?>">
                                </div>
							</div>
							<hr>
							<button type="submit" class="btn btn-brand m-btn m-btn--air btn-outline  btn-block sbold uppercase">Применить настройки</button>
						</div>
						</form>
				    </div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
      $('#settings').ajaxForm({ 
        url: '/admin/settings/ajax',
        dataType: 'text',
        success: function(data) {
          //console.log(data);
          data = $.parseJSON(data);
          switch(data.status) {
            case 'error':
              toastr.error(data.error);
              $('button[type=submit]').prop('disabled', false);
              break;
            case 'success':
              toastr.success(data.success);
              setTimeout("redirect('/admin/settings/index')", 3000);
              break;
          }
        },
        beforeSubmit: function(arr, $form, options) {
          $('button[type=submit]').prop('disabled', true);
        }
      });
</script>
<?php echo $footer ?>