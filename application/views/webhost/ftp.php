<?php echo $header ?>
 <script src="http://tinymce.cachefly.net/4.0/tinymce.min.js"></script>
<div class="col-lg-14">
<div class="portlet light">
													<a href="/webhost/control/index/<?php echo $webhost['web_id'] ?>" class="icon-btn">
													<i class="icon-home"></i>
													<div>
														 Управление
													</div>
													</a>
													<a href="/webhost/ftp/index/<?php echo $webhost['web_id'] ?>" class="icon-btn">
													<i class="icon-docs"></i>
													<div>
														 FTP
													</div>
													</a>
												</div>
												</div>
											
<div class="portlet light">	
<div>										
                                                <p><table class="table table-bordered" style="margin-bottom: 0px;">
 
	 						
								<tbody><tr>
									<td>Адрес для доступа по протоколу FTP:</td>
									<td><?php echo $ispdomain ?></td>
								</tr>
								<tr>
									<td>FTP Порт:</td>
									<td>21</td>
								</tr>								
								<tr>
									<td>Логин:</td>
									<td>ws<?php echo $webhost['web_id'] ?></td>
								</tr>
								<tr>
									<td>Пароль:</td>
									<td><?php echo $webhost['web_password'] ?></td>
								</tr>								
								<tr>
									<td>Скачать FTP Клиент:</td>
									<td><a href="http://filezilla.ru/get/">Загрузить</a></td>
								</tr>

							</tbody></table></p>
</div></div>
<div id="elfinder"></div>
							
							
<script type="text/javascript"> $(function () { 
var myCommands = elFinder.prototype._options.commands; 
var disabled = ['resize', 'help', 'select']; 
// Not yet implemented commands in ElFinder.Net 
$.each(disabled, function (i, cmd) {
(idx = $.inArray(cmd, myCommands)) !== -1 && myCommands.splice(idx, 1); }); 
var selectedFile = null; var options = { url: '/webhost/ftp/getftp/<?php echo $webhost['web_id']  ?>', // connector route defined in the project folder App_Start\RouteConfig.cs 
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
  <link rel="stylesheet" type="text/css" href="/application/public/css/theme.css">
				<!--Page Related Scripts-->
<?php echo $footer ?>