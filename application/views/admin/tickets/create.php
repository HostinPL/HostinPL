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
									Новое обращение
								</h3>
							</div>
						</div>
					</div>
					<div class="m-portlet__body">
						<form class="form-group form-md-line-input" action="#" id="createForm" method="POST">
						<div class="form-group form-md-line-input">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Введите тему обращения">
                        </div>
                        <div class="form-group form-md-line-input">
                            <input type="text" class="form-control" id="pid" name="pid" placeholder="Введите ID клиента">
                        </div>
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
					$('#createForm').ajaxForm({ 
						url: '/admin/tickets/create/ajax',
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
									setTimeout("redirect('/admin/tickets/view/index/" + data.id + "')", 1500);
									break;
							}
						},
						beforeSubmit: function(arr, $form, options) {
							$('button[type=submit]').prop('disabled', true);
						}
					});
				</script>
<?php echo $footer ?>
