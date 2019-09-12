<?php
// *************************************************************************
// *                                                                       *
// * Copyright (c) 2016.04.10 LiteDevel Pereload By Enabled2K              *
// * Copyright (c) SMRPanel Ltd. All Rights Reserved,                      *
// * Version: 7.0.0 (7.0.0-release.3)                                      *
// * BuildId: e6c0f3e.47                                                   *
// * Build Date: 07 8 2016                                                 *
// *                                                                       *
// *************************************************************************
// *                                                                       *
// * Email: info@smrgames.ru                                               *
// * Website: http://smrgames.ru                                           *
// *                                                                       *
// *************************************************************************
?>
<?php echo $Aheader ?>
            <main id="main-container">
                    <div class="block">
                        <div class="block-header">
                            <h3 class="block-title">Репозиторий - Редактирование</h3>
                        </div>
									<form class="form-horizontal" action="#" id="createForm" method="POST">
					<div class="form-group">
						<label for="name" class="col-sm-3 control-label">Название:</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="name" name="name" value="<?php echo $adap['adap_name'] ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="textx" class="col-sm-3 control-label">Описание:</label>
						<div class="col-sm-8">
						<!--	<input type="text" class="form-control" id="textx" name="textx" placeholder="Укажите описание плагина/мода"> -->
							<textarea class="form-control" id="textx" name="textx" rows="5" value="<?php echo $adap['adap_textx'] ?>"></textarea>
						</div>
					</div>
					<div class="form-group">
						<label for="patch" class="col-sm-3 control-label">Куда установить:</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="patch" name="patch" value="<?php echo $adap['adap_patch'] ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="img" class="col-sm-3 control-label">Картинка:</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="img" name="img" value="<?php echo $adap['adap_img'] ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="gameid" class="col-sm-3 control-label">Игра:</label>
						<div class="col-sm-4">
							<select class="form-control" id="gameid" name="gameid" onChange="updateForm()">
								<?php foreach($games as $item): ?> 
								<option value="<?php echo $item['game_id'] ?>" <?php if($adap['game_id'] == $item['game_id']): ?> selected="selected"<?php endif; ?>><?php echo $item['game_name'] ?></option>
								<?php endforeach; ?> 
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="arch" class="col-sm-3 control-label">Ссылка на архив:</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="arch" name="arch" value="<?php echo $adap['adap_url'] ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="narch" class="col-sm-3 control-label">Имя_архива:</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="narch" name="narch" value="<?php echo $adap['adap_arch'] ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="act" class="col-sm-3 control-label">Классификация:</label>
						<div class="col-sm-4">				
							<select class="form-control" id="act" name="act">
								<option value="0" <?php if($adap['adap_act'] == 0): ?> selected="selected"<?php endif; ?>>Сборка</option>
								<option value="1" <?php if($adap['adap_act'] == 1): ?> selected="selected"<?php endif; ?>>Мод</option>
								<option value="2" <?php if($adap['adap_act'] == 2): ?> selected="selected"<?php endif; ?>>Плагин</option>
								<option value="3" <?php if($adap['adap_act'] == 3): ?> selected="selected"<?php endif; ?>>Разное</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="nact" class="col-sm-3 control-label">Action:</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="nact" name="nact" value="<?php echo $adap['adap_action'] ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="status" class="col-sm-3 control-label">Статус:</label>
						<div class="col-sm-3">
							<select class="form-control" id="status" name="status">
								<option value="0"<?php if($adap['adap_status'] == 0): ?> selected="selected"<?php endif; ?>>Выключена</option>
								<option value="1"<?php if($adap['adap_status'] == 1): ?> selected="selected"<?php endif; ?>>Включена</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-3 col-sm-9">
							<button type="submit" class="btn btn-primary">Изменить</button>	
					        <a href="/admin/adaps/edit/delete/<?php echo $adap['adap_id'] ?>" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span> Удалить дополнение</a>
						</div>
					</div>
				</div>
			</div>
		
				</form>
		 <!-- Page JS Plugins -->
  <script src="/application/public/js/plugins/tinymce/tinymce.min.js"></script>
  <script>
  tinymce.init({
    selector: '#textx',
    height: 500,
    theme: 'modern',
    plugins: [
      'advlist autolink lists link image charmap print preview hr anchor pagebreak',
      'searchreplace wordcount visualblocks visualchars code fullscreen',
      'insertdatetime media nonbreaking save contextmenu directionality',
      'emoticons template paste textcolor colorpicker textpattern imagetools'
    ],
    image_advtab: true,
    content_css: [
      '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
      '//www.tinymce.com/css/codepen.min.css'
    ]
   });
  </script>	
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
