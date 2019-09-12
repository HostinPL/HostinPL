<?php
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
?>
<?php include 'application/views/common/menuserver.php';?>
<script src="http://tinymce.cachefly.net/4.0/tinymce.min.js"></script>
<div class="m-content">
	<div class="row">
	    <div class="col-xl-3 col-lg-4">
		    <div class="m-portlet m-portlet--full-height   m-portlet--unair">
			    <div class="m-portlet__body">
				    <div class="m-card-profile">
					<div class="m-card-profile__title m--hide"></div>
					    <div class="m-card-profile__pic">
						    <div class="m-card-profile__pic-wrapper">
						        <img src="/application/public/img/ftp.png" alt="">
						    </div>
					    </div>
					    <div class="m-card-profile__details">
						    <span class="m-card-profile__name">FTP</span>
							<a href="#" class="m-card-profile__email m-link"><?php echo $server['location_name'] ?></a>
						</div>
				    </div>	
				    <ul class="m-nav m-nav--hover-bg m-portlet-fit--sides">
					    <li class="m-nav__separator m-nav__separator--fit"></li>
					    <li class="m-nav__section m--hide">
						    <span class="m-nav__section-text"></span>
					    </li>
						<li class="m-nav__item">
						    <a data-toggle="modal" data-target="#ftpdiz" class="m-nav__link">
							<i class="m-nav__link-icon fa flaticon-web"></i>
							<span class="m-nav__link-text">Сменить дизайн</span>
						    </a>
					    </li>
					    <li class="m-nav__item">
						    <a href="http://filezilla.ru/get/" target="_blank" class="m-nav__link">
							<i class="m-nav__link-icon fa flaticon-multimedia-2"></i>
							<span class="m-nav__link-text">Скачать FTP Клиент</span>
						    </a>
					    </li>
					</ul>
			    </div>			
		    </div>	
	    </div>
	    <div class="col-xl-9 col-lg-8">
		    <div class="m-portlet m-portlet--full-height m-portlet--tabs   m-portlet--unair">
			    <div class="m-portlet__head">
				    <div class="m-portlet__head-caption">
			            <div class="m-portlet__head-title">
				            <h3 class="m-portlet__head-text">Данные FTP</h3>
			            </div>
		            </div>
			    </div>
			    <div class="m-widget1">
					<div class="m-widget1__item">
					    <div class="row m-row--no-padding align-items-center">
						    <div class="col">
							    <h3 class="m-widget1__title">Адрес для доступа по протоколу FTP</h3>
							    <span class="m-widget1__desc"><?php echo $server['location_ip'] ?></span>
						    </div>
					    </div>
				    </div>
				    <div class="m-widget1__item">
					    <div class="row m-row--no-padding align-items-center">
						    <div class="col">
							    <h3 class="m-widget1__title">FTP Порт</h3>
							    <span class="m-widget1__desc">21</span>
						    </div>
					    </div>
				    </div>
				    <div class="m-widget1__item">
					    <div class="row m-row--no-padding align-items-center">
						    <div class="col">
							    <h3 class="m-widget1__title">Имя пользователя</h3>
							    <span class="m-widget1__desc">gs<?php echo $server['server_id'] ?></span>
						    </div>
					    </div>
				    </div>
				    <div class="m-widget1__item">
					    <div class="row m-row--no-padding align-items-center">
						    <div class="col">
							    <h3 class="m-widget1__title">Пароль</h3>
							    <span class="m-widget1__desc"><?php echo $server['server_password'] ?></span>
						    </div>
					    </div>
				    </div>
				</div>
			</div>
		</div>
		<div class="col-12">
	        <div class="m-portlet__body">
			    <div class="m-section">
                    <div class="m-portlet">
	                    <div class="m-portlet__head">
		                    <div class="m-portlet__head-caption">
			                    <div class="m-portlet__head-title">
				                    <h3 class="m-portlet__head-text">Online клиент</h3>
			                    </div>
		                    </div>	
	                    </div>
	                    <div class="m-portlet__body">
							<div id="elfinder"></div>
						</div>
                    </div>
                </div>
            </div>
        </div>
	</div>
