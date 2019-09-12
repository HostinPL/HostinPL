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
<div class="col-12">
<br>
									<div class="m-portlet__body">

										<!--begin::Section-->
										<div class="m-section">
<div class="m-portlet">
	<div class="m-portlet__head">
		<div class="m-portlet__head-caption">
			<div class="m-portlet__head-title">
				<h3 class="m-portlet__head-text">
					Мои сервера
				</h3>
			</div>
		</div>
		<div class="m-portlet__head-tools">
			<a href="/servers/order" class="btn btn-focus m-btn m-btn--custom m-btn--icon m-btn--air">
				<span>
					<i class="la la-cart-plus"></i>
					<span>Заказать сервер</span>
				</span>
			</a>
		</div>
	</div>
	<div class="m-portlet__body">
		<div class="m-section">
			<div class="m-section__content">
				<table class="table table-striped m-table">
					<thead>
						<tr>
							<th><i class="flaticon-list"></i></th>
							<th><i class="flaticon-puzzle"></i> Игра</th>
							<th><i class="flaticon-map-location"></i> Локация</th>
							<th><i class="flaticon-placeholder"></i> IP</th>
							<th><i class="flaticon-interface-7"></i> Статус</th>
							<th><i class="flaticon-multimedia"></i> Действие</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($servers as $item): ?>
						<tr>
							<th scope="row"><?php echo $item['server_id'] ?></th>
							<td><?php echo $item['game_name'] ?></td>
							<td><?php echo $item['location_name'] ?></td>
							<td><?php echo $item['location_ip2'] ?>:<?php echo $item['server_port'] ?></td>
							<td>
							<?php if($item['server_status'] == 0): ?>
								<span class="m-nav__link-badge"><span class="m-badge m-badge--warning m-badge--wide m-badge--rounded">Заблокирован</span></span>
							<?php elseif($item['server_status'] == 1): ?> 
								<span class="m-nav__link-badge"><span class="m-badge m-badge--danger m-badge--wide m-badge--rounded">Выключен</span></span>
							<?php elseif($item['server_status'] == 2): ?>
								<span class="m-nav__link-badge"><span class="m-badge m-badge--success m-badge--wide m-badge--rounded">Включен</span></span>
							<?php elseif($item['server_status'] == 3): ?>
								<span class="m-nav__link-badge"><span class="m-badge m-badge--info m-badge--wide m-badge--rounded">Устанавливается</span></span>
							<?php elseif($item['server_status'] == 4): ?>
								<span class="m-nav__link-badge"><span class="m-badge m-badge--info m-badge--wide m-badge--rounded">Переустанавливается</span></span>
							<?php elseif($item['server_status'] == 7): ?>
								<span class="m-nav__link-badge"><span class="m-badge m-badge--info m-badge--wide m-badge--rounded">Обновляется</span></span>
							<?php endif; ?>
							</td>
							<td>
							<?php if($item['server_status'] == 0): ?>
								<a href="#" data-container="body" data-toggle="m-popover" data-placement="top" data-content="Вы не можете использовать это действие!" data-original-title="" title="" class="btn btn-outline-metal m-btn m-btn--icon m-btn--icon-only">
								<i class="la la-power-off"></i>
								</a>
								<a href="#" data-container="body" data-toggle="m-popover" data-placement="top" data-content="Вы не можете использовать это действие!" data-original-title="" title="" class="btn btn-outline-metal m-btn m-btn--icon m-btn--icon-only">
								<i class="la la-rotate-right"></i>
								</a>
								<a href="/servers/control/index/<?php echo $item['server_id'] ?>" data-container="body" data-toggle="m-popover" data-placement="top" data-content="Управление сервером" data-original-title="" title="" class="btn btn-outline-brand m-btn m-btn--icon m-btn--icon-only"><i class="flaticon-profile"></i></a>
							<?php elseif($item['server_status'] == 1): ?>
								<a href="#" onClick="sendAction(<?php echo $item['server_id'] ?>,'start')" data-container="body" data-toggle="m-popover" data-placement="top" data-content="Запустить" data-original-title="" title="" class="btn btn-outline-success m-btn m-btn--icon m-btn--icon-only m-btn--outline-2x">
								<i class="la la-power-off"></i>
								</a>
								<a href="#" data-container="body" data-toggle="m-popover" data-placement="top" data-content="Сервер должен быть включен!" data-original-title="" title="" class="btn btn-outline-metal m-btn m-btn--icon m-btn--icon-only">
								<i class="la la-rotate-right"></i>
								</a>
								<a href="/servers/control/index/<?php echo $item['server_id'] ?>" data-container="body" data-toggle="m-popover" data-placement="top" data-content="Управление сервером" data-original-title="" title="" class="btn btn-outline-brand m-btn m-btn--icon m-btn--icon-only"><i class="flaticon-profile"></i></a>
							<?php elseif($item['server_status'] == 2): ?>
								<a href="#" onClick="sendAction(<?php echo $item['server_id'] ?>,'stop')" data-container="body" data-toggle="m-popover" data-placement="top" data-content="Остановить" data-original-title="" title="" class="btn btn-outline-danger m-btn m-btn--icon m-btn--icon-only">
								<i class="la la-power-off"></i>
								</a>
								<a href="#" onClick="sendAction(<?php echo $item['server_id'] ?>,'restart')" data-container="body" data-toggle="m-popover" data-placement="top" data-content="Перезапустить" data-original-title="" title="" class="btn btn-outline-accent m-btn m-btn--icon m-btn--icon-only">
								<i class="la la-rotate-right"></i>
								</a>
								<a href="/servers/control/index/<?php echo $item['server_id'] ?>" data-container="body" data-toggle="m-popover" data-placement="top" data-content="Управление сервером" data-original-title="" title="" class="btn btn-outline-brand m-btn m-btn--icon m-btn--icon-only"><i class="flaticon-profile"></i></a>
							<?php elseif($item['server_status'] == 3): ?>
								<a href="#" data-container="body" data-toggle="m-popover" data-placement="top" data-content="Вы не можете использовать это действие!" data-original-title="" title="" class="btn btn-outline-metal m-btn m-btn--icon m-btn--icon-only">
								<i class="la la-power-off"></i>
								</a>
								<a href="#" data-container="body" data-toggle="m-popover" data-placement="top" data-content="Вы не можете использовать это действие!" data-original-title="" title="" class="btn btn-outline-metal m-btn m-btn--icon m-btn--icon-only">
								<i class="la la-rotate-right"></i>
								</a>
								<a href="/servers/control/index/<?php echo $item['server_id'] ?>" data-container="body" data-toggle="m-popover" data-placement="top" data-content="Управление сервером" data-original-title="" title="" class="btn btn-outline-brand m-btn m-btn--icon m-btn--icon-only"><i class="flaticon-profile"></i></a>
							<?php elseif($item['server_status'] == 4): ?>
								<a href="#" data-container="body" data-toggle="m-popover" data-placement="top" data-content="Вы не можете использовать это действие!" data-original-title="" title="" class="btn btn-outline-metal m-btn m-btn--icon m-btn--icon-only">
								<i class="la la-power-off"></i>
								</a>
								<a href="#" data-container="body" data-toggle="m-popover" data-placement="top" data-content="Вы не можете использовать это действие!" data-original-title="" title="" class="btn btn-outline-metal m-btn m-btn--icon m-btn--icon-only">
								<i class="la la-rotate-right"></i>
								</a>
								<a href="/servers/control/index/<?php echo $item['server_id'] ?>" data-container="body" data-toggle="m-popover" data-placement="top" data-content="Управление сервером" data-original-title="" title="" class="btn btn-outline-brand m-btn m-btn--icon m-btn--icon-only"><i class="flaticon-profile"></i></a>
							<?php elseif($item['server_status'] == 7): ?>
								<a href="#" data-container="body" data-toggle="m-popover" data-placement="top" data-content="Вы не можете использовать это действие!" data-original-title="" title="" class="btn btn-outline-metal m-btn m-btn--icon m-btn--icon-only">
								<i class="la la-power-off"></i>
								</a>
								<a href="#" data-container="body" data-toggle="m-popover" data-placement="top" data-content="Вы не можете использовать это действие!" data-original-title="" title="" class="btn btn-outline-metal m-btn m-btn--icon m-btn--icon-only">
								<i class="la la-rotate-right"></i>
								</a>
								<a href="/servers/control/index/<?php echo $item['server_id'] ?>" data-container="body" data-toggle="m-popover" data-placement="top" data-content="Управление сервером" data-original-title="" title="" class="btn btn-outline-brand m-btn m-btn--icon m-btn--icon-only"><i class="flaticon-profile"></i></a>
							<?php endif; ?>
							</td>
						</tr>
					    <?php endforeach; ?>
						<?php foreach($serversOwners as $item): ?>
						<tr>
							<th scope="row"><?php echo $item['server_id'] ?></th>
							<td><?php echo $item['game_name'] ?></td>
							<td><?php echo $item['location_name'] ?></td>
							<td><?php echo $item['location_ip2'] ?>:<?php echo $item['server_port'] ?></td>
							<td>
							<?php if($item['server_status'] == 0): ?>
								<span class="m-nav__link-badge"><span class="m-badge m-badge--warning m-badge--wide m-badge--rounded">Заблокирован</span></span>
							<?php elseif($item['server_status'] == 1): ?> 
								<span class="m-nav__link-badge"><span class="m-badge m-badge--danger m-badge--wide m-badge--rounded">Выключен</span></span>
							<?php elseif($item['server_status'] == 2): ?>
								<span class="m-nav__link-badge"><span class="m-badge m-badge--success m-badge--wide m-badge--rounded">Включен</span></span>
							<?php elseif($item['server_status'] == 3): ?>
								<span class="m-nav__link-badge"><span class="m-badge m-badge--info m-badge--wide m-badge--rounded">Устанавливается</span></span>
							<?php elseif($item['server_status'] == 4): ?>
								<span class="m-nav__link-badge"><span class="m-badge m-badge--info m-badge--wide m-badge--rounded">Переустанавливается</span></span>
							<?php elseif($item['server_status'] == 7): ?>
								<span class="m-nav__link-badge"><span class="m-badge m-badge--info m-badge--wide m-badge--rounded">Обновляется</span></span>
							<?php endif; ?>
							</td>
							<td>
							<?php if($item['server_status'] == 0): ?>
								<a href="#" data-container="body" data-toggle="m-popover" data-placement="top" data-content="Вы не можете использовать это действие!" data-original-title="" title="" class="btn btn-outline-metal m-btn m-btn--icon m-btn--icon-only">
								<i class="la la-power-off"></i>
								</a>
								<a href="#" data-container="body" data-toggle="m-popover" data-placement="top" data-content="Вы не можете использовать это действие!" data-original-title="" title="" class="btn btn-outline-metal m-btn m-btn--icon m-btn--icon-only">
								<i class="la la-rotate-right"></i>
								</a>
								<a href="/servers/control/index/<?php echo $item['server_id'] ?>" data-container="body" data-toggle="m-popover" data-placement="top" data-content="Управление сервером" data-original-title="" title="" class="btn btn-outline-brand m-btn m-btn--icon m-btn--icon-only"><i class="flaticon-profile"></i></a>
							<?php elseif($item['server_status'] == 1): ?>
								<a href="#" onClick="sendAction(<?php echo $item['server_id'] ?>,'start')" data-container="body" data-toggle="m-popover" data-placement="top" data-content="Запустить" data-original-title="" title="" class="btn btn-outline-success m-btn m-btn--icon m-btn--icon-only m-btn--outline-2x">
								<i class="la la-power-off"></i>
								</a>
								<a href="#" data-container="body" data-toggle="m-popover" data-placement="top" data-content="Сервер должен быть включен!" data-original-title="" title="" class="btn btn-outline-metal m-btn m-btn--icon m-btn--icon-only">
								<i class="la la-rotate-right"></i>
								</a>
								<a href="/servers/control/index/<?php echo $item['server_id'] ?>" data-container="body" data-toggle="m-popover" data-placement="top" data-content="Управление сервером" data-original-title="" title="" class="btn btn-outline-brand m-btn m-btn--icon m-btn--icon-only"><i class="flaticon-profile"></i></a>
							<?php elseif($item['server_status'] == 2): ?>
								<a href="#" onClick="sendAction(<?php echo $item['server_id'] ?>,'stop')" data-container="body" data-toggle="m-popover" data-placement="top" data-content="Остановить" data-original-title="" title="" class="btn btn-outline-danger m-btn m-btn--icon m-btn--icon-only">
								<i class="la la-power-off"></i>
								</a>
								<a href="#" onClick="sendAction(<?php echo $item['server_id'] ?>,'restart')" data-container="body" data-toggle="m-popover" data-placement="top" data-content="Перезапустить" data-original-title="" title="" class="btn btn-outline-accent m-btn m-btn--icon m-btn--icon-only">
								<i class="la la-rotate-right"></i>
								</a>
								<a href="/servers/control/index/<?php echo $item['server_id'] ?>" data-container="body" data-toggle="m-popover" data-placement="top" data-content="Управление сервером" data-original-title="" title="" class="btn btn-outline-brand m-btn m-btn--icon m-btn--icon-only"><i class="flaticon-profile"></i></a>
							<?php elseif($item['server_status'] == 3): ?>
								<a href="#" data-container="body" data-toggle="m-popover" data-placement="top" data-content="Вы не можете использовать это действие!" data-original-title="" title="" class="btn btn-outline-metal m-btn m-btn--icon m-btn--icon-only">
								<i class="la la-power-off"></i>
								</a>
								<a href="#" data-container="body" data-toggle="m-popover" data-placement="top" data-content="Вы не можете использовать это действие!" data-original-title="" title="" class="btn btn-outline-metal m-btn m-btn--icon m-btn--icon-only">
								<i class="la la-rotate-right"></i>
								</a>
								<a href="/servers/control/index/<?php echo $item['server_id'] ?>" data-container="body" data-toggle="m-popover" data-placement="top" data-content="Управление сервером" data-original-title="" title="" class="btn btn-outline-brand m-btn m-btn--icon m-btn--icon-only"><i class="flaticon-profile"></i></a>
							<?php elseif($item['server_status'] == 4): ?>
								<a href="#" data-container="body" data-toggle="m-popover" data-placement="top" data-content="Вы не можете использовать это действие!" data-original-title="" title="" class="btn btn-outline-metal m-btn m-btn--icon m-btn--icon-only">
								<i class="la la-power-off"></i>
								</a>
								<a href="#" data-container="body" data-toggle="m-popover" data-placement="top" data-content="Вы не можете использовать это действие!" data-original-title="" title="" class="btn btn-outline-metal m-btn m-btn--icon m-btn--icon-only">
								<i class="la la-rotate-right"></i>
								</a>
								<a href="/servers/control/index/<?php echo $item['server_id'] ?>" data-container="body" data-toggle="m-popover" data-placement="top" data-content="Управление сервером" data-original-title="" title="" class="btn btn-outline-brand m-btn m-btn--icon m-btn--icon-only"><i class="flaticon-profile"></i></a>
							<?php elseif($item['server_status'] == 7): ?>
								<a href="#" data-container="body" data-toggle="m-popover" data-placement="top" data-content="Вы не можете использовать это действие!" data-original-title="" title="" class="btn btn-outline-metal m-btn m-btn--icon m-btn--icon-only">
								<i class="la la-power-off"></i>
								</a>
								<a href="#" data-container="body" data-toggle="m-popover" data-placement="top" data-content="Вы не можете использовать это действие!" data-original-title="" title="" class="btn btn-outline-metal m-btn m-btn--icon m-btn--icon-only">
								<i class="la la-rotate-right"></i>
								</a>
								<a href="/servers/control/index/<?php echo $item['server_id'] ?>" data-container="body" data-toggle="m-popover" data-placement="top" data-content="Управление сервером" data-original-title="" title="" class="btn btn-outline-brand m-btn m-btn--icon m-btn--icon-only"><i class="flaticon-profile"></i></a>
							<?php endif; ?>
							</td>
						</tr>
					    <?php endforeach; ?>
						<?php if(empty($servers) and empty($serversOwners)): ?>
						<tr>
							<td colspan="6" style="text-align: center;">На данный момент у вас нет серверов.</td>
						</tr>
						<?php endif; ?> 
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
</div>
</div></div>
<script>
	function sendAction(serverid, action) {
	$.ajax({ 
			url: '/servers/index/action/'+serverid+'/'+action,
			dataType: 'text',
			success: function(data) {
				data = $.parseJSON(data);
				switch(data.status) {
					case 'error':
						toastr.error(data.error);
						break;
					case 'success':
						toastr.success(data.success);
						setTimeout("reload()", 5500);
						break;
				}
			},
			beforeSend: function(arr, options) {
					if(action == "stop") toastr.info("Сервер выключается! Пожалуйста, подождите некоторое время.");
					if(action == "start") toastr.info("Сервер запускается! Пожалуйста, подождите некоторое время.");	
					if(action == "restart") toastr.info("Сервер перезапускается! Пожалуйста, подождите некоторое время.");									
					$('#controlBtns button').prop('disabled', true);
				}
		});
	}
</script>
<?php echo $footer ?>
