<?php echo $admheader ?>
<div class="col-12">
    <div class="m-content">
        <div class="row">
        	<div class="col-lg-6">
                <div class="m-portlet m-portlet--brand m-portlet--head-solid-bg">
					<div class="m-portlet__head">
						<div class="m-portlet__head-caption">
							<div class="m-portlet__head-title">
								<span class="m-portlet__head-icon">
									<i class="flaticon-diagram"></i>
								</span>
								<h3 class="m-portlet__head-text">
									Пополнение счета
								</h3>
							</div>
						</div>
					</div>
					<div id="invoices" style="height: 350px;"></div>
				</div>
			</div>
			<div class="col-lg-6">
                <div class="m-portlet m-portlet--brand m-portlet--head-solid-bg">
					<div class="m-portlet__head">
						<div class="m-portlet__head-caption">
							<div class="m-portlet__head-title">
								<span class="m-portlet__head-icon">
									<i class="flaticon-diagram"></i>
								</span>
								<h3 class="m-portlet__head-text">
									Регистраций
								</h3>
							</div>
						</div>
					</div>
					<div id="registers" style="height: 350px;"></div>
				</div>
			</div>
			<div class="col-lg-6">
                <div class="m-portlet m-portlet--brand m-portlet--head-solid-bg">
					<div class="m-portlet__head">
						<div class="m-portlet__head-caption">
							<div class="m-portlet__head-title">
								<span class="m-portlet__head-icon">
									<i class="flaticon-diagram"></i>
								</span>
								<h3 class="m-portlet__head-text">
									Общее количевство игроков
								</h3>
							</div>
						</div>
					</div>
					<div id="players" style="height: 350px;"></div>
				</div>
			</div>
			<div class="col-lg-6">
                <div class="m-portlet m-portlet--brand m-portlet--head-solid-bg">
					<div class="m-portlet__head">
						<div class="m-portlet__head-caption">
							<div class="m-portlet__head-title">
								<span class="m-portlet__head-icon">
									<i class="flaticon-diagram"></i>
								</span>
								<h3 class="m-portlet__head-text">
									Общая нагрузка на железо
								</h3>
							</div>
						</div>
					</div>
					<div id="loads" style="height: 350px;"></div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
<?php echo $charts; ?>
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
	$('#invoices').highcharts('StockChart', {	
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
				$.each(this.points, function(i, point) {s += '<br/>Доход : '+point.y;});
				return s;
			}
		},
		series : [{
			name: 'График прибыли',
			data : invoices,
			type: 'spline',
			tooltip: {
				valueDecimals: 2
			}
		}]
	});							
	
	$('#registers').highcharts('StockChart', {	
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
				$.each(this.points, function(i, point) {s += '<br/>Зарегистрировано : '+point.y;});
				return s;
			}
		},
		series : [{
			name: 'График регистраций клиентов',
			data : registers,
			type: 'spline',
			tooltip: {
				valueDecimals: 2
			}
		}]
	});				

	$('#players').highcharts('StockChart', {	
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
			name: 'График онлайна игроков',
			data : players,
			type: 'spline',
			tooltip: {
				valueDecimals: 2
			}
		}]
	});			
	
	$('#loads').highcharts('StockChart', {	
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

		series : [{
			name: 'CPU',
			data : loads1,
			type: 'spline',
			tooltip: {
				valueDecimals: 2
			}
		},{
			name: 'HDD',
			data : loads2,
			type: 'spline',
			tooltip: {
				valueDecimals: 2
			}
		},{
			name: 'RAM',
			data : loads3,
			type: 'spline',
			tooltip: {
				valueDecimals: 2
			}
		},
		]
	});				

</script>

<?php echo $footer ?>