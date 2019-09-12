<?php
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
?>
<?php include 'application/views/common/menuserver.php';?>
<div class="col-12">
	<br>
	<div class="m-portlet__body">
		<div class="m-section">
            <div class="m-portlet">
	            <div class="m-portlet__head">
		            <div class="m-portlet__head-caption">
			            <div class="m-portlet__head-title">
				            <h3 class="m-portlet__head-text">Редактор конфигурации</h3>
			            </div>
		            </div>
	            </div>
	            <div class="m-portlet__body">
					<div class="table-scrollable table-scrollable-borderless" style="margin-top: 0px !important;">
<section id="unseen">
	<form action="/ftp/index.php" style="display:none" method="POST" target="ftpdd" id="ftp2d">
    <input type="hidden" value="gs<?php echo $server['server_id'] ?>" name="username">
    <input type="hidden" name="password" value="<?php echo $server['server_password'] ?>">
    <input type="hidden" name="ftpserver" value="<?php echo $server['location_ip'] ?>" />
    <input type="hidden" name="ftpserverport" value="21" />
	<input type="hidden" name="state"        value="edit" />
<input type="hidden" name="state2"       value="" />
<input type="hidden" name="directory"    value="/<?if($server['game_code'] == 'cs' || $server['game_code'] == 'css') {echo 'cstrike/server.cfg';} elseif($server['game_code'] == 'mta') {echo 'mods/deathmatch/mtaserver.conf';}elseif($server['game_code'] == 'mcpe') {echo 'server.properties';} elseif($server['game_code'] == 'mine72') {echo 'server.properties';} else {echo 'server.cfg';}?>" />
<input type="hidden" name="screen"       value="1" />
<input type="hidden" name="textareaType" value="plain" />
	<input name="ftpmode" value="automatic" checked="checked" type="hidden" /></form>
<iframe onload="sizeFrame();" style="width: 100%; border:0" id="ftpdd" name="ftpdd" ></iframe>

</section>
					</div>
				</div>
            </div>
        </div>
    </div>
</div>
<script>                  					   
$('#sendForm').ajaxForm({ 
						url: '/servers/setting/send_config/<?echo $server['server_id']?>',
						dataType: 'json',
						success: function(data) {
							switch(data.status) {
								case 'error':
									toastr.error(data.error);
									$('button[type=submit]').prop('disabled', false);
									break;
								case 'success':
									toastr.success(data.success);
									setTimeout("redirect('/servers/setting/index/<?echo $server['server_id']?>')", 1500);
									break;
							}
						},
						beforeSubmit: function(arr, $form, options) {
							$('button[type=submit]').prop('disabled', true);
						}
					});							 
					
				</script>
<script>
    var cfg_load = null;
        $(document).ready(function(){
    $('#ftp2d').submit();
            cfg_load= $('#cfg_load').css({'box-shadow' : '0px 0px 0px #444', '-moz-box-shadow' : '0px 0px 0px #444', '-webkit-box-shadow' : '0px 0px 0px #444'}).dialog({minHeight: 285, autoOpen:false, minWidth: 485, title: 'Импорт конфигурации'});
            $('#cfg_load_opt').css({'border' : '0px double black','box-shadow' : '0px 0px 0px #444', '-moz-box-shadow' : '0px 0px 0px #444', '-webkit-box-shadow' : '0px 0px 0px #444'}).tabs();
        });
    </script>
   <script type="text/javascript">

    function sizeFrame() {
    var F = document.getElementById("ftpdd");
    if(F.contentDocument) {F.height = F.contentDocument.documentElement.scrollHeight+30;} else {F.height = F.contentWindow.document.body.scrollHeight+30;}}

    window.onload=sizeFrame; 

</script>
<?echo $footer?>