<?php
/*
Copyright (c) 2017 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
?>
<?php include 'application/views/common/menuserver.php';?>
<div class="col-12">
    <div class="m-content">
    	<div class="m-portlet m-portlet--brand m-portlet--head-solid-bg m-portlet--head-sm m-portlet--collapse" m-portlet="true" id="m_portlet_tools_1">
			<div class="m-portlet__head">
				<div class="m-portlet__head-caption">
					<div class="m-portlet__head-title">
						<span class="m-portlet__head-icon">
							<i class="flaticon-open-box"></i>
						</span>
						<h3 class="m-portlet__head-text">
							Репозиторий
						</h3>
					</div>
				</div>
				<div class="m-portlet__head-tools">
					<ul class="m-portlet__nav">
						<li class="m-portlet__nav-item">
							<a href="#javascript" m-portlet-tool="toggle" class="m-portlet__nav-link m-portlet__nav-link--icon" aria-describedby="">
								<i class="la la-angle-down"></i>
							</a>
						</li>
					</ul>
				</div>
			</div>
			<div class="m-portlet__body" m-hidden-height="344" style="display: none; overflow: hidden; padding-top: 0px; padding-bottom: 0px;">
			    <div class="m-demo" data-code-preview="true" data-code-html="true" data-code-js="false">
					<div class="m-demo__preview">
						<div class="m-nav-grid">
							<div class="m-nav-grid__row">
								<a href="/servers/repo/index/<?php echo $server['server_id'] ?>" class="m-nav-grid__item">
									<i class="m-nav-grid__icon flaticon-open-box"></i>
									<span class="m-nav-grid__text">Общий список</span>
								</a>
								<a href="/servers/repo/index/<?php echo $server['server_id'] ?>?systemid=1" class="m-nav-grid__item">
									<i class="m-nav-grid__icon flaticon-open-box"></i>
									<span class="m-nav-grid__text">Модификации</span>
								</a>
								<a href="/servers/repo/index/<?php echo $server['server_id'] ?>?systemid=2" class="m-nav-grid__item">
									<i class="m-nav-grid__icon flaticon-open-box"></i>
									<span class="m-nav-grid__text">Плагины</span>
								</a>
								<a href="/servers/repo/index/<?php echo $server['server_id'] ?>?systemid=3" class="m-nav-grid__item">
									<i class="m-nav-grid__icon flaticon-open-box"></i>
									<span class="m-nav-grid__text">Разное</span>
								</a>
								<a href="/servers/repo/index/<?php echo $server['server_id'] ?>?systemid=4" class="m-nav-grid__item">
									<i class="m-nav-grid__icon flaticon-open-box"></i>
									<span class="m-nav-grid__text">Сборки</span>
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
        <div class="row">
        	<?php foreach($adaps as $item):  ?>
		    <?php if($server['game_id'] == $item['game_id']): ?>
        	<div class="col-lg-4">
                <div class="m-portlet m-portlet--brand m-portlet--head-solid-bg m-portlet--bordered">
					<div class="m-portlet__body">
						<div class="m-demo" data-code-preview="true" data-code-html="true" data-code-js="false">
							<div class="m-demo__preview">
								<center><img src="http://forum.sa-mp.com/images/samp/logo_forum.gif" style="max-width:100%;height:auto;" alt=""></center>
							</div>
						</div>
						<center><strong><span style="font-size: x-large;"><?php echo $item['adap_name']?></span></strong></center>
						<br>
						<div class="m-scrollable m-scroller" data-scrollbar-shown="true" data-scrollable="true" data-height="100" style="overflow: auto; height: 50px;">
                        <?php echo $item['adap_textx']?>
                        </div>
                        <hr>
                        <?php if($item['adap_category'] == 1): ?>
						<button type="submit" onClick="sendAction_repos(<?php echo $server['server_id'] ?>,'<?echo $item['adap_id']?>')" class="btn btn-primary m-btn--air">Купить</button>
						<span class="m--margin-left-10">Цена
							<a href="#javascript" class="m-link m--font-bold"><?php echo $item['adap_price']?> руб.</a>
						</span>
					    <?php elseif($item['adap_category'] == 0): ?>
						<a href="#javascript" onClick="sendAction_repos(<?php echo $server['server_id'] ?>,'<?echo $item['adap_id']?>')"class="btn btn-primary m-btn m-btn--air btn-outline  btn-block sbold uppercase">Установить</a>
					    <?php endif; ?>
					</div>
				</div>
			</div>
			<?php endif;?>	
	        <?php endforeach; ?>
		</div>
		<?php if(empty($adaps)): ?>
			<center>
				<span class="m-widget14__desc">
					На данный момент дополнений нет.
				</span>
			</center>
		<?php endif; ?>	
	</div>
</div>
<script>	
function sendAction_repos(serverid, action) {
	$.ajax({ 
		url: '/servers/repo/actionrepos/'+serverid+'/'+action,
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
			<?php foreach($adaps as $item): ?> 
				if(action == "<?echo $item['adap_action']?>") toastr.warning("Идет установка <?echo $item['adap_name']?>, пожалуйста подождите 3 минуты!");
						<?endforeach;?>
				$('#controlBtns button').prop('disabled', true);
		}
	});
}
</script>
<?php echo $footer ?>
