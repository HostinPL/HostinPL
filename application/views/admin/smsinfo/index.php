<?php
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
?>
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
									<i class="flaticon-paper-plane"></i>
								</span>
								<h3 class="m-portlet__head-text">
									Рассылка SMS
									<small class="lead" id="price">0.00 руб.</small>
								</h3>
							</div>
						</div>
						<div class="m-portlet__head-tools">
							<form class="form-horizontal" id="sms_check_balance_ajax" method="post" action="" novalidate="novalidate">
							<button type="submit" class="btn btn-accent m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill m-btn--air">
								<i class="la la-refresh"></i>
							</button>
						    </form>
						</div>
					</div>
					<div class="m-portlet__body">
						<form action="#" id="editForm" method="POST">
						<div class="form-group form-md-line-input">
                            <textarea class="form-control" id="text" name="text" rows="3" placeholder="Сообщение..."></textarea>
                        </div>
                        <div class="form-group form-md-line-input">
                            <input type="text" class="form-control" d="to" name="to" placeholder="Введите номер">
                        </div>
                        <div class="form-group form-md-line-input">
                            <input type="text" class="form-control" id="from" name="from" placeholder="Введите Имя отправителя">
                        </div>
                        <div class="form-group form-md-line-input">
                            <input type="text" class="form-control" id="password" name="password" placeholder="Введите секретный ключ API">
                        </div>
                        <hr>
                        <button type="submit" class="btn btn-brand m-btn m-btn--air btn-outline  btn-block sbold uppercase">Отправить</button>
                        </form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
  $('#sms_check_balance_ajax').ajaxForm({ 
		url: '/admin/smsinfo/index/sms_check_balance_ajax',
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
			$("#price").html(data.success)
			$("#price").html(data.sum)
			  toastr.info(data.success);
			break;
		  }
		},
		beforeSubmit: function(arr, $form, options) {
		}
	});
</script>
<script>
	$('#editForm').ajaxForm({ 
		url: '/admin/smsinfo/index/ajax/',
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
			//$('button[type=submit]').prop('disabled', true);
		}
	});
</script>
<?php echo $footer ?>