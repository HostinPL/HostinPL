<?php
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
?>
<?php include 'application/views/common/menuserver.php';?>
<div class="m-content">
	<div class="row">
	    <div class="col-xl-3 col-lg-4">
		    <div class="m-portlet m-portlet--full-height   m-portlet--unair">
			    <div class="m-portlet__body">
				    <div class="m-card-profile">
					    <div class="m-card-profile__title m--hide"></div>
					    <div class="m-card-profile__pic">
						    <div class="m-card-profile__pic-wrapper">
						        <img src="/application/public/img/fastdl.png" alt="">
						    </div>
					    </div>
					    <div class="m-card-profile__details">
						    <span class="m-card-profile__name">FastDL</span>
						    <?php if($server['fastdl_status'] == 0): ?>
							<a href="#" class="m-card-profile__email m-link">Выключен</a>
							<?php elseif($server['fastdl_status'] == 1): ?>
							<a href="#" class="m-card-profile__email m-link">Включен</a>
							<?php endif; ?>
						</div>
				    </div>	
				    <ul class="m-nav m-nav--hover-bg m-portlet-fit--sides">
					    <li class="m-nav__separator m-nav__separator--fit"></li>
					    <li class="m-nav__section m--hide">
						    <span class="m-nav__section-text"></span>
					    </li>
					    <?php if($server['game_query'] == "cs" or $item['game_query'] == 'css' or $item['game_query'] == 'csgo'): ?>
					    <?php if($server['fastdl_status'] == 0): ?>
					    <li class="m-nav__item">
						    <a onclick="sendAction('on')" class="m-nav__link">
							    <i class="m-nav__link-icon fa fa-tachometer-alt"></i>
							    <span class="m-nav__link-text">Включить</span>
						    </a>
					    </li>
					    <?php elseif($server['fastdl_status'] == 1): ?>
					    <li class="m-nav__item">
						    <a onclick="sendAction('off')" class="m-nav__link">
							    <i class="m-nav__link-icon fa fa-power-off"></i>
							    <span class="m-nav__link-text">Выключить</span>
						    </a>
					    </li>
					    <?php endif; ?>
					    <?php endif?>
					    <li class="m-nav__item">
						    <a href="#" data-toggle="modal" data-target="#fastdlinfo" class="m-nav__link">
							    <i class="m-nav__link-icon fa flaticon-list-3"></i>
							    <span class="m-nav__link-text">Информация</span>
						    </a>
					    </li>
					</ul>
			   </div>			
		    </div>	
	    </div>
	    <div class="col-xl-9 col-lg-8">
		    <div class="m-portlet m-portlet--full-height m-portlet--tabs   m-portlet--unair">
			    <div class="m-portlet__body">
			    	<?php if($server['game_query'] == "cs" or $item['game_query'] == 'css' or $item['game_query'] == 'csgo'): ?>
			    	<?php if($server['fastdl_status'] == 0): ?>
			    	<div class="m-alert m-alert--icon m-alert--icon-solid m-alert--outline alert alert-brand alert-dismissible fade show" role="alert">
						<div class="m-alert__icon">
							<i class="flaticon-exclamation-1"></i>
							<span></span>
						</div>
						<div class="m-alert__text">
							<strong>Fastdl</strong> Отключен. Для работы необходимо включить функцию.
						</div>
						<div class="m-alert__close">
						</div>
					</div>
			    	<?php elseif($server['fastdl_status'] == 1): ?>
					<div class="alert alert-info alert-dismissable">
						<p><i class="fa fa-info-circle"></i> Обязательно добавьте в файл server.cfg строчки  <a class="alert-link" href="javascript:void(0)"></a></p><p style="color: rgb(52, 52, 52); font-family: &quot;PT Sans&quot;, sans-serif; font-style: italic;"><a class="alert-link" href="javascript:void(0)">// FastDL</a></p><p style="color: rgb(52, 52, 52); font-family: &quot;PT Sans&quot;, sans-serif; font-style: italic;"><a class="alert-link" href="javascript:void(0)"><span class="masha_index masha_index28" rel="28"></span>sv_send_resources 0</a></p><p style="color: rgb(52, 52, 52); font-family: &quot;PT Sans&quot;, sans-serif; font-style: italic;"><a class="alert-link" href="javascript:void(0)"><span class="masha_index masha_index29" rel="29"></span>sv_downloadurl "http://<?php echo $server['location_ip'] ?>/gs<?php echo $server['server_id']?>/cstrike"</a></p><p style="color: rgb(52, 52, 52); font-family: &quot;PT Sans&quot;, sans-serif; font-style: italic;"><a class="alert-link" href="javascript:void(0)"><span class="masha_index masha_index30" rel="30"></span>sv_allowdownload 1</a></p><p style="color: rgb(52, 52, 52); font-family: &quot;PT Sans&quot;, sans-serif; font-style: italic;"><a class="alert-link" href="javascript:void(0)"><span class="masha_index masha_index31" rel="31"></span>sv_allowupload 0</a></p><p style="color: rgb(52, 52, 52); font-family: &quot;PT Sans&quot;, sans-serif; font-style: italic;"><a class="alert-link" href="javascript:void(0)"><span class="masha_index masha_index32" rel="32"></span>sv_allow_dlfile 0</a></p><p></p>
					</div>
					<hr>
					<div class="form-group m-form__group">
						<label for="exampleInputEmail1">Ссылка на сервер</label>
						<input type="text" class="form-control m-input m-input--solid" value="http://<?php echo $server['location_ip'] ?>/gs<?php echo $server['server_id']?>" disabled>
					</div>
					<?php endif; ?>
					<?php elseif($server['game_query'] != "valve"): ?>
						<div class="m-alert m-alert--icon m-alert--icon-solid m-alert--outline alert alert-danger alert-dismissible fade show" role="alert">
							<div class="m-alert__icon">
								<i class="flaticon-exclamation-1"></i>
								<span></span>
							</div>
							<div class="m-alert__text">
							    Данная игра не поддерживает <strong>Fastdl</strong>
							</div>
							<div class="m-alert__close"></div>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</div>
