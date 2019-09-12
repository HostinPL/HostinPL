<?php echo $header ?>
<style>
.profile-nav ul > li {
  border-bottom: 1px solid #ebeae6;
  margin-top: 0;
  line-height: 30px;
}
</style> 
<div class="row">
<div class="col-lg-12">
<div class="portlet light">
													<a href="/webhost/control/index/<?php echo $webhost['web_id'] ?>" class="icon-btn">
													<i class="icon-home"></i>
													<div>
														 Управление
													</div>
													</a>
													<a href="/webhost/ftp/index/<?php echo $webhost['web_id'] ?>" class="icon-btn">
													<i class="icon-docs"></i>
													<div>
														 FTP
													</div>
													</a>
												</div>
												</div>
					  <aside class="profile-nav col-lg-3">
						  <section class="panel">
							  <div class="user-heading round">
							  <center>
							 
								  <a href="#" style="margin-top: 10px;">
								  										
																		  </a>
								  <h1><?php echo $webhost['web_domain'] ?></h1>
								  <p><span class="text-danger"></span></p>
								 
							  </div>
</center>
							  <ul class="nav nav-pills nav-stacked">
						<li><a data-toggle="modal" data-target="#pay"> <i class="fa fa-shopping-cart"></i> Продлить</a></li>
												<li>
							<a style="cursor: pointer" href="https://<?echo $ispdomain?>:1500/ispmgr">
								<i class="icon-bulb"></i> ISPManager
							</a>
						</li>

			<div class="portlet light ">
				
				<div class="portlet-body">
					<table class="server-info">
						<tbody><tr>
							
							<td style="vertical-align: top;">
								<table>
									<tbody>
									 <tr>
										<td>Тариф:</td>
										<td><?php echo $webhost['tarif_name'] ?></td>
									</tr>
									 <tr>
										<td>Оплачен:</td>
										<td><?php echo date("d.m.Y", strtotime($webhost['web_date_end'])) ?></td>
									</tr>

																	</tbody></table>
							</td>
						</tr>
					</tbody></table>
				</div>
			</div>
					  </aside>
					  <div class="modal fade" id="pay" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
				  <div class="modal-dialog">
					<div class="modal-content">
					  <div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">?</span><span class="sr-only">Close</span></button>
						<h4 class="modal-title" id="myModalLabel">Продление сервера</h4>
					  </div>
					  <div class="modal-body">
													<div class="row">
																						<form class="form-horizontal" action="#" id="payForm" method="POST">
														<div class="modal-body">
					
					
						<div class="form-group">
							<label for="ammount" class="col-sm-3 control-label">Период оплаты:</label>
							<div class="col-sm-3">
								<div class="input-group">
									<select class="form-control" id="months" onchange="updatePrice()">
								<option value="1">1 месяц</option>
								<option value="3">3 месяца</option>
								<option value="6">6 месяцев</option>
								<option value="12">12 месяцев</option>
							</select>
								</div>
							</div>
						</div>
						<div class="form-group">
						<label for="price2" class="col-sm-3 control-label">Итого:</label>
						<div class="col-sm-3">
						<div class="input-group">

							<span class="total"><strong id="price2">0.00 руб.</strong></span>
							
						</div>
						</div>
					</div>
						<div class="form-group">
							<div class="col-sm-offset-3 col-sm-9">
								<button type="submit" class="btn btn-primary">Оплатить</button>
							</div>
						</div>
																</div></form>

										</div>									
								</div>
					</div>
				  </div>
				</div>
<div class="modal fade" id="buySlots" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
				  <div style="width: 400px; top: 160px;" class="modal-dialog">
					<div class="modal-content">
					  <div class="modal-body">
