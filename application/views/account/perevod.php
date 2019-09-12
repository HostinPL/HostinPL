<?php
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
?>
<?php echo $header ?>
<div class="col-12">
<br>
	<div class="m-portlet__body">
		<div class="m-section">
            <div class="m-portlet">
	            <div class="m-portlet__head">
		            <div class="m-portlet__head-caption">
			            <div class="m-portlet__head-title">
				            <h3 class="m-portlet__head-text">Перевод средств</h3>
			            </div>
		            </div>
	           </div>
	          <div class="m-portlet__body">
	          	<form class="form-group form-md-line-input" action="#" id="payForm" method="POST">
				<div class="form-group form-md-line-input">
					<input type="text" class="form-control" id="userid" name="userid" placeholder="ID Пользователя">
				</div>
				<div class="form-group form-md-line-input">
					<input type="text" class="form-control" id="sum" name="sum" placeholder="Сумма">
				</div>
                <button type="submit" class="btn btn-accent m-btn m-btn--air btn-outline  btn-block sbold uppercase">Перевести средства</button>
		        </form>
	          </div>
            </div>
        </div>
    </div>
</div>
<script>
	$('#payForm').ajaxForm({
		url: '/account/perevod/ajax',
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
			$('button[type=submit]').prop('disabled', false);
		},
		beforeSubmit: function(arr, $form, options) {
			$('button[type=submit]').prop('disabled', true);
		}
	});
</script>
<?php echo $footer ?>
