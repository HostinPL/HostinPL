<?php
/*
Copyright (c) 2018 HOSTINPL https://vk.com/hosting_rus
Developed by Samir Shelenko
*/
?>
<?php echo $header ?>
<div class="col-12">
<br>
	<!--begin::Portlet-->
	<form class="m-form m-form--label-align-left- m-form--state-" action="#" id="orderForm" method="POST">
	<div class="m-portlet m-portlet--last m-portlet--head-lg m-portlet--responsive-mobile" id="main_portlet">
		<div class="m-portlet__head" style="">
			<div class="m-portlet__head-progress">
			<!-- here can place a progress bar-->
			</div>
			<div class="m-portlet__head-wrapper">
				<div class="m-portlet__head-caption">
					<div class="m-portlet__head-title">
						<span class="m-portlet__head-icon">
							<i class="flaticon-cart"></i>
						</span>
						<h3 class="m-portlet__head-text"><strong for="price">Итого к оплате: </strong>
                            <span id="price"> 0.00 руб.</span></h3>
					</div>
				</div>
				<div class="m-portlet__head-tools">
					<button type="button" onClick="genPass()" class="btn btn-secondary m-btn m-btn--icon m-btn--wide m-btn--md m--margin-right-10">
						<span>
							<i class="flaticon-puzzle"></i>
							<span>Генерировать пароль</span>
						</span>
					</button>
					<div class="btn-group">
						<button type="submit" class="btn btn-brand  m-btn m-btn--icon m-btn--wide m-btn--md">
							<span>
								<i class="la la-check"></i>
									<span>Заказать</span>
							</span>
						</button>								
				</div>
			</div>
		</div>
	</div>
	<div class="m-portlet__body">
			<!--begin: Form Body -->
			<div class="m-portlet__body">
				<div class="row">
					<div class="col-xl-8 offset-xl-2">
						<div class="form-group form-md-line-input">
                            <select class="form-control" id="gameid" name="gameid" aria-required="true" aria-invalid="false" aria-describedby="delivery-error" onChange="updateForm()">
                                <?php foreach($games as $item): ?> 
								<option value="<?php echo $item['game_id'] ?>"><?php echo $item['game_name'] ?></option>
								<?php endforeach; ?>
							</select>
                        </div>
						<div class="form-group form-md-line-input">
                            <select class="form-control" id="locationid" name="locationid" aria-required="true" aria-invalid="false" aria-describedby="delivery-error">
								<?php foreach($locations as $item): ?> 
								<option value="<?php echo $item['location_id'] ?>"><?php echo $item['location_name'] ?> | Загруженность <?php echo $item['location_cpu'] ?>%</option>
								<?php endforeach; ?>
							</select> 
                        </div>					
						<div class="form-group form-md-line-input">
                        <select class="form-control" id="months" name="months" aria-required="true" aria-invalid="false" aria-describedby="delivery-error" onChange="updateForm()">
								<option value="1">30 дней</option>
								<option value="3">90 дней (-5%)</option>
								<option value="6">180 дней (-10%)</option>
								<option value="12">360 дней (-15%)</option>
                     			<?if($serv_test == 1):?>
								<option value="0">Тестовый период 3 дня</option>
								<?endif;?>
						</select>
                        </div>
                        <div class="form-group form-md-line-input">
								<div class="input-group">
									<div class="input-group-prepend">
										<button class="btn btn-secondary" type="button" onclick="plusSlots()"><i class="fa fa-angle-up"></i></button>
									</div>
									<input class="form-control" id="slots" name="slots" onkeyup="updateForm(true)">
									<div class="input-group-append">
										<button class="btn btn-secondary" type="button" onclick="minusSlots()"><i class="fa fa-angle-down"></i></button>
									</div>
								</div>
						</div>
						<div class="form-group form-md-line-input">
                        <input type="text" class="form-control" id="password" name="password" placeholder="Пароль">
                        </div>
                        <div class="form-group form-md-line-input">
                        <input type="text" class="form-control" id="password2" name="password2" placeholder="Повторите пароль">
                        </div>
                        <div class="orm-group form-md-line-input">
							<div class="input-group">
								<input id="promo" class="form-control" type="promo" name="promo" placeholder="Промо код">
								<div class="input-group-append">
									<button onclick="promoCode()" class="btn btn-primary" type="button">Проверить!</button>
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
	<!--end::Portlet-->
</div>

<script>
					var gameData = {
					<?php foreach($games as $item): ?> 
						<?php echo $item['game_id'] ?>: {
							'minslots': <?php echo $item['game_min_slots'] ?>,
							'maxslots': <?php echo $item['game_max_slots'] ?>,
							'price': <?php echo $item['game_price'] ?>
						},
					<?php endforeach; ?> 
					};
					
					$('#orderForm').ajaxForm({ 
						url: '/servers/order/ajax',
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
									setTimeout("redirect('/servers/control/index/" + data.id + "')", 1500);
									break;
							}
						},
						beforeSubmit: function(arr, $form, options) {
							$('button[type=submit]').prop('disabled', true);
							toastr.warning("Идет просмотр настроек сервера. И подготовка к установке.");
						}
					});
					
					$(document).ready(function() {
						updateForm();
					});
					
					function promoCode(){
						var promo = $("#promo").val();
						$.post("/servers/order/promo",{code: promo},function(data){
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
						var gameID = $("#gameid option:selected").val();
						var slots = $("#slots").val();
						if(slots < gameData[gameID]['minslots']) {
							slots = gameData[gameID]['minslots'];
							$("#slots").val(slots);
						}
						if(slots > gameData[gameID]['maxslots']) {
							slots = gameData[gameID]['maxslots'];
							$("#slots").val(slots);
						}
						var price = gameData[gameID]['price'] * slots;
						var months = $("#months option:selected").val();
						switch(months) {
							case "0":
								price = 0;
								break;
							case "1":
								break;
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

					function generatePwd() {
						var length = 8,
							charset = "abcdefghijklnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789",
							retVal = "";
						for (var i = 0, n = charset.length; i < length; ++i) {
							retVal += charset.charAt(Math.floor(Math.random() * n));
						}
						return retVal;
					}
			
					function genPass() {
						document.getElementById('password').type = 'text';
						document.getElementById('password2').type = 'text';
						iString = generatePwd();
						$('#password').val(iString);
						$('#password2').val(iString);
					}
				</script>
<?php echo $footer ?>