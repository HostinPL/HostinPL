<?php
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
?>
<?php echo $header ?>
<style>
.m-btn--icon.m-btn--icon-only {
  width: 23px;
  height: 23px;
}
.m-btn--icon.m-btn--icon-only [class^="flaticon-"], .m-btn--icon.m-btn--icon-only [class*=" flaticon-"] {
  font-size: 1.1rem;
}
</style>
<div class="m-content">
	<div class="row">
		<div class="col-xl-3 col-lg-4">
			<div class="m-portlet m-portlet--full-height  ">
				<div class="m-portlet__body">
					<div class="m-card-profile">
						<div class="m-card-profile__title m--hide"></div>
							<div class="m-card-profile__pic">
								<div class="m-card-profile__pic-wrapper">
									<img src="<?php echo $url ?><?php echo $user_img ?>" alt="">
								</div>
							</div>
							<div class="m-card-profile__details">
								<span class="m-card-profile__name"><?php echo $user_firstname ?> <?php echo $user_lastname ?><br> <span class="m-widget1__number m--font-brand">ID <?=$_SESSION['user_id']?></span></span>
								<a href="/account/invoices" class="m-card-profile__email m-link">Баланс <?php echo $user_balance ?> Руб.</a><br>
								<a href="#javascript" class="m-card-profile__email m-link">Вы с нами: <?php echo $user_date_reg ?>  <?php echo $user_date ?></a>
								<hr>
                                <div class="form-group form-md-line-input">
                                    <input type="text" class="form-control" id="reffi" placeholder="http://<?echo $_SERVER['SERVER_NAME']?>/account/login?ref=<?=$_SESSION['user_id']?>" value="http://<?echo $_SERVER['SERVER_NAME']?>/account/login?ref=<?=$_SESSION['user_id']?>">
                                    <label for="text">Ваша реферальная ссылка</label>
                                </div>
							</div>
						</div>
						<ul class="m-nav m-nav--hover-bg m-portlet-fit--sides">
							<li class="m-nav__separator m-nav__separator--fit"></li>
							<li class="m-nav__section m--hide">
							    <span class="m-nav__section-text"></span>
							</li>
							<li class="m-nav__item">
								<a href="#javascript" onclick="VK.Auth.login(authInfo); return false;" class="m-nav__link">
									<i class="m-nav__link-icon socicon-vkontakte"></i>
									<span class="m-nav__link-title">
										<span class="m-nav__link-wrap">
											<span class="m-nav__link-text">Привязать VK</span>
												<span class="m-nav__link-badge">
											</span>
										</span>
									</span>
								</a>
							</li>
							<li class="m-nav__item">
								<a href="#javascript" data-toggle="modal" data-target="#loadhostin" class="m-nav__link">
									<i class="m-nav__link-icon fa fa-download"></i>
									<span class="m-nav__link-title">
										<span class="m-nav__link-wrap">
											<span class="m-nav__link-text">Загрузить аватар</span>
												<span class="m-nav__link-badge">
											</span>
										</span>
									</span>
								</a>
							</li>
						</ul>
						<div class="m-portlet__body-separator"></div>
							<div class="m-widget1 m-widget1--paddingless">
								<div class="m-widget1__item">
									<div class="row m-row--no-padding align-items-center">
										<div class="col">
											<h3 class="m-widget1__title">Серверов</h3>
										</div>
										<div class="col m--align-right">
											<span class="m-widget1__number m--font-brand"><?$serverov = 0;
                                                foreach($servers as $item): ?>
                                                <? $serverov++; ?>
                                                <?endforeach;echo $serverov; ?>
                                            </span>
										</div>
									</div>
								</div>
								<div class="m-widget1__item">
									<div class="row m-row--no-padding align-items-center">
										<div class="col">
											<h3 class="m-widget1__title">Тикетов</h3>
										</div>
										<div class="col m--align-right">
											<span class="m-widget1__number m--font-danger"><?$ticketov = 0;
                                                foreach($tickets as $item): ?>
                                                <? $ticketov++; ?>
                                                <?endforeach;echo $ticketov; ?>
                                            </span>
										</div>
									</div>
								</div>
								<div class="m-widget1__item">
									<div class="row m-row--no-padding align-items-center">
										<div class="col">
											<h3 class="m-widget1__title">Баллов</h3>
										</div>
										<div class="col m--align-right">
											<span class="m-widget1__number m--font-success"><?echo $users['rmoney']?></span>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-9 col-lg-8">
					<div class="m-portlet m-portlet--full-height m-portlet--tabs  ">
						<div class="m-portlet__head">
							<div class="m-portlet__head-tools">
								<ul class="nav nav-tabs m-tabs m-tabs-line   m-tabs-line--left m-tabs-line--primary" role="tablist">
									<li class="nav-item m-tabs__item">
										<a class="nav-link m-tabs__link active show" data-toggle="tab" href="#m_user_profile_tab_1" role="tab" aria-selected="true">
										    <i class="flaticon-share m--hide"></i>Профиль
										</a>
									</li>
									<li class="nav-item m-tabs__item">
										<a class="nav-link m-tabs__link" data-toggle="tab" href="#m_user_profile_tab_2" role="tab" aria-selected="false">
											Партнерская программа
										</a>
									</li>
									<li class="nav-item m-tabs__item">
										<a class="nav-link m-tabs__link" data-toggle="tab" href="#m_user_profile_tab_3" role="tab" aria-selected="false">
											Операции счета
										</a>
									</li>
									<li class="nav-item m-tabs__item">
										<a class="nav-link m-tabs__link" data-toggle="tab" href="#m_user_profile_tab_4" role="tab" aria-selected="false">
											Логи авторизации
										</a>
									</li>
									<li class="nav-item m-tabs__item">
										<a class="nav-link m-tabs__link" data-toggle="tab" href="#m_user_profile_tab_5" role="tab" aria-selected="false">
											Обещанный платёж
										</a>
									</li>
								</ul>
							</div>
						</div>
						<div class="tab-content">
							<div class="tab-pane active show" id="m_user_profile_tab_1">
								<form class="m-form m-form--label-align-left- m-form--state-" action="#" id="editForm" method="POST">
									<div class="m-portlet__body">
										<div class="form-group m-form__group row">
											<label for="example-text-input" class="col-2 col-form-label">Ваше Имя</label>
											<div class="col-7">
											    <input class="form-control m-input" id="firstname" name="firstname" placeholder="Введите ваше имя" value="<?php echo $user['firstname'] ?>">
											</div>
										</div>
										<div class="form-group m-form__group row">
											<label for="example-text-input" class="col-2 col-form-label">Ваша Фамилия</label>
											<div class="col-7">
											    <input class="form-control m-input" id="lastname" name="lastname" placeholder="Введите вашу фамилию" value="<?php echo $user['lastname'] ?>">
											</div>
										</div>
										<div class="form-group m-form__group row">
											<label for="example-text-input" class="col-2 col-form-label">Ваш E-mail</label>
											<div class="col-7">
											    <input class="form-control m-input" id="user_email" name="user_email" placeholder="Введите ваш E-mail" value="<?php echo $user['user_email'] ?>">
											</div>
										</div>
										<div class="form-group m-form__group row">
											<label for="example-text-input" class="col-2 col-form-label">Ваш ID ВКонтакте</label>
											<div class="col-7">
											    <input class="form-control m-input" id="user_vk_id" name="user_vk_id" placeholder="Прекрепите свой VK" value="<?php echo $users['user_vk_id'] ?>" disabled>
											</div>
										</div>
										<div class="m-form__group form-group row">
											<label class="col-2 col-form-label">Сменить пароль</label>
											<div class="col-1">
												<span class="m-switch m-switch--sm m-switch--icon">
													<label>
														<input type="checkbox" id="editpassword" name="editpassword" onChange="togglePassword()">
														<span></span>
													</label>
												</span>
											</div>
										</div>
										<div class="form-group m-form__group row">
											<label for="example-text-input" class="col-2 col-form-label">Пароль</label>
											<div class="col-7">
											    <input class="form-control m-input" id="password" name="password" placeholder="Пароль" disabled>
											</div>
										</div>
										<div class="form-group m-form__group row">
											<label for="example-text-input" class="col-2 col-form-label">Повторите пароль</label>
											<div class="col-7">
											    <input class="form-control m-input" id="password2" name="password2" placeholder="Повторите пароль" disabled>
											</div>
										</div>
									</div>
									<div class="m-portlet__foot m-portlet__foot--fit">
										<div class="m-form__actions">
											<div class="row">
												<div class="col-2"></div>
												<div class="col-7">
													<center><button type="submit" class="btn btn-accent m-btn m-btn--air m-btn--custom">Сохранить</button></center>
												</div>
											</div>
										</div>
									</div>
                                </form>
							</div>
						<div class="tab-pane" id="m_user_profile_tab_2">
							<div class="m-section">
			                    <div class="m-section__content">
							        <div class="m-section__content">
									    <table class="table table-striped m-table">
										    <thead>
										        <tr>
											        <th><i class="flaticon-list"></i></th>
											        <th><i class="flaticon-profile-1"></i> Имя</th>
											        <th><i class="flaticon-profile-1"></i> Фамилия</th>
											        <th><i class="flaticon-notes"></i> Заработал</th>
										        </tr>
										    </thead>
										    <tbody>
										    <?php foreach($userg as $item):?>
										        <? if (!($item['ref'] == $_SESSION['user_id'])) { // пропуск нечетных чисел
										        continue;
										    }?>
										    </tbody>
										    <tr>
											    <td><?php echo $item['user_id'] ?></td>
											    <td><?php echo $item['user_firstname'] ?></td>
											    <td><?php echo $item['user_lastname'] ?></td>
											    <td><?php echo $item['rmoney'] ?></td>
										    </tr>
										    <?php endforeach; ?>
										    <?$ust = 0;
										    foreach($userg as $item): ?>
										    <? if (!($item['ref'] == $_SESSION['user_id'])) { // пропуск нечетных чисел
										    continue;
										    }?>
										    <? $ust++; ?>
										    <?endforeach; ?>
										    <?php if(empty($ust)): ?> 
										    <tr>
											    <td colspan="8" style="text-align: center;">У вас нет рефералов.</td>
										    </tr>
										    <?php endif; ?> 
									    </table>
								    </div>
							    </div>
						    </div>
						</div>
						<div class="tab-pane" id="m_user_profile_tab_3">
							<div class="m-section">
			                    <div class="m-section__content">
							        <div class="m-section__content">
									    <table class="table table-striped m-table">
										    <thead>
									            <tr class="uppercase">
										            <th><i class="flaticon-information"></i> Операция</th>
										            <th><i class="flaticon-calendar-1"></i> Дата</th>
										            <th><i class="flaticon-coins"></i> Сумма</th>
									            </tr>
									        </thead>
									        <tbody>
									        <?php foreach($waste as $item): ?> 
									            <tr>
	                                                <td><?php echo $item['waste_usluga'] ?></td>
	                                                <td><?php echo date("d.m.Y в H:i", strtotime($item['waste_date_add'])) ?></td>
	                                                <?php if($item['waste_status'] == 1): ?> 
                                                    <td><span class="label label-danger">- <?php echo $item['waste_ammount'] ?> руб</span></td>
                                                    <?php endif; ?> 
                                                    <?php if($item['waste_status'] == 0): ?> 
                                                    <td><span class="label label-success">+ <?php echo $item['waste_ammount'] ?> руб</span></td>
                                                    <?php endif; ?> 
                                                </tr>
                                            <?php endforeach; ?>
                                            <?php if(empty($waste)): ?> 
						                        <tr>
							                        <td colspan="8" style="text-align: center;">На данный момент у вас нет операций со счетом.</td>
						                        <tr>
						                    <?php endif; ?> 
									        </tbody>
									    </table>
								    </div>
							    </div>
						    </div>
						</div>
						<div class="tab-pane" id="m_user_profile_tab_4">
							<div class="m-section">
			                    <div class="m-section__content">
							        <div class="m-section__content">
									    <table class="table table-striped m-table">
										    <thead>
                                                <tr>
                                                    <th><i class="flaticon-placeholder"></i> Город</th>
                                                    <th><i class="flaticon-map-location"></i> Страна</th>
							                        <th><i class="flaticon-calendar-2"></i> Дата / Время</th>
                                                    <th><i class="flaticon-user"></i> IP</th>
								                    <th><i class="flaticon-music-1"></i> Действие</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                        	                    <?php foreach($visitors as $item):?>
                                                <tr>
                                                    <td><?php echo $item['city'] ?></td>
                                                    <td><?php echo $item['country'] ?>(<?php echo $item['code'] ?>)</td>
							                        <td><?php echo date("d.m.Y в H:i", strtotime($item['datetime'])) ?></td>
								                    <td><?php echo $item['ip'] ?></td>
                                                    <td>
								                    <?php if($item['status'] == 0): ?>
								                    Ошибка входа (пароль <?php echo $item['password'] ?>)
								                    <?php elseif($item['status'] == 1): ?> 
								                    Вход в систему
								                    <?php elseif($item['status'] == 2): ?> 
								                    Выход из системы
								                    <?php elseif($item['status'] == 3): ?> 
								                    Попытка востановленя пароля
								                    <?php endif; ?>	
								                    </td>
                                                </tr>
                                                <?php endforeach; ?>
                                            </tbody>
									    </table>
								    </div>
							    </div>
						    </div>
						</div>
						<div class="tab-pane" id="m_user_profile_tab_5">
							<div class="m-section">
			                    <div class="m-section__content">
							        <div class="m-section__content">
									    <table class="table table-striped m-table">
										    <thead>
											    <tr class="uppercase">
												    <th><i class="flaticon-list"></i></th>
												    <th><i class="flaticon-puzzle"></i> Игра</th>
												    <th><i class="flaticon-multimedia"></i></th>
											    </tr>
										    </thead>
										    <tbody>
										        <?php foreach($gameservers as $item):?>
											    <tr>
												    <td><?php echo $item['server_id'] ?></td>
												    <td><?php echo $item['game_name'] ?></td>
												    <td>
												    	<a onClick="sendAction('promised','gameserver',<?php echo $item['server_id'] ?>)"  data-container="body" data-toggle="m-popover" data-placement="top" data-content="Активировать услугу" data-original-title="" title="" class="btn btn-outline-brand m-btn m-btn--icon m-btn--icon-only"><i class="flaticon-piggy-bank"></i></a>
												    <td>
											    </tr>
										        <?php endforeach; ?>
										        <?php if(empty($gameservers)): ?> 
											    <tr>
												    <td colspan="8" style="text-align: center;">У вас нет неоплаченных серверов.</td>
											    <tr>
										        <?php endif; ?> 
										    </tbody>
									    </table>
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
<!--begin::Modal-->
<div class="modal fade" id="loadhostin" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Загрузка аватара</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form action="#" id="imgForm" method="POST">
				<div class="tab-content">
					<div class="tab-pane active show" id="m_quick_sidebar_tabs_messenger" role="tabpanel">
						<div class="m-messenger m-messenger--message-arrow m-messenger--skin-light">
							<div class="m-messenger__form">
								<div class="m-messenger__form-controls">
									<input id="file" name="userfile" type="file" class="m-messenger__form-input">
								</div>
								<div class="m-messenger__form-tools">
									<button  tabindex="500" name='submit' type="submit" class="m-messenger__form-attachment">
										<i class="la la-paperclip"></i>
									</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>
            </div>
        </div>
    </div>
