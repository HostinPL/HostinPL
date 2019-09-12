<?php
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
?>
<?php echo $admheader ?>
<style>
.profile-nav ul > li {
  border-bottom: 1px solid #ebeae6;
  margin-top: 0;
  line-height: 30px;
}
</style>
<div class="m-content">
	<div class="row">
	    <div class="col-xl-3 col-lg-4">
		    <div class="m-portlet m-portlet--full-height   m-portlet--unair">
			    <div class="m-portlet__body">
				    <div class="m-card-profile">
					    <div class="m-card-profile__title m--hide"></div>
					    <div class="m-card-profile__pic">
						    <div class="m-card-profile__pic-wrapper">
						        <?php if($server['server_status'] == 1): ?>
							    <img src="/application/public/img/power.png" alt="">
							    <?php elseif($server['server_status'] == 2): ?>
							    <img src="/application/public/img/gamecontroller.png" alt="">
							    <?php elseif($server['server_status'] == 3): ?>
							    <img src="/application/public/img/loading.png" alt="">
							    <?php elseif($server['server_status'] == 4): ?>
							    <img src="/application/public/img/loading.png" alt="">
							    <?php elseif($server['server_status'] == 0): ?>
							    <img src="/application/public/img/locked1.png" alt="">
							    <?php elseif($server['server_status'] == 7): ?>
							    <img src="/application/public/img/hourglass.png" alt="">
							    <?php endif; ?>
						    </div>
					    </div>
					    <div class="m-card-profile__details">
						    <span class="m-card-profile__name"><?php echo $server['game_name'] ?></span>
						    <?php if($server['server_status'] == 1): ?>
						    <a href="#javasctipt" class="m-card-profile__email m-link">Выключен</a>
						    <?php elseif($server['server_status'] == 2): ?>
						    <a href="#javasctipt" class="m-card-profile__email m-link">Включен</a>
					        <?php elseif($server['server_status'] == 3): ?>
					        <a href="#javasctipt" class="m-card-profile__email m-link">Устанавливается</a>
					        <?php elseif($server['server_status'] == 4): ?>
					        <a href="#javasctipt" class="m-card-profile__email m-link">Переустанавливается</a>
					        <?php elseif($server['server_status'] == 0): ?>
					        <a href="#javasctipt" class="m-card-profile__email m-link">Заблокирован</a>
						    <?php elseif($server['server_status'] == 7): ?>
						    <a href="#javasctipt" class="m-card-profile__email m-link">Обновляется</a>
						    <?php endif; ?>
					    </div>
				    </div>	
				    <ul class="m-nav m-nav--hover-bg m-portlet-fit--sides">
					    <li class="m-nav__separator m-nav__separator--fit"></li>
					    <li class="m-nav__section m--hide">
						    <span class="m-nav__section-text"></span>
					    </li>
					    <?php if($server['server_status'] == 1): ?>
					    <li class="m-nav__item">
						    <a href="#javasctipt" onClick="actionserver(<?php echo $server['server_id'] ?>,'start')" class="m-nav__link">
						        <i class="m-nav__link-icon fa fa-power-off"></i>
							    <span class="m-nav__link-text">Включить сервер</span>
						    </a>
					    </li>
					    <li class="m-nav__item">
						    <a href="#javasctipt" onClick="actionserver(<?php echo $server['server_id'] ?>,'reinstall')" class="m-nav__link">
							    <i class="m-nav__link-icon fa fa-broom"></i>
							    <span class="m-nav__link-text">Переустановить сервер</span>
						    </a>
					    </li>
					    <li class="m-nav__item">
						    <a href="#javasctipt" onClick="actionserver(<?php echo $server['server_id'] ?>,'block')" class="m-nav__link">
							    <i class="m-nav__link-icon fa fa-lock"></i>
							    <span class="m-nav__link-text">Блокировать</span>
						    </a>
					    </li>
					    <?php elseif($server['server_status'] == 2): ?>
					    <li class="m-nav__item">
						    <a href="#javasctipt" onClick="actionserver(<?php echo $server['server_id'] ?>,'stop')" class="m-nav__link">
							    <i class="m-nav__link-icon fa fa-power-off"></i>
							    <span class="m-nav__link-text">Выключить сервер</span>
						    </a>
					    </li>
					    <li class="m-nav__item">
						    <a href="#javasctipt" onClick="actionserver(<?php echo $server['server_id'] ?>,'restart')" class="m-nav__link">
							    <i class="m-nav__link-icon fa fa-sync-alt"></i>
							    <span class="m-nav__link-text">Перезапустить сервер</span>
						    </a>
					    </li>
					    <?php elseif($server['server_status'] == 0): ?>
					    <li class="m-nav__item">
						    <a href="#javasctipt" onClick="actionserver(<?php echo $server['server_id'] ?>,'unblock')" class="m-nav__link">
							    <i class="m-nav__link-icon fa fa-unlock"></i>
							    <span class="m-nav__link-text">Разблокировать</span>
						    </a>
					    </li>
					    <li class="m-nav__item">
						    <a href="#javasctipt" onClick="actionserver(<?php echo $server['server_id'] ?>,'delete')" class="m-nav__link">
							    <i class="m-nav__link-icon flaticon-delete-2"></i>
							    <span class="m-nav__link-text">Удалить сервер</span>
						    </a>
					    </li>
					    <?php elseif($server['server_status'] == 3): ?>
					    <li class="m-nav__item">
						    <a href="#javasctipt" onClick="actionserver(<?php echo $server['server_id'] ?>,'block')" class="m-nav__link">
							    <i class="m-nav__link-icon fa fa-lock"></i>
							    <span class="m-nav__link-text">Блокировать</span>
						    </a>
					    </li>
					    <?php elseif($server['server_status'] == 4): ?>
					    <li class="m-nav__item">
						    <a href="#javasctipt" onClick="actionserver(<?php echo $server['server_id'] ?>,'block')" class="m-nav__link">
							    <i class="m-nav__link-icon fa fa-lock"></i>
							    <span class="m-nav__link-text">Блокировать</span>
						    </a>
					    </li>
					    <?php elseif($server['server_status'] == 7): ?>
					    <li class="m-nav__item">
						    <a href="#javasctipt" onClick="actionserver(<?php echo $server['server_id'] ?>,'block')" class="m-nav__link">
							    <i class="m-nav__link-icon fa fa-lock"></i>
							    <span class="m-nav__link-text">Блокировать</span>
						    </a>
					    </li>
					    <?php endif; ?>
				    </ul>
				    <div class="m-portlet__body-separator"></div>
				    <div class="m-widget1 m-widget1--paddingless">
					    <div class="m-widget1__item">
						    <div class="row m-row--no-padding align-items-center">
							    <div class="col">
								    <h3 class="m-widget1__title">CPU:</h3>
							    </div>
							    <div class="col m--align-right">
								    <span class="m-widget1__number m--font-brand"><?php echo $server['server_cpu_load'] ?>%</span>
							    </div>
						    </div>
					    </div>
					    <div class="m-widget1__item">
						    <div class="row m-row--no-padding align-items-center">
							    <div class="col">
								    <h3 class="m-widget1__title">RAM:</h3>
							    </div>
							    <div class="col m--align-right">
								    <span class="m-widget1__number m--font-danger"><?php echo $server['server_ram_load'] ?>%</span>
							    </div>
						    </div>
					    </div>
				    </div>
			   </div>			
		    </div>	
	    </div>
	    <div class="col-xl-9 col-lg-8">
		    <div class="m-portlet m-portlet--full-height m-portlet--tabs   m-portlet--unair">
			    <div class="m-portlet__head">
				    <div class="m-portlet__head-caption">
			            <div class="m-portlet__head-title">
				            <h3 class="m-portlet__head-text">Информация о сервере</h3>
			            </div>
		            </div>
			    </div>
			    <div class="m-widget1">
				    <div class="m-widget1__item">
					    <div class="row m-row--no-padding align-items-center">
						    <div class="col">
							    <h3 class="m-widget1__title">IP адрес</h3>
							    <span class="m-widget1__desc"><?php echo $server['location_ip'] ?>:<?php echo $server['server_port'] ?></span>
						    </div>
					    </div>
				    </div>
				    <?php if($server['server_status'] == 2): ?>
				    <div class="m-widget1__item">
				        <div class="row m-row--no-padding align-items-center">
						    <div class="col">
							    <h3 class="m-widget1__title">Игровой режим</h3>
							    <span class="m-widget1__desc"><?php echo $query['gamemode'] ?></span>
						    </div>
					    </div>
				    </div>
				    <div class="m-widget1__item">
					    <div class="row m-row--no-padding align-items-center">
						    <div class="col">
							    <h3 class="m-widget1__title">Название</h3>
							    <span class="m-widget1__desc"><?php echo $query['hostname'] ?></span>
						    </div>
					    </div>
				    </div>
				    <div class="m-widget1__item">
					    <div class="row m-row--no-padding align-items-center">
						    <div class="col">
							    <h3 class="m-widget1__title">Карта</h3>
							    <span class="m-widget1__desc"><?php if($server['game_code'] == 'samp') { echo 'San Andreas';} else {echo $query['mapname']; }?><?php if($server['game_query'] == "valve"): ?><?php endif; ?></span>
						    </div>
					    </div>
				    </div>
				    <div class="m-widget1__item">
					    <div class="row m-row--no-padding align-items-center">
						    <div class="col">
							    <h3 class="m-widget1__title">Игроков</h3>
							    <span class="m-widget1__desc"><?php echo $query['players'] ?>/<?php echo $query['maxplayers'] ?></span>
						    </div>
					    </div>
				    </div>
				    <?php endif; ?>
				    <div class="m-widget1__item">
					    <div class="row m-row--no-padding align-items-center">
						    <div class="col">
							    <h3 class="m-widget1__title">Слоты</h3>
							    <span class="m-widget1__desc"><?php echo $server['server_slots'] ?></span>
						    </div>
					    </div>
				    </div>
				    <div class="m-widget1__item">
					    <div class="row m-row--no-padding align-items-center">
						    <div class="col">
							    <h3 class="m-widget1__title">Оплачен до</h3>
							    <span class="m-widget1__desc"><?php echo date("d.m.Y", strtotime($server['server_date_end'])) ?></span>
						    </div>
					    </div>
				    </div>
				    <div class="m-widget1__item">
					    <div class="row m-row--no-padding align-items-center">
						    <div class="col">
							    <h3 class="m-widget1__title">Локация</h3>
							    <span class="m-widget1__desc"><?php echo $server['location_name'] ?></span>
						    </div>
					    </div>
				    </div>
				    <div class="m-widget1__item">
					    <div class="row m-row--no-padding align-items-center">
						    <div class="col">
							    <h3 class="m-widget1__title">Клиент</h3>
							    <a href="/admin/users/edit/index/<?php echo $server['user_id'] ?>"><span class="m-widget1__desc"><?php echo $server['user_firstname'];?></span></a>
						    </div>
					    </div>
				    </div>
			    </div>
		    </div>
	    </div>
	    <div class="col-6">
	        <div class="m-portlet__body">
			    <div class="m-section">
                    <div class="m-portlet">
	                    <div class="m-portlet__head">
		                    <div class="m-portlet__head-caption">
			                    <div class="m-portlet__head-title">
				                    <h3 class="m-portlet__head-text">Данные FTP</h3>
			                    </div>
		                    </div>	
	                    </div>
	                    <div class="m-widget1" style="padding-top: 0px;">
				            <div class="m-widget1__item">
					            <div class="row m-row--no-padding align-items-center">
						            <div class="col">
							            <h3 class="m-widget1__title">IP</h3>
							            <span class="m-widget1__desc"><?php echo $server['location_ip'] ?></span>
						            </div>
					            </div>
				            </div>
				            <div class="m-widget1__item">
					            <div class="row m-row--no-padding align-items-center">
						            <div class="col">
							            <h3 class="m-widget1__title">FTP Порт</h3>
							            <span class="m-widget1__desc">21</span>
						            </div>
					            </div>
				            </div>
				            <div class="m-widget1__item">
					            <div class="row m-row--no-padding align-items-center">
						            <div class="col">
							            <h3 class="m-widget1__title">Логин</h3>
							            <span class="m-widget1__desc">gs<?php echo $server['server_id'] ?></span>
						            </div>
					            </div>
				            </div>
				            <div class="m-widget1__item">
					            <div class="row m-row--no-padding align-items-center">
						            <div class="col">
							            <h3 class="m-widget1__title">Пароль</h3>
							            <span class="m-widget1__desc"><?php echo $server['server_password'] ?></span>
						            </div>
					            </div>
				            </div>
				        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6">
	        <div class="m-portlet__body">
			    <div class="m-section">
                    <div class="m-portlet">
	                    <div class="m-portlet__head">
		                    <div class="m-portlet__head-caption">
			                    <div class="m-portlet__head-title">
				                    <h3 class="m-portlet__head-text">Данные MySQL</h3>
			                    </div>
		                    </div>	
	                    </div>
	                    <div class="m-widget1" style="padding-top: 0px;">
	                    	<?if($server['server_mysql'] == 1):?>
				            <div class="m-widget1__item">
					            <div class="row m-row--no-padding align-items-center">
						            <div class="col">
							            <h3 class="m-widget1__title">Хост</h3>
							            <span class="m-widget1__desc"><?php echo $server['location_ip'] ?></span>
						            </div>
					            </div>
				            </div>
				            <div class="m-widget1__item">
					            <div class="row m-row--no-padding align-items-center">
						            <div class="col">
							            <h3 class="m-widget1__title">Логин</h3>
							            <span class="m-widget1__desc">gs<?php echo $server['server_id'] ?></span>
						            </div>
					            </div>
				            </div>
				            <div class="m-widget1__item">
					            <div class="row m-row--no-padding align-items-center">
						            <div class="col">
							            <h3 class="m-widget1__title">Пароль</h3>
							            <span class="m-widget1__desc"><?php echo $server['db_pass'] ?></span>
						            </div>
					            </div>
				            </div>
				            <?endif;?>
				            <br>
				            <?if($server['server_mysql'] == 1):?>
				            <button onClick="sendAction(<?php echo $server['server_id'] ?>,'mysqloff')" class="btn btn-brand m-btn m-btn--air btn-outline  btn-block sbold uppercase">Выключить</button>
				            <?elseif($server['server_mysql'] == 0):?>
				            <button onClick="sendAction(<?php echo $server['server_id'] ?>,'mysqlcr')" class="btn btn-brand m-btn m-btn--air btn-outline  btn-block sbold uppercase">Создать базу</button>
				            <?elseif($server['server_mysql'] == 2):?>
				            <button onClick="sendAction(<?php echo $server['server_id'] ?>,'mysqlon')" class="btn btn-brand m-btn m-btn--air btn-outline  btn-block sbold uppercase">Включить</button>
				            <?endif;?>
				        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>        
