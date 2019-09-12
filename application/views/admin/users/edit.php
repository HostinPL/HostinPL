<?php
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
?>
<?php echo $admheader ?>
<div class="m-content">
    <div class="row">
        <div class="col-xl-3 col-lg-4">
            <div class="m-portlet m-portlet--full-height   m-portlet--unair">
                <div class="m-portlet__body">
                    <div class="m-card-profile">
                        <div class="m-card-profile__title m--hide"></div>
                        <div class="m-card-profile__pic">
                            <div class="m-card-profile__pic-wrapper">
                                <img src="<?if($item['user_img']) {echo $item['user_img'];}else{ echo '/application/public/img/user.png';}?>" alt="">
                            </div>
                        </div>
                        <div class="m-card-profile__details">
                            <span class="m-card-profile__name"><?php echo $user['user_firstname'] ?> <?php echo $user['user_lastname'] ?></span>
                            <a href="#" class="m-card-profile__email m-link"><?php if($user['user_access_level'] == 3): ?> Администратор <?php elseif($user['user_access_level'] == 2): ?> Тех.Поддержка <?php elseif($user['user_access_level'] == 1): ?> Клиент <?php elseif($user['user_access_level'] == 0): ?> Демонстрация <?php endif; ?>
                            </a>                     
                        </div>
                    </div>  
                    <ul class="m-nav m-nav--hover-bg m-portlet-fit--sides">
                        <li class="m-nav__separator m-nav__separator--fit"></li>
                        <li class="m-nav__section m--hide">
                            <span class="m-nav__section-text"></span>
                        </li>
                        <li class="m-nav__item">
                            <a href="/admin/servers/index?userid=<?php echo $user['user_id'] ?>" class="m-nav__link">
                                <i class="m-nav__link-icon fa flaticon-puzzle"></i>
                                <span class="m-nav__link-text">Сервера пользователя</span>
                            </a>
                        </li>
                        <li class="m-nav__item">
                            <a href="/admin/tickets/index?userid=<?php echo $user['user_id'] ?>" class="m-nav__link">
                                <i class="m-nav__link-icon fa flaticon-computer"></i>
                                <span class="m-nav__link-text">Запросы пользователя</span>
                            </a>
                        </li>
                        <li class="m-nav__item">
                            <a href="/admin/invoices/index?userid=<?php echo $user['user_id'] ?>" class="m-nav__link">
                                <i class="m-nav__link-icon fa flaticon-coins"></i>
                                <span class="m-nav__link-text">Платежи пользователя</span>
                            </a>
                        </li>
                        <li class="m-nav__item">
                            <a href="#javasctipt" data-toggle="modal" data-target="#authloghostinpl" class="m-nav__link">
                                <i class="m-nav__link-icon fa flaticon-placeholder"></i>
                                <span class="m-nav__link-text">Логи авторизации</span>
                            </a>
                        </li>
                        <?php if($user_access_level == 3):?>
                        <li class="m-nav__item">
                            <a href="/admin/users/edit/delete/<?php echo $user['user_id'] ?>" class="m-nav__link">
                                <i class="m-nav__link-icon fa flaticon-delete-2"></i>
                                <span class="m-nav__link-text">Удалить пользователя</span>
                            </a>
                        </li>
                        <?php endif; ?>
                    </ul>
               </div>           
            </div>  
        </div>
        <div class="col-xl-9 col-lg-8">
            <div class="m-portlet m-portlet--full-height m-portlet--tabs   m-portlet--unair">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">Зарегистрированный пользователь</h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body" style="padding-top: 10px;">
                <form class="form-group form-md-line-input" action="#" id="editForm" method="POST">
                    <div class="form-group form-md-line-input">
                        <input type="text" class="form-control" id="firstname" name="firstname" placeholder="<?php echo $user['user_lastname'] ?>" value="<?php echo $user['user_lastname'] ?>">
                    </div>
                    <div class="form-group form-md-line-input">
                        <input type="text" class="form-control" id="lastname" name="lastname" placeholder="<?php echo $user['user_firstname'] ?>" value="<?php echo $user['user_firstname'] ?>">
                    </div>
                    <div class="form-group form-md-line-input">
                        <input type="text" class="form-control" id="email" name="email" placeholder="<?php echo $user['user_email'] ?>" value="<?php echo $user['user_email'] ?>">
                    </div>
                    <div class="form-group form-md-line-input">
                        <select class="form-control" id="status" name="status" aria-required="true" aria-invalid="false" aria-describedby="delivery-error">
                            <option value="1" <?php if($user['user_status'] == 1): ?> selected="selected"<?php endif; ?>>Разблокирован</option>
                            <option value="0" <?php if($user['user_status'] == 0): ?> selected="selected"<?php endif; ?>>Заблокирован</option>
                        </select>
                    </div>
                    <div class="form-group form-md-line-input">
                        <select class="form-control" id="accesslevel" name="accesslevel" aria-required="true" aria-invalid="false" aria-describedby="delivery-error">
                            <option value="0" <?php if($user['user_access_level'] == 0): ?> selected="selected"<?php endif; ?>>Демонстрация</option>
                            <option value="1" <?php if($user['user_access_level'] == 1): ?> selected="selected"<?php endif; ?>>Клиент</option>
                            <option value="2" <?php if($user['user_access_level'] == 2): ?> selected="selected"<?php endif; ?>>Техническая поддержка</option>
                            <option value="3" <?php if($user['user_access_level'] == 3): ?> selected="selected"<?php endif; ?>>Администрация</option>
                        </select>
                    </div>
                    <div class="form-group form-md-line-input">
                        <input type="text" class="form-control" id="balance" name="balance" placeholder="Баланс" value="<?php echo $user['user_balance'] ?>">
                    </div>
                    <div class="form-group form-md-line-input">
                        <input type="text" class="form-control" id="vk_id" name="vk_id" placeholder="ID VK" value="<?php echo $user['user_vk_id'] ?>">
                    </div>
                    <div class="form-group form-md-line-input">
                        <select class="form-control" id="test_server" name="test_server" aria-required="true" aria-invalid="false" aria-describedby="delivery-error">
                            <option value="1" <?php if($user['test_server'] == 1): ?> selected="selected"<?php endif; ?>>Тестовый период разрешен</option>
                            <option value="2" <?php if($user['test_server'] == 2): ?> selected="selected"<?php endif; ?>>Тестовый период запрещен</option>
                        </select>
                    </div>
                    <div class="form-group form-md-line-input">
                        <select class="form-control" id="user_activate" name="user_activate" aria-required="true" aria-invalid="false" aria-describedby="delivery-error">
                            <option value="1" <?php if($user['user_activate'] == 1): ?> selected="selected"<?php endif; ?>>Аккаунт подтвержден</option>
                            <option value="0" <?php if($user['user_activate'] == 0): ?> selected="selected"<?php endif; ?>>Аккаунт неактивирован</option>
                        </select>
                    </div>
                    <?php if($user_access_level == 3):?>
                    <hr>
                    <div class="m-form__group form-group">
                        <label class="m-checkbox m-checkbox--bold m-checkbox--state-brand">
                            <input type="checkbox" class="md-check" id="editpassword" name="editpassword" onChange="togglePassword()"> Изменить пароль
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
                    <button type="submit" class="btn btn-brand m-btn m-btn--air btn-outline  btn-block sbold uppercase">Сохранить изменения</button>
                    <?php endif; ?>  
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!--begin::Modal-->
<div class="modal fade" id="authloghostinpl" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Логи авторизации</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
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
                            <td><?php if($item['status'] == 0): ?> 
                                <span class="badge badge-sm label-danger">Ошибка входа (пароль <?php echo $item['password'] ?>)</span>
                                <?php elseif($item['status'] == 1): ?> 
                                <span class="badge badge-sm label-success">Вход в систему</span>
                                <?php elseif($item['status'] == 2): ?> 
                                <span class="badge badge-sm label-warning">Выход из системы</span>
                                <?php elseif($item['status'] == 3): ?> 
                                <span class="badge badge-sm label-warning">Попытка востановленя пароля</span>
                                <?php elseif($item['status'] == 4): ?> 
                                <span class="badge badge-sm label-success">Вход через VK</span>
                                <?php elseif($item['status'] == 5): ?> 
                                <span class="badge badge-sm label-success">Ошибка входа через VK</span>
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

<!--end::Modal-->
<script>
	$('#editForm').ajaxForm({ 
		url: '/admin/users/edit/ajax/<?php echo $user['user_id'] ?>',
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
					setTimeout("reload()", 1100);
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