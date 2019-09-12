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
									<i class="flaticon-speech-bubble"></i>
								</span>
								<h3 class="m-portlet__head-text">
									Отправка ответа
								</h3>
							</div>
						</div>
					</div>
					<div class="m-portlet__body">
						<form class="form-group form-md-line-input" action="#" id="sendMForm" method="POST">
						<div class="m-widget3">
							<div class="m-widget3__item">
								<div class="m-widget3__header">
									<div class="m-widget3__user-img">
										<img class="m-widget3__img" src="/application/public/img/user.png" alt="">
									</div>
									<div class="m-widget3__info">
										<span class="m-widget3__username"><?php echo $mail['user_firstname'] ?> <?php echo $mail['user_lastname'] ?></span>
										<br>
										<span class="m-widget3__time"><?php echo $mail['user_email'] ?></span>
									</div>
									<span class="m-widget3__status m--font-info"><?php echo $mail['inbox_date_add']?></span>
								</div>
								<div class="m-widget3__body">
									<p class="m-widget3__text"><?php echo $mail['text'] ?></p>
								</div>
							</div>
						</div>
						<div class="form-group form-md-line-input">
                            <textarea class="form-control" id="msg" name="msg" rows="3" placeholder="Сообщение..."></textarea>
                        </div> 
						<div class="m-form__group form-group">
                            <label class="m-checkbox m-checkbox--bold m-checkbox--state-brand">
                                <input type="checkbox" class="md-check" id="dell" name="dell"> Удалить после отправки
                                <span></span>
                            </label>
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
	$('#sendMForm').ajaxForm({ 
		url: '/admin/infobox/send/sendMForm/<?php echo $mail['id'] ?>',
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
					setTimeout("redirect('/admin/infobox')", 1500);
					break;
			}
		},
		beforeSubmit: function(arr, $form, options) {
			$('button[type=submit]').prop('disabled', true);
		}
	});
</script>
<?php echo $footer ?>
