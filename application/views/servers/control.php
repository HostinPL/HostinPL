<?php
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
require_once('./engine/libs/ssh2.php');
$ssh2Lib = new ssh2Library();
?>
<?php include 'application/views/common/menuserver.php';?>
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
						<a href="#" class="m-card-profile__email m-link">Выключен</a>
						<?php elseif($server['server_status'] == 2): ?>
						<a href="#" class="m-card-profile__email m-link">Включен</a>
					    <?php elseif($server['server_status'] == 3): ?>
					    <a href="#" class="m-card-profile__email m-link">Устанавливается</a>
					    <?php elseif($server['server_status'] == 4): ?>
					    <a href="#" class="m-card-profile__email m-link">Переустанавливается</a>
					    <?php elseif($server['server_status'] == 0): ?>
					    <a href="#" class="m-card-profile__email m-link">Заблокирован</a>
						<?php elseif($server['server_status'] == 7): ?>
						<a href="#" class="m-card-profile__email m-link">Обновляется</a>
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
						<a onClick="sendAction(<?php echo $server['server_id'] ?>,'start')" class="m-nav__link">
						<i class="m-nav__link-icon fa fa-power-off"></i>
							<span class="m-nav__link-text">Включить сервер</span>
						</a>
					</li>
					<li class="m-nav__item">
						<a onClick="sendAction(<?php echo $server['server_id'] ?>,'reinstall')" class="m-nav__link">
							<i class="m-nav__link-icon fa fa-broom"></i>
							<span class="m-nav__link-text">Переустановить сервер</span>
						</a>
					</li>
					<li class="m-nav__item">
						<a data-toggle="modal" data-target="#pay" class="m-nav__link">
							<i class="m-nav__link-icon fa fa-cart-plus"></i>
							<span class="m-nav__link-text">Продлить</span>
						</a>
					</li>
					<li class="m-nav__item">
						<a onClick="sendAction(<?php echo $server['server_id'] ?>,'backup')" class="m-nav__link">
							<i class="m-nav__link-icon fa fa-cloud-download-alt"></i>
							<span class="m-nav__link-text">Сделать BackUP</span>
						</a>
					</li>
					<li class="m-nav__item">
						<a data-toggle="modal" data-target="#slog" class="m-nav__link">
							<i class="m-nav__link-icon fa fa-exclamation-circle"></i>
							<span class="m-nav__link-text">Логи сервера</span>
						</a>
					</li>
					<?php elseif($server['server_status'] == 2): ?>
					<li class="m-nav__item">
						<a onClick="sendAction(<?php echo $server['server_id'] ?>,'stop')" class="m-nav__link">
							<i class="m-nav__link-icon fa fa-power-off"></i>
							<span class="m-nav__link-text">Выключить сервер</span>
						</a>
					</li>
					<li class="m-nav__item">
						<a onClick="sendAction(<?php echo $server['server_id'] ?>,'restart')" class="m-nav__link">
							<i class="m-nav__link-icon fa fa-sync-alt"></i>
							<span class="m-nav__link-text">Перезапустить сервер</span>
						</a>
					</li>
					<li class="m-nav__item">
						<a data-toggle="modal" data-target="#slog" class="m-nav__link">
							<i class="m-nav__link-icon fa fa-exclamation-circle"></i>
							<span class="m-nav__link-text">Логи сервера</span>
						</a>
					</li>
					<?php elseif($server['server_status'] == 0): ?>
					<li class="m-nav__item">
						<a data-toggle="modal" data-target="#pay" class="m-nav__link">
							<i class="m-nav__link-icon fa fa-cart-plus"></i>
							<span class="m-nav__link-text">Продлить</span>
						</a>
					</li>
					<?php elseif($server['server_status'] == 3): ?>
					<li class="m-nav__item">
						<a data-toggle="modal" data-target="#slog" class="m-nav__link">
							<i class="m-nav__link-icon fa fa-exclamation-circle"></i>
							<span class="m-nav__link-text">Логи сервера</span>
						</a>
					</li>
					<?php elseif($server['server_status'] == 4): ?>
					<li class="m-nav__item">
						<a data-toggle="modal" data-target="#slog" class="m-nav__link">
							<i class="m-nav__link-icon fa fa-exclamation-circle"></i>
							<span class="m-nav__link-text">Логи сервера</span>
						</a>
					</li>
					<?php elseif($server['server_status'] == 7): ?>
					<li class="m-nav__item">
						<a data-toggle="modal" data-target="#slog" class="m-nav__link">
							<i class="m-nav__link-icon fa fa-exclamation-circle"></i>
							<span class="m-nav__link-text">Логи сервера</span>
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
						<div class="col m--align-right">
							<a href="#" data-toggle="modal" data-target="#buyPort" class="btn btn-outline-accent m-btn m-btn--icon">
								<span>
									<i class="fa fa-pencil-alt"></i>
									<span>Изменить</span>
								</span>
							</a>
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
						<?php if($server['game_query'] == "valve"): ?>
						<div class="col m--align-right">
							<a data-toggle="modal" data-target="#mapcs" class="btn btn-outline-accent m-btn m-btn--icon">
								<span>
									<i class="fa fa-pencil-alt"></i>
									<span>Изменить</span>
								</span>
							</a>
						</div>
						<?php endif; ?>
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
						<div class="col m--align-right">
							<a href="#" data-toggle="modal" data-target="#buySlots" class="btn btn-outline-accent m-btn m-btn--icon">
								<span>
									<i class="fa fa-pencil-alt"></i>
									<span>Изменить</span>
								</span>
							</a>
						</div>
					</div>
				</div>
				<div class="m-widget1__item">
					<div class="row m-row--no-padding align-items-center">
						<div class="col">
							<h3 class="m-widget1__title">Оплачен до</h3>
							<span class="m-widget1__desc"><?php echo date("d.m.Y", strtotime($server['server_date_end'])) ?></span>
						</div>
						<div class="col m--align-right">
							<a href="#" data-toggle="modal" data-target="#pay" class="btn btn-outline-accent m-btn m-btn--icon">
								<span>
									<i class="fa fa-cart-plus"></i>
									<span>Оплатить</span>
								</span>
							</a>
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
			</div>
		</div>
	</div>
	<div class="col-12">
	    <div class="m-portlet__body">
			<div class="m-section">
                <div class="m-portlet">
	                <div class="m-portlet__head">
		                <div class="m-portlet__head-caption">
			                <div class="m-portlet__head-title">
				                <h3 class="m-portlet__head-text">Статистика сервера</h3>
			                </div>
		                </div>	
	                </div>
	                <div id="statsGraph" style="width: 100%;"></div>
                </div>
            </div>
        </div>
    </div>
