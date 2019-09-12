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
						        	<img src="/application/public/img/myadmin.png" alt="">
						        </div>
					        </div>
					<div class="m-card-profile__details">
						<span class="m-card-profile__name">PHPMyAdmin</span>
						<?if($server['server_mysql'] == 1):?>
						<a href="#" class="m-card-profile__email m-link">Включен</a>
						<?elseif($server['server_mysql'] == 0):?>
						<a href="#" class="m-card-profile__email m-link">Не создан</a>
						<?elseif($server['server_mysql'] == 2):?>
						<a href="#" class="m-card-profile__email m-link">Выключен</a>
						<?endif;?>
					</div>
				</div>	
				<ul class="m-nav m-nav--hover-bg m-portlet-fit--sides">
					<li class="m-nav__separator m-nav__separator--fit"></li>
					<li class="m-nav__section m--hide">
						<span class="m-nav__section-text"></span>
					</li>
					<?if($server['server_mysql'] == 1):?>
					<li class="m-nav__item">
						<a data-toggle="modal" href="#responsive" class="m-nav__link">
						<i class="m-nav__link-icon fa flaticon-profile"></i>
							<span class="m-nav__link-text">Войти</span>
						</a>
					</li>
					<li class="m-nav__item">
						<a onClick="sendAction(<?php echo $server['server_id'] ?>,'mysqloff')" class="m-nav__link">
							<i class="m-nav__link-icon fa fa-power-off"></i>
							<span class="m-nav__link-text">Выключить</span>
						</a>
					</li>
					<?elseif($server['server_mysql'] == 0):?>
					<li class="m-nav__item">
						<a onClick="sendAction(<?php echo $server['server_id'] ?>,'mysqlcr')" class="m-nav__link">
							<i class="m-nav__link-icon fa flaticon-user-add"></i>
							<span class="m-nav__link-text">Создать</span>
						</a>
					</li>
					<?elseif($server['server_mysql'] == 2):?>
					<li class="m-nav__item">
						<a onClick="sendAction(<?php echo $server['server_id'] ?>,'mysqlon')" class="m-nav__link">
							<i class="m-nav__link-icon fa fa-power-off"></i>
							<span class="m-nav__link-text">Включить</span>
						</a>
					</li>
					<?endif;?>
				</ul>
			</div>			
		</div>	
	</div>
	<div class="col-xl-9 col-lg-8">
		<div class="m-portlet m-portlet--full-height m-portlet--tabs   m-portlet--unair">
			<div class="m-portlet__head">
				<div class="m-portlet__head-caption">
			        <div class="m-portlet__head-title">
				        <h3 class="m-portlet__head-text">Информация</h3>
			        </div>
		        </div>
			</div>
			<div class="m-widget1">
				<?if($server['server_mysql'] == 1):?>
				<div class="m-widget1__item">
					<div class="row m-row--no-padding align-items-center">
						<div class="col">
							<h3 class="m-widget1__title">MySQL Хост</h3>
							<span class="m-widget1__desc"><?php echo $server['location_ip'] ?> или localhost</span>
						</div>
					</div>
				</div>
				<div class="m-widget1__item">
					<div class="row m-row--no-padding align-items-center">
						<div class="col">
							<h3 class="m-widget1__title">MySQL Порт</h3>
							<span class="m-widget1__desc">3306</span>
						</div>
					</div>
				</div>
				<div class="m-widget1__item">
					<div class="row m-row--no-padding align-items-center">
						<div class="col">
							<h3 class="m-widget1__title">Логин</h3>
							<span class="m-widget1__desc">gs<?php echo $server['server_id'] ?></span>
						</div>
					</div>
				</div>
				<div class="m-widget1__item">
					<div class="row m-row--no-padding align-items-center">
						<div class="col">
							<h3 class="m-widget1__title">Пароль</h3>
							<span class="m-widget1__desc"><?php echo $server['db_pass'] ?></span>
						</div>
					</div>
				</div>
				<div class="m-widget1__item">
					<div class="row m-row--no-padding align-items-center">
						<div class="col">
							<h3 class="m-widget1__title">База данных</h3>
							<span class="m-widget1__desc">gs<?php echo $server['server_id'] ?></span>
						</div>
					</div>
				</div>
				<?endif;?>
				<?if($server['server_mysql'] == 0):?>
				<div class="m-widget1__item">
					<div class="row m-row--no-padding align-items-center">
						<div class="col">
							<h3 class="m-widget1__title">База данных</h3>
							<span class="m-widget1__desc">Не создана</span>
						</div>
					</div>
				</div>
				<?elseif($server['server_mysql'] == 2):?>
				<div class="m-widget1__item">
					<div class="row m-row--no-padding align-items-center">
						<div class="col">
							<h3 class="m-widget1__title">База данных</h3>
							<span class="m-widget1__desc">Не включена</span>
						</div>
					</div>
				</div>
				<?endif;?>
			</div>
		</div>
	</div>