<!--begin::Modal-->
<div class="modal fade" id="fastdlinfo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Информация</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            	<p>
            	FastDL — это быстрая загрузка файлов (перевод fast - быстрый/скоростной, DL - сокращенной Download - загрузка) которая поддерживается игровым сервером Counter-Strike (и аналогичных игр) для обеспечения более быстрого подключения клиента к серверу.
                </p>
                <p>
                В обычном режиме мы подключаемся к игровому серверу и медленно скачиваем все необходимые файлы/спрайты/карты, которых у нас еще нет. Скорость отдачи игрового сервера при этом низкая, т.к. помимо игровых запросов ему приходится также отрабатывать обращения на скачивание файлов и, тем самым, скорость замедляется.
                </p>
                <p>
                К счастью Valve предусмотрела это и сделали возможность подключения загрузки файлов игрового сервера со стороннего источника — http сервера, то есть фактически с интернет-сайта. Скорость http подключения сама по себе быстрее, а также серверу не приходится обрабатывать дополнительные соединения, отсутствует серверное ограничение игры (т.е. скорость скачивания равна скорости скачивания с интернета, а на сегодняшний день интернет достаточно развит, чтобы отдавать более быстрое соединения через http). Таким образом мы понимаем что FastDL значительно улучшает скорость скачивания дополнительных файлов сервера, скорость подключения клиента, а также снижает нагрузку на сам игровой сервер.
                </p>
            </div>
        </div>
    </div>
</div>
<!--end::Modal-->
<script>
	function sendAction(action) {
		$.ajax({ 
			<?php if($server['game_query'] == "cs" or $item['game_query'] == 'css' or $item['game_query'] == 'csgo'): ?>
			url: '/servers/fastdl/action/'+action+'/<?php echo $server['server_id'] ?>',
			<?php endif?>
			dataType: 'text',
			success: function(data) {
				console.log(data);
				data = $.parseJSON(data);
				switch(data.status) {
					case 'error':
						toastr.error(data.error);
						$('#controlBtns button').prop('disabled', false);
						break;
					case 'success':
						toastr.success(data.success);
						setTimeout("reload()", 1500);
						break;
				}
			}
		});
	}
</script>
<?php echo $footer ?>