</div>        
</div>
<!--begin::Modal-->
<div class="modal fade" id="slog" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Логи сервера</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"></span>
                </button>
            </div>
            <div class="modal-body">
            	<div class="tab-pane active show" id="topbar_notifications_events" role="tabpanel">
					<div class="m-scrollable m-scroller" data-scrollable="true" data-height="250" data-mobile-height="200" style="height: 200px; overflow: auto;">
						<?$nofire = false;?>		
                            <?php foreach($logs as $item):  ?>
									<? if($server['server_id'] == $item['server_id']): ?>
									<?$nofire = true;?>
						<div class="m-list-timeline m-list-timeline--skin-light">
							<div class="m-list-timeline__items">
								<div class="m-list-timeline__item">
									<span class="m-list-timeline__badge m-list-timeline__badge--state1-success"></span>
									<a onclick="deletelog(<?=$item['log_id']?>)" data-container="body" data-toggle="m-popover" data-placement="top" data-content="Удалить" data-original-title="" title=""class="m-list-timeline__text"><?=$item['reason']?></a>
									<span class="m-list-timeline__time"><?=$item['date']?></span>
								</div>
							</div>
						</div>
						<?endif;?>
						<?php endforeach; ?>
						<?php if(empty($logs) || $nofire == false): ?>
						<div class="m-list-timeline m-list-timeline--skin-light">
							<div class="m-list-timeline__items">
								<div class="m-list-timeline__item">
									<span class="m-list-timeline__badge m-list-timeline__badge--state1-success"></span>
									<a href="#" class="m-list-timeline__text">На данный момент нет ни одного действия.</a>
								</div>
							</div>
						</div>
						<?php endif; ?>
					</div>
				</div>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
<!--end::Modal-->
<!--begin::Modal-->
<div class="modal fade" id="pay" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Продление сервера</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"></span>
                </button>
            </div>
            <div class="modal-body">
            <form id="payForm" method="POST" class="form_0" style="padding:0px; margin:0px;">
                <div class="form-group m-form__group">
                    <div class="input-group">
						<select style="width:340px;" class="form-control" id="months" name="months" onchange="updatePrice()">
							<option value="1">1 месяц</option>
							<option value="3">3 месяца</option>
							<option value="6">6 месяцев</option>
							<option value="12">12 месяцев</option>
						</select>
			        </div>	
                </div>
				<div class="col m--align-right">
					<span id="price2" class="m-widget1__number m--font-brand">0.00 руб.</span>
				</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                <input class="btn m-btn--square  btn-info" type="submit" value="Оплатить">
            </div>
            </form>
        </div>
    </div>