</div>
<script src="//vk.com/js/api/openapi.js" type="text/javascript"></script>
<script>
	function sendAction(action, metod, serverid) {
		switch(action) {
			case "promised":
			{
				if(!confirm("Вы действительно хотите активировать обещанный платёж на данный сервер ? С вашего счёта будет списано 15 руб!")) return;
				break;
			}
		}
		$.ajax({ 
			url: '/main/acc/action/'+action+'/'+metod+'/'+serverid,
			dataType: 'text',
			success: function(data) {
				data = $.parseJSON(data);
				switch(data.status) {
					case 'error':
						toastr.error(data.error);
						break;
					case 'success':
						toastr.success(data.success);
						break;
				}
			}
		});
	}

	 VK.init({
		apiId: <?php echo $vk_id ?>
	});
	function authInfo(response) {
		if(response.session) {
			$.ajax({ 
				url: "/main/acc/vk",
				type: "POST",
				data: {auth: true, response: response},
				success: function (data) {
					data = $.parseJSON(data);
					switch(data.status) {
						case 'error':								
							toastr.error(data.error);									
						break;
						case 'success':
							toastr.success(data.success);
						break;
						case 'info':
							toastr.info(data.info);
						break;
					}
				}
			});
		}
	}
	$('#editForm').ajaxForm({ 
		url: '/main/acc/ajax',
		dataType: 'text',
		success: function(data) {
			console.log(data);
			data = $.parseJSON(data);
			switch(data.status) {
				case 'error':
					toastr.error(data.error);
					break;
				case 'success':
					toastr.success(data.success);
					break;
			}
			$('button[type=submit]').prop('disabled', false);
		},
		beforeSubmit: function(arr, $form, options) {
			$('button[type=submit]').prop('disabled', true);
		}
	});
	$('#imgForm').ajaxForm({ 
		url: '/main/acc/img',
		dataType: 'text',
		success: function(data) {
			data = $.parseJSON(data);
			switch(data.status) {
				case 'error':
					toastr.error(data.error);
					break;
				case 'success':
					toastr.success(data.success);
					setTimeout("reload()", 1500);
					break;
			}
			$('button[type=submit]').prop('disabled', false);
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
