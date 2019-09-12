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
									<i class="flaticon-bell"></i>
								</span>
								<h3 class="m-portlet__head-text">
									Рассылка E-mail
								</h3>
							</div>
						</div>
					</div>
					<div class="m-portlet__body">
						<form class="form-group form-md-line-input" action="#" id="editForm" method="POST">
						<div class="form-group form-md-line-input">
                            <textarea class="form-control" id="text" name="text" rows="3" placeholder="Сообщение..."></textarea>
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
					$('#editForm').ajaxForm({ 
						url: '/admin/emailinfo/index/ajax/',
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
							toastr.info("Рассылка начата!");
						}
					});
</script>
<?php echo $footer ?>