</div>
<script>	
					$('#editForm').ajaxForm({ 
						url: '/admin/servers/control/ajax/<?php echo $server['server_id'] ?>',
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
					
					function actionserver(serverid, actionserver) {
						switch(actionserver) {
							case "reinstall":
							{
								if(!confirm("Вы уверенны в том, что хотите переустановить сервер? Все данные будут удалены.")) return;
								break;
							}
														case "delete":
							{
								if(!confirm("Вы уверенны в том, что хотите удалить сервер ID_<?echo $server['server_id']?>?")) return;
								break;
							}
						}
						$.ajax({ 
							url: '/admin/servers/control/actionserver/'+serverid+'/'+actionserver,
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
									if(actionserver == "reinstall") toastr.warning("Сервер будет переустановлен в течении 10 минут!");		
									if(actionserver == "stop") toastr.warning("Сервер выключится через 10 секунд! Пожалуйста, подождите.");
									if(actionserver == "start") toastr.warning("Сервер запускается! Пожалуйста, подождите некоторое время.");	
									if(actionserver == "restart") toastr.warning("Сервер перезапускается! Пожалуйста, подождите некоторое время.");	
									if(actionserver == "block") toastr.warning("Сервер успешно заблокирован!");									
									$('#controlBtns button').prop('disabled', true);
								}
						});
					}
</script>
<script>
	                function sendAction(serverid, mysqlhostin) {
						$.ajax({ 
							url: '/admin/servers/control/mysqlhostin/'+serverid+'/'+mysqlhostin,
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
								if(mysqlhostin == "mysqloff") toastr.warning("Выключаем базу данных...");
								if(mysqlhostin == "mysqlon") toastr.warning("Включаем базу данных...");
								if(mysqlhostin == "mysqlcr") toastr.warning("Создаем базу данных...");
								$('#controlBtns button').prop('disabled', true);
							}
						});
					}
	
</script>
<script src="/application/public/js/sparkline-chart.js"></script>
<script src="/application/public/js/easy-pie-chart.js"></script>
<script src="/application/public/assets/jquery.easy-pie-chart.js"></script>
<?php echo $footer ?>