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
									<i class="flaticon-music-1"></i>
								</span>
								<h3 class="m-portlet__head-text">
									Редактирование новости
								</h3>
							</div>
						</div>
						<div class="m-portlet__head-tools">
							<a href="/admin/news/edit/delete/<?php echo $new['news_id'] ?>" class="btn btn-accent m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill m-btn--air">
								<i class="flaticon-delete-2"></i>
							</a>
						</div>
					</div>
					<div class="m-portlet__body">
						<form class="form-group form-md-line-input" action="#" id="editForm" method="POST">
						<div class="form-group form-md-line-input">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Введите заголовок" value="<?php echo $new['news_title'] ?>">
                        </div>
                        <div class="form-group form-md-line-input">
                            <select class="form-control" id="place" name="place" aria-required="true" aria-invalid="false" aria-describedby="delivery-error">
                                <option value="1" <?if($new['place'] == 1):?>selected=""<?endif;?>>Разместить в "Новости"</option>
								<option value="2" <?if($new['place'] == 2):?>selected=""<?endif;?>>Разместить в "Главная"</option>
                            </select>
                        </div>
                        <div class="form-group form-md-line-input">
                            <select class="form-control" id="category" name="category" aria-required="true" aria-invalid="false" aria-describedby="delivery-error">
								<?php foreach($category as $item): ?> 
								<option value="<?php echo $item['category_id'] ?>" <?if($item['category_id'] == $new['category_id']):?>selected=""<?endif;?>><?php echo $item['category_name'] ?></option>
								<?php endforeach; ?> 
                            </select>
                        </div>
                        <div class="form-group form-md-line-input">
                            <textarea class="form-control" id="text" name="text" rows="3"> <?echo $new['news_text']?></textarea>
                        </div> 
                        <div class="m-portlet__foot">
                            <div class="m--align-center">
                                <a href="/admin/news" class="btn btn-secondary m-btn m-btn--icon m-btn--wide m-btn--md m--margin-right-10 m-btn--air">
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
						url: '/admin/news/edit/ajax/<?php echo $new['news_id'] ?>',
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
									setTimeout("redirect('/admin/news')", 1500);
									break;
							}
						},
						beforeSubmit: function(arr, $form, options) {
							$('button[type=submit]').prop('disabled', true);
						}
					});
</script>
<?php echo $footer ?>
