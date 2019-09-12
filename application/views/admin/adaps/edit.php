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
									<i class="flaticon-open-box"></i>
								</span>
								<h3 class="m-portlet__head-text">
									Редактирование дополнения
								</h3>
							</div>
						</div>
						<div class="m-portlet__head-tools">
							<a href="/admin/adaps/edit/delete/<?php echo $adap['adap_id'] ?>" class="btn btn-accent m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill m-btn--air">
								<i class="flaticon-delete-2"></i>
							</a>
						</div>
					</div>
					<div class="m-portlet__body">
						<form class="form-group form-md-line-input" action="#" id="editForm" method="POST">
						<div class="form-group form-md-line-input">
                            <input type="text" class="form-control" id="name" name="name" value="<?php echo $adap['adap_name'] ?>" placeholder="Введите название дополнения">
                        </div>
                        <div class="form-group form-md-line-input">
                            <textarea class="form-control" id="textx" name="textx" rows="3" placeholder="Описание..."><?php echo $adap['adap_textx'] ?></textarea>
                        </div>
                        <div class="form-group form-md-line-input">
                            <input type="text" class="form-control" id="patch" name="patch" value="<?php echo $adap['adap_patch'] ?>" placeholder="Введите адрес установки (Пример: /plugins)">
                        </div>
                        <div class="form-group form-md-line-input">
                            <input type="text" class="form-control" id="img" name="img" value="<?php echo $adap['adap_img'] ?>" placeholder="Введите ссылку на изображение">
                        </div>
                        <div class="form-group form-md-line-input">
                            <select class="form-control" id="gameid" name="gameid" onChange="updateForm()">
                                <?php foreach($games as $item): ?> 
                                <option value="<?php echo $item['game_id'] ?>" <?php if($adap['game_id'] == $item['game_id']): ?> selected="selected"<?php endif; ?>><?php echo $item['game_name'] ?></option>
                                <?php endforeach; ?> 
                            </select>
                        </div>
                        <div class="form-group form-md-line-input">
                            <input type="text" class="form-control" id="arch" name="arch" value="<?php echo $adap['adap_url'] ?>" placeholder="Введите ссылку на архив">
                        </div>
                        <div class="form-group form-md-line-input">
                            <select class="form-control" id="act" name="act">
                                <option value="0" <?php if($adap['adap_act'] == 0): ?> selected="selected"<?php endif; ?>>Сборка</option>
                                <option value="1" <?php if($adap['adap_act'] == 1): ?> selected="selected"<?php endif; ?>>Мод</option>
                                <option value="2" <?php if($adap['adap_act'] == 2): ?> selected="selected"<?php endif; ?>>Плагин</option>
                                <option value="3" <?php if($adap['adap_act'] == 3): ?> selected="selected"<?php endif; ?>>Разное</option>
                            </select>
                        </div>
                        <hr>
                        <div class="m-form__group form-group">
                            <label class="m-checkbox m-checkbox--bold m-checkbox--state-brand">
                                <input type="checkbox" class="md-check" id="category" name="category" onChange="toggleBuy()"> Установить стоимость
                                <span></span>
                            </label>
                        </div>
                        <div class="form-group form-md-line-input">
                            <input type="text" class="form-control" id="price" name="price" value="<?php echo $adap['adap_price'] ?>"placeholder="Введите стоимость дополнения" disabled>
                        </div>
                        <div class="form-group form-md-line-input">
                            <select class="form-control" id="status" name="status">
                                <option value="0"<?php if($adap['adap_status'] == 0): ?> selected="selected"<?php endif; ?>>Выключена</option>
                                <option value="1"<?php if($adap['adap_status'] == 1): ?> selected="selected"<?php endif; ?>>Включена</option>
                            </select>
                        </div>
                        <div class="m-portlet__foot">
                            <div class="m--align-center">
                                <a href="/admin/adaps" class="btn btn-secondary m-btn m-btn--icon m-btn--wide m-btn--md m--margin-right-10 m-btn--air">
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
						url: '/admin/adaps/edit/ajax/<?php echo $adap['adap_id'] ?>',
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
									setTimeout("redirect('/admin/adaps')", 1500);
									break;
							}
						},
						  beforeSubmit: function(arr, $form, options) {
        $('button[type=submit]').prop('disabled', true);
    }
});
function toggleBuy() {
    var status = $('#category').is(':checked');
    if(status) {
        $('#price').prop('disabled', false);
    } else {
        $('#price').prop('disabled', true);
    }
}
				</script>
<?php echo $footer ?>
