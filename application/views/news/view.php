<?php if(!$nolog) 
{
echo $loginheader;
}else echo $header;?>
<div class="col-12">
    <div class="m-content">
        <div class="m-portlet m-portlet--brand m-portlet--head-solid-bg">
			<div class="m-portlet__head">
				<div class="m-portlet__head-caption">
					<div class="m-portlet__head-title">
						<span class="m-portlet__head-icon">
							<i class="flaticon-notes"></i>
						</span>
						<h3 class="m-portlet__head-text">
							<?echo $new['news_title']?>
							<small><?echo $new['look']?> Просмотров.</small>
						</h3>
					</div>
				</div>
				<div class="m-portlet__head-tools">
					<h5 class="m-portlet__head-text">
						<small><?echo $new['news_date_add']?></small>
					</h5>
				</div>
			</div>
			<div class="m-portlet__body">
				<?echo nl2br($new['news_text'])?>
				<hr>
			</div>
		</div>
		<form id="sendForm" action="" method="POST">
		<div class="m-portlet m-portlet--brand m-portlet--head-solid-bg">
			<div class="m-portlet__head">
				<div class="m-portlet__head-caption">
					<div class="m-portlet__head-title">
						<span class="m-portlet__head-icon">
							<i class="flaticon-paper-plane"></i>
						</span>
						<h3 class="m-portlet__head-text">
                            Оставить комментарий
						</h3>
					</div>
				</div>
			</div>
			<div class="m-portlet__body">
				<?if(!$nolog):?>
	            <div class="alert alert-danger">
                    Гости не могут оставлять коментарии.
                </div>
                <?else:?>	
				<div class="media-body">
					<textarea class="form-control todo-taskbody-taskdesc" rows="4" name="text" id="text"></textarea>
				</div>
				<hr>
				<button type="submit" class="btn btn-brand m-btn m-btn--air btn-outline  btn-block sbold uppercase">Оставить комментарий</button>
			</div>
		</div>
		<?if($messages):?>
		<div class="m-portlet m-portlet--brand m-portlet--head-solid-bg">
			<div class="m-portlet__head">
				<div class="m-portlet__head-caption">
					<div class="m-portlet__head-title">
						<span class="m-portlet__head-icon">
							<i class="flaticon-users"></i>
						</span>
						<h3 class="m-portlet__head-text">
                            Комментарии
						</h3>
					</div>
				</div>
			</div>
			<div class="m-portlet__body">
				<div class="m-widget3">
					<?php foreach($messages as $item): ?>
					<div class="m-widget3__item">
						<div class="m-widget3__header">
							<div class="m-widget3__user-img">
								<img class="m-widget3__img" src="<?php echo $url ?><?if($item['user_img']) {echo $item['user_img'];}else{ echo '/application/public/img/user.png';}?>" alt="">
							</div>
							<div class="m-widget3__info">
								<span class="m-widget3__username">
									<?php if($item['user_firstname']){echo $item['user_firstname'];} else {echo 'Гость';} ?> <?php echo $item['user_lastname'] ?>
								</span>
								<br>
								<span class="m-widget3__time">
									<?php echo date("d.m.Y в H:i", strtotime($item['news_message_date_add'])) ?>
								</span>
							</div>
							<span class="m-widget3__status m--font-brand">
								<?php if($item['user_access_level'] == 1): ?>
								Пользователь
								<?php endif; ?>
								<?php if($item['user_access_level'] == 2): ?>
								Тех.поддержка
								<?php endif; ?>
								<?php if($item['user_access_level'] == 3): ?>
								Администратор
								<?php endif; ?>
							</span>
						</div>
						<div class="m-widget3__body">
							<p class="m-widget3__text">
								<?php echo nl2br($item['news_message']) ?>
							</p>
						</div>
					</div>
					<?php endforeach; ?>
					<?endif;?>
				</div>
			</div>
		</div>
		<?endif;?>
		</form>	
	</div>
</div>
<script>
$('#sendForm').ajaxForm({ 
url: '/news/view/ajax/<?php echo $new['news_id'] ?>',						
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
									$('#text').val('');
									setTimeout("reload()", 1500);
									ajax_url("/news/view/"+data);
									break;
							}
						},
						beforeSubmit: function(arr, $form, options) {
							$('button[type=submit]').prop('disabled', true);
						}
					});</script>
					<script type="text/javascript">
$(function(){
$('#form_pr').submit(function(e){
//отменяем стандартное действие при отправке формы
e.preventDefault();
//берем из формы метод передачи данных
var m_method=$(this).attr('method');
//получаем данные, введенные пользователем в формате input1=value1&input2=value2...,то есть в стандартном формате передачи данных формы
var m_data=$(this).serialize();
$.ajax({
type: m_method,
url: '/news/view/ajax/<?php echo $news['news_id'] ?>',	
data: m_data,
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
									$('#text').val('');
									setTimeout("reload()", 1500);
									break;
							}
							
						 },
						beforeSubmit: function(arr, $form, options) {
							$('button[type=submit]').prop('disabled', true);
						}
});
});
});
</script>
<?php if(!$nolog) 
{
echo $loginfooter;
}else echo $footer;?>