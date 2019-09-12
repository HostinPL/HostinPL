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
<?php echo $header; ?>

		
<div class="row">
<div class="col-md-12">
				<div class="portlet light">
	<div class="portlet-title" style="margin-bottom: 0px;">
		<div class="caption caption-md">
			<i class="icon-bar-chart theme-font hide"></i>
												<span class="caption-subject font-blue-madison bold uppercase">
									Заказ Веб-Хостинга </span>
									
								</div>
							</div>
							<div class="portlet-body">
								<p>
<form class="form-horizontal" action="#" id="orderForm" method="POST" autocomplete="off">
					<div class="form-group">
						<label for="locationid" class="col-sm-3 control-label">Локация:</label>
						<div class="col-sm-5">
							<select class="form-control" id="locationid" name="locationid">
								<?php foreach($locations as $item): ?> 
								<option value="<?php echo $item['location_id'] ?>"><?php echo $item['location_name'] ?></option>
								<?php endforeach; ?> 
							</select>
						</div>
					</div>
										<div class="form-group">
						<label for="tarifid" class="col-sm-3 control-label">Тариф:</label>
						<div class="col-sm-5">
							<select class="form-control" id="tarifid" name="tarifid">
								<?php foreach($tarifs as $item): ?> 
								<option value="<?php echo $item['tarif_id'] ?>"><?php echo $item['tarif_name'] ?></option>
								<?php endforeach; ?> 
							</select>
						</div>
					</div>
										<div class="form-group">
						<label for="domain" class="col-sm-3 control-label">Домен:</label>
						<div class="col-sm-4">
							<input type="domain" class="form-control" id="domain" name="domain" autocomplete="off" placeholder="Введите домен">
						</div>
					</div>
					<div class="form-group">
						<label for="months" class="col-sm-3 control-label">Период оплаты:</label>
						<div class="col-sm-3">
							<select class="form-control" id="months" name="months" onChange="updateForm()">
								<option value="1">1 месяц</option>
								<option value="3">3 месяца (-5%)</option>
								<option value="6">6 месяцев (-10%)</option>
								<option value="12">12 месяцев (-15%)</option>
							</select>
						</div>
					</div>
														
					

					<div class="form-group">
						<label for="promo" class="col-sm-3 control-label">Промо Код:</label>
						<div class="col-sm-4">
							<input type="promo" class="form-control" onChange="promoCode()" id="promo" name="promo" placeholder="Введите промо Код">
						</div>
					</div>
					<div class="form-group">
						<label for="price" class="col-sm-3 control-label">Итого:</label>
						<div class="col-sm-5">
							<p class="lead" id="price">0.00 руб.</p>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-3 col-sm-9">
							<button type="submit" class="btn btn-primary">Заказать</button>
						</div>
					</div>
				</form>								</p>
							</div>
						</div>
				</div>
				</div>

				<script>

					var tarifData = {
					<?php foreach($tarifs as $item): ?> 
						<?php echo $item['tarif_id'] ?>: {
							'price': <?php echo $item['tarif_price'] ?>
						},
					<?php endforeach; ?> 
					};
					
					$('#orderForm').ajaxForm({ 
						url: '/webhost/order/ajax',
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
									setTimeout("redirect('/webhost/control/index/" + data.id + "')", 1500);
									break;
							}
						},
						beforeSubmit: function(arr, $form, options) {
							$('button[type=submit]').prop('disabled', true);
							toastr.warning("Идет просмотр настроек хостинга. И подготовка к установке.");
						}
					});
					
					$(document).ready(function() {
						updateForm();
					});
					function promoCode(){
						var promo = $("#promo").val();
						$.post("/webhost/order/promo",{code: promo},function(data){
							data = $.parseJSON(data);
							switch(data.status) {
								case 'error':
									toastr.error(data.error);
									updateForm();
									break;
								case 'success':
									toastr.success(data.success);
									updateForm(data.skidka);
									break;
							}
						});
						
					}
					
					function updateForm(promo) {
						var tarifID = $("#tarifid option:selected").val();
						var price = tarifData[tarifID]['price'];
						var months = $("#months option:selected").val();
						switch(months) {
							case "3":
								price = 3 * price * 0.95;
								break;
							case "6":
								price = 6 * price * 0.90;
								break;
							case "12":
								price = 12 * price * 0.85;
								break;
						}
						if(promo != null){price = price * promo;}
						
						$('#price').text(price.toFixed(2) + ' руб.');
					}

				</script>
<?php echo $footer ?>
