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
									<i class="fa fa-gamepad"></i>
								</span>
								<h3 class="m-portlet__head-text">
									Редактирование игры
								</h3>
							</div>
						</div>
						<div class="m-portlet__head-tools">
							<a href="/admin/games/edit/delete/<?php echo $game['game_id'] ?>" class="btn btn-accent m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill m-btn--air">
								<i class="flaticon-delete-2"></i>
							</a>
						</div>
					</div>
					<div class="m-portlet__body">
						<form class="form-group form-md-line-input" action="#" id="editForm" method="POST">
						<div class="form-group form-md-line-input">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Введите название игры" value="<?php echo $game['game_name'] ?>">
                        </div>
                        <div class="form-group form-md-line-input">
                            <input type="text" class="form-control" id="code" name="code" placeholder="Введите код игры" value="<?php echo $game['game_code'] ?>">
                        </div>
                        <div class="form-group form-md-line-input">
                            <input type="text" class="form-control" id="query" name="query" placeholder="Введите query-драйвер" value="<?php echo $game['game_query'] ?>">
                        </div>
                        <div class="form-group form-md-line-input">
                            <input type="text" class="form-control" id="minslots" name="minslots" placeholder="Введите минимальное количество слотов для заказа" value="<?php echo $game['game_min_slots'] ?>">
                        </div>
                        <div class="form-group form-md-line-input">
                            <input type="text" class="form-control" id="maxslots" name="maxslots" placeholder="Введите максимальное количество слотов для заказа" value="<?php echo $game['game_max_slots'] ?>">
                        </div>
                        <div class="form-group form-md-line-input">
                            <input type="text" class="form-control" id="minport" name="minport" placeholder="Введите минимальный порт для заказа" value="<?php echo $game['game_min_port'] ?>">
                        </div>
                        <div class="form-group form-md-line-input">
                            <input type="text" class="form-control" id="maxport" name="maxport" placeholder="Введите максимальное порт для заказа" value="<?php echo $game['game_max_port'] ?>">
                        </div>
                        <div class="form-group form-md-line-input">
                            <input type="text" class="form-control" id="price" name="price" placeholder="Введите стоимость за один слот" value="<?php echo $game['game_price'] ?>">
                        </div>
                        <div class="form-group form-md-line-input">
                            <select class="form-control" id="status" name="status" name="delivery" aria-required="true" aria-invalid="false" aria-describedby="delivery-error">
                                <option value="1"<?php if($game['game_status'] == 1): ?> selected="selected"<?php endif; ?>>Включена</option>
                                <option value="0"<?php if($game['game_status'] == 0): ?> selected="selected"<?php endif; ?>>Выключена</option>
                            </select>
                        </div>
                        <div class="m-portlet__foot">
                            <div class="m--align-center">
                                <a href="/admin/games" class="btn btn-secondary m-btn m-btn--icon m-btn--wide m-btn--md m--margin-right-10 m-btn--air">
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
						url: '/admin/games/edit/ajax/<?php echo $game['game_id'] ?>',
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
                                    showSuccess(data.success);
                                    setTimeout("redirect('/admin/games')", 1500);
									break;
							}
						},
						beforeSubmit: function(arr, $form, options) {
							$('button[type=submit]').prop('disabled', true);
						}
					});
</script>
<?php echo $footer ?>