</div>
<!--begin::Modal-->
<div class="modal fade" id="ftpdiz" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
						<a href="#" onClick="sendAction_theme('default')" class="m-nav-grid__item">
							<i class="m-nav-grid__icon flaticon-interface-7"></i>
							<span class="m-nav-grid__text">Тема Default</span>
						</a>
						<a href="#" onClick="sendAction_theme('windows')" class="m-nav-grid__item">
							<i class="m-nav-grid__icon flaticon-interface-7"></i>
							<span class="m-nav-grid__text">Тема Windows</span>
						</a>
					</div>
					<div class="m-nav-grid__row">
						<a href="#" onClick="sendAction_theme('material')" class="m-nav-grid__item">
							<i class="m-nav-grid__icon flaticon-interface-7"></i>
							<span class="m-nav-grid__text">Тема Material</span>
						</a>
						<a href="#" onClick="sendAction_theme('materialgray')" class="m-nav-grid__item">
							<i class="m-nav-grid__icon flaticon-interface-7"></i>
							<span class="m-nav-grid__text">Тема Material gray</span>
						</a>
					</div>
				</div>
            </div>
        </div>
    </div>
</div>
<!--end::Modal-->
<script type="text/javascript"> $(function () { 
var myCommands = elFinder.prototype._options.commands; 
var disabled = ['resize', 'help', 'select']; 
// Not yet implemented commands in ElFinder.Net 
$.each(disabled, function (i, cmd) {
(idx = $.inArray(cmd, myCommands)) !== -1 && myCommands.splice(idx, 1); }); 
var selectedFile = null; var options = { url: '/servers/ftp/getftp/<?php echo $server['server_id']  ?>', // connector route defined in the project folder App_Start\RouteConfig.cs 
rememberLastDir: false, // Prevent elFinder saving in the Browser LocalStorage the last visited directory 
commands: myCommands, 
lang: 'ru', // elFinder supports UI and messages localization. Check the folder Content\elfinder\js\i18n for all available languages. Be sure to include the corresponding .js file(s) in the JavaScript bundle. 
uiOptions: { // UI buttons available to the user 
toolbar: [ ['back', 'forward'], ['reload'], ['home', 'up'], ['mkdir', 'mkfile', 'upload'], ['open', 'download'], ['info'], ['quicklook'], ['copy', 'cut', 'paste'], ['rm'], ['duplicate', 'rename', 'edit','extract', 'archive'], ['view', 'sort'] ] }, 
handlers: { select: function (event, elfinderInstance) { 
if (event.data.selected.length == 1) { var item = $('#' + event.data.selected[0]); if (!item.hasClass('directory')) { selectedFile = event.data.selected[0]; $('#elfinder-selectFile').show(); return; } } 
$('#elfinder-selectFile').hide(); selectedFile = null; } } }; $('#elfinder').elfinder(options).elfinder('instance'); $('.elfinder-toolbar:first').append('<div class="ui-widget-content ui-corner-all elfinder-buttonset" id="elfinder-selectFile" style="display:none; float:right;">'+ '<div class="ui-state-default elfinder-button" title="Select" style="width: 100px;"></div>'); $('#elfinder-selectFile').click(function () { 
if (selectedFile != null) $.post('file/selectFile', { target: selectedFile }, function (response) { alert(response); }); }); }); </script>
<audio style="display: none;"><source src="./sounds/rm.wav" type="audio/wav"></audio>
<script src="/application/public/js/elfinder.full.js"></script>
<script src="/application/public/js/i18n/elfinder.ru.js"></script>
<link rel="stylesheet" type="text/css" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.23/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="/application/public/css/elfinder.full.css">
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo $theme ?>">
<script>
	function sendAction_theme(action) {
	$.ajax({ 
			url: '/servers/ftp/action_theme_ftp/'+action,
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
</script>
<!--Page Related Scripts-->
<?php echo $footer ?>