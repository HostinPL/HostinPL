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
									<i class="flaticon-gift"></i>
								</span>
								<h3 class="m-portlet__head-text">
									Редактирование промо-кода
								</h3>
							</div>
						</div>
						<div class="m-portlet__head-tools">
							<a href="/admin/promo/edit/delete/<?php echo $promo['id'] ?>" class="btn btn-accent m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill m-btn--air">
								<i class="flaticon-delete-2"></i>
							</a>
						</div>
					</div>
					<div class="m-portlet__body">
						<form class="form-group form-md-line-input" action="#" id="editForm" method="POST">
						<div class="form-group form-md-line-input">
                            <input type="text" class="form-control" id="cod" name="cod" placeholder="Введите промо-код" value="<?php echo $promo['cod'] ?>">
                        </div>
                        <div class="form-group form-md-line-input">
                            <select class="form-control" id="skidka" name="skidka" aria-required="true" aria-invalid="false" aria-describedby="delivery-error">
							    <option value="5" <?php if($promo['skidka'] == 5): ?> selected="selected"<?php endif; ?>>5%</option>
								<option value="10" <?php if($promo['skidka'] == 10): ?> selected="selected"<?php endif; ?>>10%</option>
								<option value="15" <?php if($promo['skidka'] == 15): ?> selected="selected"<?php endif; ?>>15%</option>
								<option value="20" <?php if($promo['skidka'] == 20): ?> selected="selected"<?php endif; ?>>20%</option>
								<option value="25" <?php if($promo['skidka'] == 25): ?> selected="selected"<?php endif; ?>>25%</option>
								<option value="30" <?php if($promo['skidka'] == 30): ?> selected="selected"<?php endif; ?>>30%</option>
								<option value="35" <?php if($promo['skidka'] == 35): ?> selected="selected"<?php endif; ?>>35%</option>
								<option value="40" <?php if($promo['skidka'] == 40): ?> selected="selected"<?php endif; ?>>40%</option>
								<option value="45" <?php if($promo['skidka'] == 45): ?> selected="selected"<?php endif; ?>>45%</option>
								<option value="50" <?php if($promo['skidka'] == 50): ?> selected="selected"<?php endif; ?>>50%</option>
								<option value="55" <?php if($promo['skidka'] == 55): ?> selected="selected"<?php endif; ?>>55%</option>
								<option value="60" <?php if($promo['skidka'] == 60): ?> selected="selected"<?php endif; ?>>60%</option>
								<option value="65" <?php if($promo['skidka'] == 65): ?> selected="selected"<?php endif; ?>>65%</option>
								<option value="70" <?php if($promo['skidka'] == 70): ?> selected="selected"<?php endif; ?>>70%</option>
								<option value="75" <?php if($promo['skidka'] == 75): ?> selected="selected"<?php endif; ?>>75%</option>
								<option value="80" <?php if($promo['skidka'] == 80): ?> selected="selected"<?php endif; ?>>80%</option>
								<option value="85" <?php if($promo['skidka'] == 85): ?> selected="selected"<?php endif; ?>>85%</option>
								<option value="90" <?php if($promo['skidka'] == 90): ?> selected="selected"<?php endif; ?>>90%</option>
								<option value="95" <?php if($promo['skidka'] == 95): ?> selected="selected"<?php endif; ?>>95%</option>
								<option value="100" <?php if($promo['skidka'] == 100): ?> selected="selected"<?php endif; ?>>100%</option>
                            </select>
                        </div>
                        <div class="form-group form-md-line-input">
                            <input type="text" class="form-control" id="uses" name="uses" placeholder="Введите количество использований" value="<?php echo $promo['uses'] ?>">
                        </div>
                        <div class="m-portlet__foot">
                            <div class="m--align-center">
                                <a href="/admin/promo" class="btn btn-secondary m-btn m-btn--icon m-btn--wide m-btn--md m--margin-right-10 m-btn--air">
                                    <span>
                                        <i class="la la-arrow-left"></i>
                                        <span>Отмена</span>
                                    </span>
                                </a>
                                <button type="submit" class="btn btn-brand  m-btn m-btn--icon m-btn--wide m-btn--md m-btn--air">
                                    <span>
                                        <i class="la la-check"></i>
                                        <span>Изменить</span>
                                    </span>
                                </button>
                            </div>
                        </div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
					$('#editForm').ajaxForm({ 
						url: '/admin/promo/edit/ajax/<?php echo $promo['id'] ?>',
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
									setTimeout("redirect('/admin/promo')", 1500);
									break;
							}
						},
						beforeSubmit: function(arr, $form, options) {
							$('button[type=submit]').prop('disabled', true);
						}
					});
</script>
<?php echo $footer ?>
