<?php
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
?>
<?php include 'application/views/common/menuserver.php';?>
<style>
.m-btn--icon.m-btn--icon-only {
  width: 40px;
  height: 40px;
}
</style>
<div class="col-12">
	<br>
	<div class="m-portlet__body">
		<div class="m-section">
            <div class="m-portlet">
	            <div class="m-portlet__head">
		            <div class="m-portlet__head-caption">
			            <div class="m-portlet__head-title">
				            <h3 class="m-portlet__head-text">Консоль</h3>
			            </div>
		            </div>
		            <div class="m-portlet__head-tools">
						<ul class="m-portlet__nav">
							<li class="m-portlet__nav-item">
								<div class="m-checkbox-inline">
									<label class="m-checkbox m-checkbox--solid  m-checkbox--brand" data-toggle="tooltip" data-placement="top" title="Автообновление консоли каждые 15 секунд.">
									    <input type="checkbox" checked id="autoscroll"> Автообновление
										<span></span>
									</label>
								</div>
							</li>
						</ul>
					</div>
	            </div>
	            <div class="m-portlet__body">
					<textarea style="<?php echo $theme ?>" disabled="" class="form-control console" id="console_data"> </textarea>
					<form class="form-inline" role="form" method='POST' id="console_form" action="" >
			        <div class="input-group" style="width: 100%;">
						<input type="text" class="form-control" name="cmd" placeholder="Введите команду">
						<div class="input-group-append">
						    <input type="hidden" name="cmd_console" value="true">
							<button class="btn btn-accent m-btn m-btn--air m-btn--custom" type="submit">Отправить</button>
							<?if($server['game_query'] == 'samp'):?>
							<a href="#" data-toggle="modal" data-target="#infoCMD" class="btn btn-primary m-btn m-btn--icon m-btn--icon-only">
								<i class="fa flaticon-exclamation-2"></i>
							</a>
							<?endif;?>
							<a href="#" data-toggle="modal" data-target="#colorCMD" class="btn btn-info m-btn m-btn--icon m-btn--icon-only">
								<i class="fa flaticon-internet"></i>
							</a>
					        </form>
					        <form class="form-inline" role="form" method='POST' id="clearform" action="" >
							<button type="submit" data-container="body" data-toggle="m-popover" data-placement="top" data-content="Очистить консоль" data-original-title="" title="" class="btn btn-danger m-btn m-btn--icon m-btn--icon-only">
								<i class="fa flaticon-browser"></i>
							</button>
					        </form>
						</div>
					</div>
				</div>
            </div>
            <div class="m-portlet m-portlet--full-height m-portlet--tabs   m-portlet--unair">
			    <div class="m-portlet__head">
				    <div class="m-portlet__head-caption">
			            <div class="m-portlet__head-title">
				            <h3 class="m-portlet__head-text">Выбор лог файла</h3>
			            </div>
		            </div>
			    </div>
			    <div class="m-portlet__body">
			        <a href="/servers/console/index/<?php echo $server['server_id'] ?>" data-container="body" data-toggle="m-popover" data-placement="top" data-content="Выбрать" data-original-title="" title="" class="btn btn-accent m-btn m-btn--air btn-outline  btn-block sbold uppercase">./screenlog.0</a>
			        <?php if($server['game_code'] == "samp"): ?>
			        <a href="/servers/console/index/<?php echo $server['server_id'] ?>?open=samp_1" data-container="body" data-toggle="m-popover" data-placement="top" data-content="Выбрать" data-original-title="" title="" class="btn btn-accent m-btn m-btn--air btn-outline  btn-block sbold uppercase">./server_log.txt</a>
			        <a href="/servers/console/index/<?php echo $server['server_id'] ?>?open=samp_2" data-container="body" data-toggle="m-popover" data-placement="top" data-content="Выбрать" data-original-title="" title="" class="btn btn-accent m-btn m-btn--air btn-outline  btn-block sbold uppercase">./mysql_log.txt</a>
			        <?php endif; ?>
			        <?php if($server['game_code'] == "crmp"): ?>
			        <a href="/servers/console/index/<?php echo $server['server_id'] ?>?open=crmp_1" data-container="body" data-toggle="m-popover" data-placement="top" data-content="Выбрать" data-original-title="" title="" class="btn btn-accent m-btn m-btn--air btn-outline  btn-block sbold uppercase">./server_log.txt</a>
			        <?php endif; ?>
			        <?php if($server['game_code'] == "mtasa"): ?>
			        <a href="/servers/console/index/<?php echo $server['server_id'] ?>?open=mtasa_1" data-container="body" data-toggle="m-popover" data-placement="top" data-content="Выбрать" data-original-title="" title="" class="btn btn-accent m-btn m-btn--air btn-outline  btn-block sbold uppercase">./mods/deathmatch/logs/server.log</a>
			        <?php endif; ?>
			    </div>
			</div>
        </div>
    </div>
