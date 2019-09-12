<?php
/*
Copyright (c) 2017 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
?>
<?php echo $admheader ?>
<div class="row">
	<div class="col-md-7">
		<div class="portlet light">
			<div class="portlet-title" style="margin-bottom: 0px;">
				<div class="caption caption-md">
					<span class="caption-subject font-blue-madison bold uppercase">Редактирование категории </span>
				</div>
			</div>
			<div class="portlet-body">
								<form class="form-group form-md-line-input" action="#" id="editForm" method="POST">
                                        <div class="form-group form-md-line-input">
                                                <input type="text" class="form-control" id="name" name="name" placeholder="Введите название" value="<?php echo $category['category_name'] ?>">
                                                <label for="name">Название</label>
                                                <span class="help-block">Пример: Важные</span>
                                        </div>
                                        <div class="form-group form-md-line-input">
                                                <select class="form-control" id="status" name="status" aria-required="true" aria-invalid="false" aria-describedby="delivery-error">
                                                    <option value="0"<?php if($category['category_status'] == 0): ?> selected="selected"<?php endif; ?>>Выключена</option>
                                                    <option value="1"<?php if($category['category_status'] == 1): ?> selected="selected"<?php endif; ?>>Включена</option>
                                                </select><span id="delivery-error" class="help-block help-block-error"></span>
                                                <label for="form_control_1">Статус категории</label>
                                                <span class="help-block">Вы выбрали статус категории</span>
                                        </div>
                                        <br>
			</div>	
			</div>
		</div>
<div class="col-md-5">
	<div class="portlet light">
		<div class="portlet-title" style="margin-bottom: 0px;">
				<div class="caption caption-md">
					<span class="caption-subject font-blue-madison bold uppercase">Действие </span>
				</div>
			</div>
			<br>
						<div class="form-actions">
						<center>
                            <button type="submit" class="btn green">Изменить</button>
                            <a href="/admin/ticketcategory/edit/delete/<?php echo $category['category_id'] ?>" type="button" class="btn default">Удалить</a>
                        </center>
            </div>
		</div>
	</div>
</div>
</form>
				<script>
					$('#editForm').ajaxForm({ 
						url: '/admin/ticketcategory/edit/ajax/<?php echo $category['category_id'] ?>',
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
									setTimeout("redirect('/admin/ticketcategory')", 1500);
									break;
							}
						},
						beforeSubmit: function(arr, $form, options) {
							$('button[type=submit]').prop('disabled', true);
						}
					});
					function togglePassword() {
						var status = $('#editpassword').is(':checked');
						if(status) {
							$('#password').prop('disabled', false);
							$('#password2').prop('disabled', false);
						} else {
							$('#password').prop('disabled', true);
							$('#password2').prop('disabled', true);
						}
					}
				</script>
<?php echo $footer ?>