</div>
<!--end::Modal-->
<!--begin::Modal-->
<div class="modal fade" id="buyPort" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Смена порта</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form id="portForm" method="POST" class="form_0" style="padding:0px; margin:0px;">
                <div class="input-group">
					<select class="form-control" name="port"> 
					<?php foreach($gameServerPorts as $item): ?>
						<option value="<?php echo $item ?>"><?php echo $item ?></option>
					<?php endforeach; ?>
					<?php if(empty($gameServerPorts)): ?>
						<option value="null">На данный момент нет свободных портов.</option>
					<?php endif; ?>
					</select>
				</div>
				<br>
				<div class="col m--align-right">
					<span id="price_port" class="m-widget1__number m--font-brand"><?php echo $portPrice ?> руб.</span>
				</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                <input class="btn m-btn--square  btn-info" name="buy_port" type="submit" value="Сменить">
            </div>
            </form>
        </div>
    </div>
</div>
<!--end::Modal-->
<!--begin::Modal-->
<div class="modal fade" id="mapcs" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Смена карты</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form id="changemap" method="POST" class="form_0" style="padding:0px; margin:0px;">
                <div class="input-group">
					<select style="width:340px;border-radius: 0;" name="map" class="form-control"><?php echo $maps ?></select>
				</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                <input class="btn m-btn--square  btn-info" type="submit" value="Сменить">
            </div>
            </form>
        </div>
    </div>
</div>
<!--end::Modal-->
<!--begin::Modal-->
<div class="modal fade" id="buySlots" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Изменение слотов</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form id="edit_slots" method="POST" class="form_0" style="padding:0px; margin:0px;">
                <div class="input-group" onkeyup="updateForm(true)">
					<span class="input-group-btn"><button class="btn btn-default" type="button" onclick="minusSlots()">-</button></span>
					<input type="text" class="form-control" id="slots" name="slots" value="<?echo $server['server_slots']?>">
					<span class="input-group-btn"><button class="btn btn-default" type="button" onclick="plusSlots()">+</button></span>
				</div>
				<br>
				<div class="col m--align-right">
					<span id="price" class="m-widget1__number m--font-brand">0.00 руб.</span>
				</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                <input class="btn m-btn--square  btn-info" type="submit" value="Оплатить">
            </div>
            </form>
        </div>
    </div>