</div>
<!--begin::Modal-->
<div class="modal fade" id="infoCMD" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Доступные команды</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            	<code>cmdlist</code> - Показать список RCON команд<br>
		        <code>varlist</code> - Посмотреть список текущих настроек<br>
		        <code>kick [ID]</code> - Кикнуть пользователя по его ID (Пример: kick 3)<br>
		        <code>ban [ID]</code> - Забанить пользователя по его ID (Пример: ban 3)<br>
		        <code>banip [IP]</code> - Забанить IP (Пример: banip 127.0.0.1)<br>
		        <code>unbanip [IP]</code> - Разбанить IP (Пример: unbanip 127.0.0.1)<br>
		        <code>reloadbans</code> - Перезагрузить samp.ban, в котором содержатся забаненные IP<br>
		        <code>reloadlog</code> - Очистить лог сервера<br>
		        <code>exec [имя файла]</code> - Открыть файл .cfg (Пример: exec blah.cfg)<br>
		        <code>say [текст]</code> - Сказать в общий чат от лица админа (Пример: say Hello)<br>
		        <code>players</code> - Показать всех игроков на сервере с их именами, ip и пингом<br>
		        <code>gravity</code> - Изменить гравитацию на сервере - (Пример: gravity 0.008)<br>
		        <code>weather [ID]</code> - Изменить погоду на сервере (Пример: weather 2)<br>
		        <code>worldtime [время]</code> - Изменить время на сервере (Пример: worldtime 2)<br>
		        <code>maxplayers</code> - Изменить макс. количество мест на сервере<br>
		        <code>timestamp</code> - Установить часовой пояс<br>
		        <code>plugins</code> - Посмотреть список всех установленных плагинов<br>
		        <code>filterscripts</code> - Посмотреть список всех установленных фильтрскриптов<br>
		        <code>loadfs [название]</code> - Загрузить фильтрскрипт<br>
		        <code>unloadfs [название]</code> - Выгрузить фильтрскрипт<br>
		        <code>reloadfs [название]</code> - Перезагрузить фильтрскрипт<br>
		        <code>password [пароль]</code> - Установить пароль на сервере<br>
		        <code>changemode [название]</code> - Изменить режим игры на сервере на заданный<br>
		        <code>gmx</code> - Рестарт сервера<br>
		        <code>hostname [название]</code> - Изменить название сервера<br>
		        <code>gamemodetext [название]</code> - Изменить название мода<br>
		        <code>mapname [название]</code> - Изменить название карты<br>
		        <code>gamemode [1-15]</code> - Установить порядок гэйм-модов<br>
		        <code>instagib [bool]</code> - Включить функцию убийства с одной пули (1 или 0)<br>
		        <code>lanmode [bool]</code> - Установить LAN (1 или 0)<br>
		        <code>version</code> - Посмотреть версию сервера<br>
		        <code>weburl [урл]</code> - Установить url сайта на сервере<br>
            </div>
        </div>
    </div>