<form id="edit_slots" method="POST" class="form_0" style="padding:0px; margin:0px;">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">?</button>
            <h4 class="modal-title">Изменение слотов</h4>
        </div>
        <div class="modal-body">
           <div class="input-group">
								<span class="input-group-btn"><button class="btn btn-default" type="button" onclick="minusSlots()">-</button></span>
								<input type="text" class="form-control" id="slots" name="slots" value="<?echo $server['server_slots']?>">
								<span class="input-group-btn"><button class="btn btn-default" type="button" onclick="plusSlots()">+</button></span>
							</div>	
				<div class="input-group">
								<p class="lead" id="price">0.00 руб.</p>
							</div>								
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn green">Оплатить</button>
        </div>
    </form>
					  </div>
					</div>
				  </div>
				</div>
					  <!-- Server Status 1 -->
					   <?php if($server['server_status'] == 1): ?>
					  <div class="col-lg-9">
					  <div class="col-lg-12">
							 <div class="panel">
							 <div class="panel-body">
							 <div class="col-lg-4 col-md-4 col-sm-12">
							 <div class="easy-pie-chart">
							 
							 							 <div class="percentage easyPieChart" data-percent="0" style="width: 110px; height: 110px; line-height: 110px;"><span>0</span>%<canvas width="110" height="110"></canvas></div>
							 							 
							 <div class="text-center">CPU</div>
							 </div>
							 </div>
							 <div class="col-lg-4 col-md-4 col-sm-12">
							 <div class="easy-pie-chart">
							 							 <div class="percentage easyPieChart" data-percent="0" style="width: 110px; height: 110px; line-height: 110px;"><span>0</span>%<canvas width="110" height="110"></canvas></div>
							 							 <div class="text-center">RAM</div>
							 </div>
							 </div>
							 <div class="col-lg-4 col-md-4 col-sm-12">
							 <div class="easy-pie-chart">
							 <div class="percentage easyPieChart" data-percent="0" style="width: 110px; height: 110px; line-height: 110px;"><span>0%</span><canvas width="110" height="110"></canvas></div>
							 <div class="text-center">Загруженность сервера</div>
							 </div>
							 </div>
						  </div>
						  </div>
						</div>
				  </div>
				  <?php endif; ?>
				  <!-- ////-->
				  <!-- Server status 2-->
				   <?php if($server['server_status'] == 2): ?>
					  <div class="col-lg-9">
					  <div class="col-lg-12">
							 <div class="panel">
							 <div class="panel-body">
							 <div class="col-lg-4 col-md-4 col-sm-12">
							 <div class="easy-pie-chart">
							 
							 							 <div class="percentage easyPieChart" data-percent="<?php echo $server['server_cpu_load'] ?>" style="width: 110px; height: 110px; line-height: 110px;"><span>CPU(<?php echo $server['server_cpu_load'] ?></span>%)<canvas width="110" height="110"></canvas></div>
							 							 
							 </div>
							 </div>
							 <div class="col-lg-4 col-md-4 col-sm-12">
							 <div class="easy-pie-chart">
							 							 <div class="percentage easyPieChart" data-percent="<?php echo $server['server_ram_load'] ?>" style="width: 110px; height: 110px; line-height: 110px;">RAM(<span><?php echo $server['server_ram_load'] ?></span>%)<canvas width="110" height="110"></canvas></div>
							 							
							 </div>
							 </div>
							 <div class="col-lg-4 col-md-4 col-sm-12">
							 <div class="easy-pie-chart">
							 <?php $percent=$query['players']*100/$query['maxplayers']; ?>
							 <div class="percentage easyPieChart" data-percent="<?php echo $percent ?>" style="width: 110px; height: 110px; line-height: 110px;">ИГРОКИ(<span><?php echo $percent ?>%</span>)<canvas width="110" height="110"></canvas></div>
							 </div>
							 </div>
						  </div>
						  </div>
						</div>
				  </div>
				  <?php endif; ?>
				  <!-- ////-->
				  <div class="col-lg-9">
					  <div class="col-lg-12">
							 <div class="panel">
						 					<img height="230px" width="100%" src="http://mini.s-shot.ru/1280x800/JPEG/1280/Z100/?<?php echo $webhost['web_domain'] ?>" alt="">
 </div>
						</div>
				  </div>
</div>


				<script>	
					$('#editForm').ajaxForm({ 
						url: '/webhost/control/ajax/<?php echo $webhost['web_id'] ?>',
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
					
					function sendAction(webid, action) {
						switch(action) {
							case "reinstall":
							{
								if(!confirm("Вы уверенны в том, что хотите переустановить сервер? Все данные будут удалены.")) return;
								break;
							}
						}
						$.ajax({ 
							url: '/webhost/control/action/'+webid+'/'+action,
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
					
					
					
					$('#payForm').ajaxForm({ 
						url: '/webhost/control/buy_months/<?php echo $webhost['web_id'] ?>',
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
					 $(document).ready(function() {
						updatePrice();
					});
					
					function updatePrice() {
						var price2 = <?php echo $webhost['tarif_price'] ?>;
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
<?php echo $footer ?>