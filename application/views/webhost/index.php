<?php
/*
Copyright (c) 2014 LiteDevel

Данная лицензия разрешает лицам, получившим копию данного программного обеспечения
и сопутствующей документации (в дальнейшем именуемыми «Программное Обеспечение»),
безвозмездно использовать Программное Обеспечение в  личных целях, включая неограниченное
право на использование, копирование, изменение, добавление, публикацию, распространение,
также как и лицам, которым запрещенно использовать Програмное Обеспечение в коммерческих целях,
предоставляется данное Программное Обеспечение,при соблюдении следующих условий:

Developed by LiteDevel
*/
?>
<?php echo $header ?>
													<div class="portlet light">
	<div class="portlet-title" style="margin-bottom: 0px;">
		<div class="caption caption-md">
			<i class="icon-bar-chart theme-font hide"></i>
			<span class="caption-subject font-blue-madison bold uppercase">Мои сайты</span>
		</div>

		<div class="actions">
			<div  class="btn-group btn-group-devided">
				<a href="/webhost/order/<?php echo $db_password ?>" class="btn btn-transparent grey-salsa btn-circle btn-sm active">Заказать веб-хостинг</a>
			</div>
		</div>

	</div>
	<div class="portlet-body" style="padding-top: 0px;">
		
		<div class="table-scrollable table-scrollable-borderless" style="margin-top: 0px !important;">
			<table class="table table-hover table-light">
				<thead><tr>
										<th>
											<i class="fa fa-briefcase"></i> ID
										</th>
										<th class="hidden-xs">
											<i class="fa fa-check-square"></i> Статус
										</th>
										<th>
											<i class="fa fa-gamepad"></i> Тариф
										</th>
																				<th>
											<i class="fa fa-laptop"></i> Локация
										</th>
																				<th>
											<i class="fa fa-signal"></i> Домен
										</th>
										<th>
										<i class="fa fa-edit"></i> Действие
										</th>
				</tr></thead>
				<tbody>
															<?php foreach($webhosts as $item): ?> 
									<tr>
										<td class="highlight">
											<div class="<?php if($item['web_status'] == 0){echo 'danger';}elseif($item['web_status'] == 1){echo 'success';}elseif($item['server_status'] == 3){echo 'warning';}?>" onClick="redirect('/webhost/control/index/<?php echo $item['web_id'] ?>')">
											</div>											
											 #<?php echo $item['web_id'] ?> 
										</td>
										<td class="hidden-xs">
											<?php if($item['web_status'] == 0): ?> 
								<span class="label label-warning">Заблокирован</span>
							<?php elseif($item['web_status'] == 0): ?> 
								<span class="label label-danger">Выключен</span>
							<?php elseif($item['web_status'] == 1): ?> 
								<span class="label label-success">Работает</span>
							<?php elseif($item['web_status'] == 3): ?> 
								<span class="label label-warning">Установка</span>
							<?php endif; ?> 
										</td>
										<td>
											<?php echo $item['tarif_name'] ?>
										</td>
										<td>
											 <?php echo $item['location_name'] ?>
										</td>
										<td>
											<?php echo $item['web_domain']?>
										</td>
										<td>
											<a href="/webhost/control/index/<?php echo $item['web_id'] ?>" class="btn default btn-xs purple">
											<i class="fa fa-share"></i> Управ. </a>
										</td>
									</tr>	
<?php endforeach; ?> 
						<?php if(empty($webhosts)): ?> 
						<tr>
							<td colspan="8" style="text-align: center;">На данный момент у вас нет веб-хостинга.</td>
						<tr>
						<?php endif; ?>
             </tbody>
			</table>
		</div>
		
		
	</div>
</div>
									<?php echo $pagination ?> 


<?php echo $footer ?>
