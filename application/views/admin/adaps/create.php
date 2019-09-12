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
                                    Создание дополнения
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        <form class="form-group form-md-line-input" action="#" id="createForm" method="POST">
                        <div class="form-group form-md-line-input">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Введите название дополнения">
                        </div>
                        <div class="form-group form-md-line-input">
                            <textarea class="form-control" id="textx" name="textx" rows="3" placeholder="Описание..."></textarea>
                        </div>
                        <div class="form-group form-md-line-input">
                            <input type="text" class="form-control" id="patch" name="patch" placeholder="Введите адрес установки (Пример: /plugins)">
                        </div>
                        <div class="form-group form-md-line-input">
                            <input type="text" class="form-control" id="img" name="img" placeholder="Введите ссылку на изображение">
                        </div>
                        <div class="form-group form-md-line-input">
                            <select class="form-control" id="gameid" name="gameid" aria-required="true" aria-invalid="false" aria-describedby="delivery-error">
                                <?php foreach($games as $item): ?> 
                                <option value="<?php echo $item['game_id'] ?>"><?php echo $item['game_name'] ?></option>
                                <?php endforeach; ?> 
                            </select>
                        </div>
                        <div class="form-group form-md-line-input">
                            <label for="upload" class="form-control"><input type="file" id="upload" name="userfile"></label>
                        </div>
                        <div class="form-group form-md-line-input">
                            <select class="form-control" id="act" name="act" aria-required="true" aria-invalid="false" aria-describedby="delivery-error">
                                <option value="1">Моды</option>
                                <option value="2">Плагины</option>
                                <option value="3">Разное</option>
                                <option value="4">Сборки</option>
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
                            <input type="text" class="form-control" id="price" name="price" placeholder="Введите стоимость дополнения" disabled>
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
                                        <span>Создать</span>
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
$('#createForm').ajaxForm({ 
	url: '/admin/adaps/create/ajax',
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

$(function(){
  var progressBar = $('#progressbar');
  $('#createForm').on('submit', function(e){
    e.preventDefault();
    var $that = $(this),
        formData = new FormData($that.get(0));
    $.ajax({
      url: $that.attr('action'),
      type: $that.attr('method'),
      contentType: false,
      processData: false,
      data: formData,
      dataType: 'json',
      xhr: function(){
        var xhr = $.ajaxSettings.xhr();
        xhr.upload.addEventListener('progress', function(evt){
          if(evt.lengthComputable) {
            var percentComplete = Math.ceil(evt.loaded / evt.total * 100);
            progressBar.val(percentComplete).text('Загружено ' + percentComplete + '%');
			toastr.info('Загружено ' + percentComplete + '%');
          }
        }, false);
        return xhr;
      },
      success: function(json){
        if(json){
          $that.after(json);
        }
      }
    });
  });
});
</script>
<?php echo $footer ?>