</div>
<!--end::Modal-->
				<script>
					$('#editForm').ajaxForm({ 
						url: '/servers/control/ajax/<?php echo $server['server_id'] ?>',
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
					function deletelog(logid) {
						$.ajax({ 
							url: '/servers/control/deletelog/'+logid,
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
	
									$('#controlBtns button').prop('disabled', true);
								}
						});
					}
					function sendAction(serverid, action) {
						switch(action) {
							case "reinstall":
							{
								if(!confirm("Вы уверенны в том, что хотите переустановить сервер? Все данные будут удалены.")) return;
								break;
							}
						}
						$.ajax({ 
							url: '/servers/control/action/'+serverid+'/'+action,
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
									if(action == "reinstall") toastr.warning("Сервер будет переустановлен в течении 10 минут!");
									if(action == "updatesrv") toastr.warning("Сервер будет обновлен в течении 10 минут!");		
									if(action == "stop") toastr.warning("Сервер выключится через 10 секунд! Пожалуйста, подождите.");
									if(action == "start") toastr.warning("Сервер запускается! Пожалуйста, подождите некоторое время.");	
									if(action == "restart") toastr.warning("Сервер перезапускается! Пожалуйста, подождите некоторое время.");	
									if(action == "backup") toastr.warning("Создается BackUp Сервера! Пожалуйста, подождите некоторое время.");									
									$('#controlBtns button').prop('disabled', true);
								}
						});
					}
					
					$('#portForm').ajaxForm({ 
						url: '/servers/control/ajax_port/<?php echo $server['server_id'] ?>',
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
									setTimeout("reload()",1000);
									break;
							}
						},
						beforeSubmit: function(arr, $form, options) {
							$('button[type=submit]').prop('disabled', true);
						}
					});
					
					$('#payForm').ajaxForm({ 
						url: '/servers/control/buy_months/<?php echo $server['server_id'] ?>',
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
									setTimeout("reload()",1000);
									break;
							}
						},
						beforeSubmit: function(arr, $form, options) {
							$('button[type=submit]').prop('disabled', true);
						}
					});

						var online = [
							<?php foreach($stats as $item): ?> 
							[<?php echo strtotime($item['server_stats_date']) * 1000 ?>, <?php echo $item['server_stats_players'] ?>],
							<?php endforeach; ?> 
						];					
						Highcharts.setOptions({
						lang: {
								rangeSelectorZoom: 'Период',
								rangeSelectorFrom: 'С',
								rangeSelectorTo: 'По',
								printChart: 'Печать диаграммы',
								downloadPNG: 'Скачать PNG изображение',
								downloadJPEG: 'Скачать JPEG изображение',
								downloadPDF: 'Скачать PDF документ',
								downloadSVG: 'Скачать SVG изображение',
								contextButtonTitle: 'Контекстное меню графика',
								months: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь',  'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
								shortMonths: ['Янв.', 'Фев.', 'Март.', 'Апр.', 'Май.', 'Июнь.', 'Июль.', 'Авг.', 'Сент.', 'Окт.', 'Ноя.', 'Дек.']
							}
						});
						$('#statsGraph').highcharts('StockChart', {	
							credits:{enabled: false},
							xAxis: {
								type: 'datetime',
								dateTimeLabelFormats:{
									second: '%H:%M:%S',
									minute: '%H:%M',
									hour: '%H:%M',
									day: '%e.%m',
									week: '',
									month: '%m',
									year: '%Y'
								}
							},
							yAxis: {
								allowDecimals: false,
								min: 0
							},
							scrollbar: {
								barBackgroundColor: 'gray',
								barBorderRadius: 7,
								barBorderWidth: 0,
								buttonBackgroundColor: 'gray',
								buttonBorderWidth: 0,
								buttonBorderRadius: 7,
								trackBackgroundColor: 'none',
								trackBorderWidth: 1,
								trackBorderRadius: 8,
								trackBorderColor: '#CCC'
							},
							rangeSelector: {
								selected: 0,
								buttonTheme: {
									width: 50
								},
								buttons: [{
									type: 'day',
									count: 1,
									text: 'ДЕНЬ'
								},{
									type: 'week',
									count: 1,
									text: 'НЕДЕЛЯ'
								},{
									type: 'month',
									count: 1,
									text: 'МЕСЯЦ'
								}]
							},
							tooltip: {
								formatter: function() { //d.m.Y H:i
									var s = '<b>Дата: '+ Highcharts.dateFormat('%e.%m.%Y - %H:%M', this.x) +'</b>';
									$.each(this.points, function(i, point) {s += '<br/>Онлайн : '+point.y;});
									return s;
								}
							},
							series : [{
								name: 'График загруженности сервера',
								data : online,
								type: 'spline',
								tooltip: {
									valueDecimals: 2
								}
							}]
						});	
						$('#changemap').ajaxForm({ 
						url: '/servers/control/changemap_go/<?php echo $server['server_id'] ?>',
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
									$('button[type=submit]').prop('disabled', false);
									setTimeout("reload()", 2500);
									break;
							}
						},
						beforeSubmit: function(arr, $form, options) {
							$('button[type=submit]').prop('disabled', true);
							
						}
					   });	
                       $('#edit_slots').ajaxForm({ 
						url: '/servers/control/ajax/<?php echo $server['server_id'] ?>',
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
									setTimeout("reload()",1000);
									break;
							}
						},
						beforeSubmit: function(arr, $form, options) {
							$('button[type=submit]').prop('disabled', true);
						}
					});
					 $(document).ready(function() {
						updatePrice();
						updateForm();
					});
					function updateForm(promo) {
						var gamePrice = '<?=$gamePrice?>';
						var gameMax = <?=$server['game_max_slots']?>;
						var sslots = <?=$server['server_slots']?>;
						var slots = $("#slots").val();
						if(slots < sslots) {
							slots = sslots;
							$("#slots").val(slots);
						}
						else if(slots > gameMax) {
							slots = gameMax;
							$("#slots").val(slots);
						}
                    var price = gamePrice * (slots-sslots);
                   $('#price').text(price.toFixed(2) + ' руб.');
					}
					
					function plusSlots() {
						value = parseInt($('#slots').val());
						$('#slots').val(value+1);
						updateForm();
					}
					function minusSlots() {
						value = parseInt($('#slots').val());
						$('#slots').val(value-1);
					   updateForm();
					}
					
					function updatePrice() {
						var price2 = <?php echo $server['game_price'] ?> * <?php echo $server['server_slots'] ?>;
						var months = $("#months option:selected").val();
						switch(months) {
							case "3":
								price2 = 3 * price2 * 0.95;
								months = 3;
								break;
							case "6":
								price2 = 6 * price2 * 0.90;
								months = 6;
								break;
							case "12":
								price2 = 12 * price2 * 0.85;
								months = 12;
								break;
						}
						$('#price2').text(price2.toFixed(2) + ' руб. Месяц: ' + months);
					}
				</script>

				<!--Page Related Scripts-->
		<script src="/application/public/js/sparkline-chart.js"></script>
	<script src="/application/public/js/easy-pie-chart.js"></script>
	<script src="/application/public/assets/jquery.easy-pie-chart.js"></script>
	<?php $ssh2Lib->disconnect($link); ?>
<?php echo $footer ?>