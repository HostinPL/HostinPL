<?php
/*
Copyright (c) 2018 HOSTINPL (https://vk.com/hosting_rus)
Developed by Samir Shelenko (https://vk.com/id00v)
*/
?>
<?echo $header?>
<div class="m-content">
    <div class="row">
        <div class="col-xl-3 col-lg-4">
            <div class="m-portlet m-portlet--full-height   m-portlet--unair">
                <div class="m-portlet__body">
                    <div class="m-card-profile">
                        <div class="m-card-profile__title m--hide"></div>
                            <div class="m-card-profile__pic">
                                <div class="m-card-profile__pic-wrapper">
                                    <img src="<?if($server['game_code'] == 'samp'):?>/application/public/img/monitor/samp.png
                                            <?elseif($server['game_code'] == 'cs'):?>/application/public/img/monitor/cs.png
                                            <?elseif($server['game_code'] == 'unit'):?>/application/public/img/monitor/unit.png
                                            <?elseif($server['game_code'] == 'css'):?>/application/public/img/monitor/css.png
                                            <?elseif($server['game_code'] == 'mta'):?>/application/public/img/monitor/mta.png
                                            <?elseif($server['game_code'] == 'crmp'):?>/application/public/img/monitor/crmp.png
                                            <?elseif($server['game_code'] == 'mine'):?>/application/public/img/monitor/samp.png
                                           <?elseif($server['game_query'] == 'mine'):?>/application/public/img/monitor/mine.png <?endif;?>" alt="">
                                </div>
                            </div>
                    <div class="m-card-profile__details">
                        <span class="m-card-profile__name"><?php echo $query['hostname'] ?></span>
                    </div>
                </div>  
                <ul class="m-nav m-nav--hover-bg m-portlet-fit--sides">
					<li class="m-nav__separator m-nav__separator--fit"></li>
					<li class="m-nav__section m--hide">
						<span class="m-nav__section-text"></span>
					</li>
					<li class="m-nav__item">
						<a href="#" class="m-nav__link">
							<i class="m-nav__link-icon flaticon-placeholder"></i>
							<span class="m-nav__link-title">
								<span class="m-nav__link-wrap">
									<span class="m-nav__link-text"><?php echo $server['location_ip'] ?>:<?php echo $server['server_port'] ?></span>
										<span class="m-nav__link-badge">
									</span>
								</span>
							</span>
						</a>
					</li>
					<li class="m-nav__item">
						<a href="#" class="m-nav__link">
							<i class="m-nav__link-icon flaticon-users"></i>
							<span class="m-nav__link-title">
								<span class="m-nav__link-wrap">
									<span class="m-nav__link-text">
										<div style="position: relative;">
											<div class="progress progress-striped" style="margin-bottom: 0px;border-radius: 0px;">
												<div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="<?php echo $query['players']*100/$query['maxplayers'] ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $query['players']*100/$query['maxplayers'] ?>%">
												</div>
												<div style="position: absolute;width: 100%;">
													<center><?php echo $query['players']?>/<?echo $query['maxplayers'] ?></center>
												</div>
											</div>
										</div>
				                    </span>
									<span class="m-nav__link-badge">
									</span>
								</span>
							</span>
						</a>
					</li>
					<li class="m-nav__item">
						<a href="#" class="m-nav__link">
							<i class="m-nav__link-icon flaticon-map-location"></i>
							<span class="m-nav__link-title">
								<span class="m-nav__link-wrap">
									<span class="m-nav__link-text"><?php echo $server['location_name'] ?></span>
										<span class="m-nav__link-badge">
									</span>
								</span>
							</span>
						</a>
					</li>
				</ul>
            </div>          
        </div>  
    </div>
    <div class="col-xl-9 col-lg-8">
        <div class="m-portlet m-portlet--full-height m-portlet--tabs   m-portlet--unair">
            <div class="m-portlet__body">
                <div id="statsGraph" style="height: 350px;"></div>
                <br><br>
                <table class="table table-hover table-light">
                    <tbody>
						<tr>
							<td colspan="6">
								<center>
									<img src="<?php echo $url ?>monitor/view/baner/<?php echo $server['server_id'] ?>" class="informer_server3">
								</center>
							</td>
						</tr>
						<tr>
							<td>Для сайта:</td>
							<td colspan="5"><textarea class="img5 form-control" style="height: 50px"><a href="<?php echo $url ?>monitor/view/index/<?echo $server['server_id']?>"><img src="<?php echo $url ?>monitor/view/baner/<?echo $server['server_id']?>.png"></a></textarea>
							</td>
						</tr>
						<tr>
							<td>Для форума:</td>
							<td colspan="5"><textarea class="img6 form-control" style="height: 50px">[url=<?php echo $url ?>monitor/view/index/<?echo $server['server_id']?>][img]<?php echo $url ?>monitor/view/baner/<?echo $server['server_id']?>.png[/img][/url]</textarea>
							</td>
						</tr>
					</tbody>
				</table>
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
									<h3 class="m-portlet__head-text">Игроки онлайн</h3>
								</div>
							</div>	
						</div>
						<div class="m-portlet__body">
							<div class="m-section">
								<div class="m-section__content">
									<table class="table table-striped m-table">
										<thead>
											<tr>
												<th><i class="flaticon-avatar"></i> Имя</th>
												<th><i class="flaticon-like"></i> Счет</th>
											</tr>
										</thead>
										<tbody>
										<?php foreach ($query['players_list'] AS $player => $values): ?>
						                    <tr>
							                    <td><?php echo $query['players_list'][$player]['name'] ?></td>
							                    <td><?php echo $query['players_list'][$player]['score'] ?></td>
						                    </tr>
					                    <?php endforeach; ?>
					                    <?php if(empty($query['players_list'])): ?>
						                    <tr>
							                    <td colspan="5" style="text-align: center;">На данный момент нет онлайн игроков.</td>
						                    <tr>
					                    <?php endif; ?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
    </div>  