</div>        
</div>
<?if($server['server_mysql'] == 1):?>
<!--begin::Modal-->
<div class="modal fade" id="responsive" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="position: absolute; padding-left: 20%;">
        <div class="modal-content" style="width:400%;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">PhpMyAdmin</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"></span>
                </button>
            </div>
            <div class="modal-body">
            <form action="/phpmyadmin/index.php" style="display:none" method="POST" target="msqldd" id="msql2d">
            <input type="hidden" value="gs<?php echo $server['server_id'] ?>" name="pma_username">
            <input type="hidden" name="pma_password" value="<?php echo $server['db_pass'] ?>">
            <input type="hidden" name="db" value="gs<?php echo $server['server_id'] ?>" /></form>
            <iframe onload="sizeFrame();" style="width:100%; height:500px; border:0;" id="msqldd" name="msqldd" ></iframe>
            </div>
        </div>
    </div>
</div>
<!--end::Modal-->
<?endif;?>
<script>											  
    var cfg_load = null;
        $(document).ready(function(){
    $('#msql2d').submit();
            cfg_load= $('#cfg_load').css({'box-shadow' : '0px 0px 0px #444', '-moz-box-shadow' : '0px 0px 0px #444', '-webkit-box-shadow' : '0px 0px 0px #444'}).dialog({minHeight: 285, autoOpen:false, minWidth: 485, title: 'Импорт конфигурации'});
            $('#cfg_load_opt').css({'border' : '0px double black','box-shadow' : '0px 0px 0px #444', '-moz-box-shadow' : '0px 0px 0px #444', '-webkit-box-shadow' : '0px 0px 0px #444'}).tabs();
        }); </script> 
		
<script type="text/javascript" language="javascript">
  function sizeFrame() {
    var frames = document.getElementsByTagName('iframe'); 
    for (var i = 0; i < frames.length; i++){ 
      var fID     = frames[i].id; 
      var F       = document.getElementById(fID);

      if(F.contentDocument && F.contentDocument.documentElement.scrollHeight) {
        F.height = F.contentDocument.documentElement.scrollHeight+30; //FF 3.0.11, Opera 9.63, and Chrome

      } else if(F.contentDocument && F.contentDocument.documentElement.offsetHeight) {
        F.height = F.contentDocument.documentElement.offsetHeight+30; //standards compliant syntax – ie8

      } else {
        F.height = F.contentWindow.document.body.scrollHeight+30; //IE6, IE7 and Chrome
      }
    }
  }


  window.onload=sizeFrame; 
</script>
<script>
	function sendAction(serverid, action) {
						$.ajax({ 
							url: '/servers/mysql/action/'+serverid+'/'+action,
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
							},
							beforeSend: function(arr, options) {
								if(action == "mysqloff") toastr.warning("Выключаем базу данных...");
								if(action == "mysqlon") toastr.warning("Включаем базу данных...");
								if(action == "mysqlcr") toastr.warning("Создаем базу данных...");
								$('#controlBtns button').prop('disabled', true);
							}
						});
					}
	
</script>

<?php echo $footer ?>