</div>
<!--end::Modal-->
<!--begin::Modal-->
<div class="modal fade" id="colorCMD" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Смена дизайна</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            	<div class="m-nav-grid m-nav-grid--skin-light">
					<div class="m-nav-grid__row">
						<a href="#" onclick="sendAction('default')" class="m-nav-grid__item">
							<i class="m-nav-grid__icon flaticon-interface-7"></i>
							<span class="m-nav-grid__text">Тема Default</span>
						</a>
						<a href="#" onclick="sendAction('Amethyst')" class="m-nav-grid__item">
							<i class="m-nav-grid__icon flaticon-interface-7"></i>
							<span class="m-nav-grid__text">Тема Amethyst</span>
						</a>
					</div>
					<div class="m-nav-grid__row">
						<a href="#" onclick="sendAction('City')" class="m-nav-grid__item">
							<i class="m-nav-grid__icon flaticon-interface-7"></i>
							<span class="m-nav-grid__text">Тема City</span>
						</a>
						<a href="#" onclick="sendAction('Flat')" class="m-nav-grid__item">
							<i class="m-nav-grid__icon flaticon-interface-7"></i>
							<span class="m-nav-grid__text">Тема Flat</span>
						</a>
					</div>
					<div class="m-nav-grid__row">
						<a href="#" onclick="sendAction('Modern')" class="m-nav-grid__item">
							<i class="m-nav-grid__icon flaticon-interface-7"></i>
							<span class="m-nav-grid__text">Тема Modern</span>
						</a>
						<a href="#" onclick="sendAction('Smooth')" class="m-nav-grid__item">
							<i class="m-nav-grid__icon flaticon-interface-7"></i>
							<span class="m-nav-grid__text">Тема Smooth</span>
						</a>
					</div>
				</div>
            </div>
        </div>
    </div>
</div>
<!--end::Modal-->
<script>
	$('#console_form').ajaxForm({ 
		url: '/servers/console/sendconsole/<?php echo $server['server_id'] ?>',
		dataType: 'text',
		success: function(data) {
			data = $.parseJSON(data);
			switch(data.status) {
				case 'error':
					toastr.error(data.error);
					$('button[type=submit]').prop('disabled', false);
					break;
				case 'success':
					toastr.success(data.success);
					document.getElementById("text").value = "";
					setTimeout(reset_console, 1000);
					break;
			}
		}
	});
	
	$('#clearform').ajaxForm({ 
		url: '/servers/console/clearcon/<?php echo $server['server_id'] ?>',
		dataType: 'text',
		success: function(data) {
			data = $.parseJSON(data);
			switch(data.status) {
				case 'error':
					toastr.error(data.error);
					$('button[type=submit]').prop('disabled', false);
					break;
				case 'success':
					toastr.success(data.success);
					document.getElementById("text").value = "";
					setTimeout(reset_console, 1000);
					break;
			}
		}
	});
    function reset_console() {
        var autoscroll = document.getElementById("autoscroll");
        if (autoscroll.checked == false) {
            return false;
        }
        $.get("/servers/console/getconsole/<?php echo $server['server_id'] ?>/<?php echo $fileid ?>")
		.done(function (data) {
			console_block(data);
			setTimeout(reset_console, 20000);
		});
    }
    function console_block(text_console) {
        var console = document.getElementById("console_data");
        console.innerHTML = text_console;
        console.scrollTop = console.scrollHeight;
        return false;
    }
	function sendAction(action) {
	$.ajax({ 
			url: '/servers/console/action_theme_console/'+action,
			dataType: 'text',
			success: function(data) {
				data = $.parseJSON(data);
				switch(data.status) {
					case 'error':
						toastr.error(data.error);
						break;
					case 'success':
						toastr.success(data.success);
						setTimeout("reload()", 2500);
						break;
				}
			}
		});
	}
    $(document).ready(function () {
        reset_console();
    });
</script>
<?echo $footer?>