</div>
<script>
var online = [
							<?php foreach($stats as $item): ?> 
							[<?php echo strtotime($item['server_stats_date']) * 1000 ?>, <?php echo $item['server_stats_players'] ?>],
							<?php endforeach; ?> 
						];					
						Highcharts.setOptions({
						lang: {
								rangeSelectorZoom: 'Период',
								rangeSelectorFrom: 'С',
								rangeSelectorTo: 'По',
								printChart: 'Печать диаграммы',
								downloadPNG: 'Скачать PNG изображение',
								downloadJPEG: 'Скачать JPEG изображение',
								downloadPDF: 'Скачать PDF документ',
								downloadSVG: 'Скачать SVG изображение',
								contextButtonTitle: 'Контекстное меню графика',
								months: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь',  'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
								shortMonths: ['Янв.', 'Фев.', 'Март.', 'Апр.', 'Май.', 'Июнь.', 'Июль.', 'Авг.', 'Сент.', 'Окт.', 'Ноя.', 'Дек.']
							}
						});
						$('#statsGraph').highcharts('StockChart', {	
							credits:{enabled: false},
							xAxis: {
								type: 'datetime',
								dateTimeLabelFormats:{
									second: '%H:%M:%S',
									minute: '%H:%M',
									hour: '%H:%M',
									day: '%e.%m',
									week: '',
									month: '%m',
									year: '%Y'
								}
							},
							yAxis: {
								allowDecimals: false,
								min: 0
							},
							scrollbar: {
								barBackgroundColor: 'gray',
								barBorderRadius: 7,
								barBorderWidth: 0,
								buttonBackgroundColor: 'gray',
								buttonBorderWidth: 0,
								buttonBorderRadius: 7,
								trackBackgroundColor: 'none',
								trackBorderWidth: 1,
								trackBorderRadius: 8,
								trackBorderColor: '#CCC'
							},
							rangeSelector: {
								selected: 0,
								buttonTheme: {
									width: 50
								},
								buttons: [{
									type: 'day',
									count: 1,
									text: 'ДЕНЬ'
								},{
									type: 'week',
									count: 1,
									text: 'НЕДЕЛЯ'
								},{
									type: 'month',
									count: 1,
									text: 'МЕСЯЦ'
								}]
							},
							tooltip: {
								formatter: function() { //d.m.Y H:i
									var s = '<b>Дата: '+ Highcharts.dateFormat('%e.%m.%Y - %H:%M', this.x) +'</b>';
									$.each(this.points, function(i, point) {s += '<br/>Онлайн : '+point.y;});
									return s;
								}
							},
							series : [{
								name: 'График загруженности сервера',
								data : online,
								type: 'spline',
								tooltip: {
									valueDecimals: 2
								}
							}]
						});			
</script>
<?echo $footer?>