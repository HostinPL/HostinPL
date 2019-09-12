	var step = 2;

	function gotoServer (id) {
		ajax_url('/order/control/' + id);
		window.history.pushState(null, null, '/order/control/' + id);
	}
	
	function promoCode(){
		var promo = $("#promo").val();
		$('.load-promo').css('display', 'block');
		$.ajax({
				
			url: "/order/buy",
			type: "POST",
			data: {ajax: "promo", promo: promo},
			success: function (data) {
				data = $.parseJSON(data);
				if(data.status == 1){
					fly_p('2', 'Код введено неверно. Скидка не предоставлена.');
					$('.load-promo').css('display', 'none');
				} else {
					fly_p('1', 'Скидка в размере '+ data.procent +'% предоставлена.');
					updateForm(data.skidka);
					$('#promo').prop('disabled', true);
					$('.load-promo').css('display', 'none');
				}
			}
			
		})
	}
	
	function slotsForm() {
		var ratePrice = $("#slotsPrice").val();
		var sslots = $("#sslots").val();
		var slots = $("#slots").val();
		if(sslots == slots){
			var price = '0';
		} else {
			if(slots-sslots <= 0) {
				var price = '0';
			} else {
				var price = ratePrice * (slots-sslots);
			}
		}
		
		$('#price').text(price.toFixed(2) + ' руб.');
	}
	
	function bplusSlots() {
		value = parseInt($('#slots').val());
		$('#slots').val(value+1);
		slotsForm();
	}
	function bminusSlots() {
		value = parseInt($('#slots').val());
		$('#slots').val(value-1);
		slotsForm();
	}
	
	function updatePrice() {
		var rateprice = $("#rateprice").html();
		var sslots = $("#sslots").html();
		var price = rateprice * sslots;
		var months = $("#months option:selected").val();
		switch(months) {
			case "3":
				price = 3 * price * 0.95;
				break;
			case "6":
				price = 6 * price * 0.90;
				break;
			case "12":
				price = 12 * price * 0.85;
				break;
		}
		$('#price').text(price.toFixed(2) + ' руб.');
	}
	
	function updateForm(promo) {
		var rateID = $("#rateid option:selected").val();
		var slots = $("#slots").val();
		if(slots < rateData[rateID]['minslots']) {
			slots = rateData[rateID]['minslots'];
			$("#slots").val(slots);
		}
		if(slots > rateData[rateID]['maxslots']) {
			slots = rateData[rateID]['maxslots'];
			$("#slots").val(slots);
		}
		var price = rateData[rateID]['price'] * slots;
		var months = $("#months option:selected").val();
		switch(months) {
			case "3":
				price = 3 * price * 0.95;
				break;
			case "6":
				price = 6 * price * 0.90;
				break;
			case "12":
				price = 12 * price * 0.85;
				break;
		}
		if(promo != null){price = price * promo;}
		$('#price').text(price.toFixed(2) + ' руб.');
		$('#price1').text(price.toFixed(2) + ' руб.');
	}
	
	function plusSlots() {
		value = parseInt($('#slots').val());
		$('#slots').val(value+1);
		updateForm();
	}
	function minusSlots() {
		value = parseInt($('#slots').val());
		$('#slots').val(value-1);
		updateForm();
	}
	
	$("#payServer").click(function(){
		var serverid = $("#serverid").html();
		var months = $("#months option:selected").val();
		$("#payServer").html("<img src=\"https://vk.com/images/upload_inv.gif\" style=\"margin: 5px;\">").show().delay(3000);
		
			$.ajax({
			
				url: "/order/action",
				type: "POST",
				data: {ajax: "true", sid: serverid,action: "pay",months: months},
				success: function (data) {
					data = $.parseJSON(data);
						if(data.status == 1){
							fly_p('1', data.success);
							$("#balanceInfo").html($("#balanceInfo").html()-data.minus);
						} else {
							fly_p('2', data.error);
						}
						$("#payServer").html("Продлить заказ").show().delay(3000);
				}
			})
		
	});
	
	$("#buyServer").click(function(){
		var rateValue = $("#rateid"); 
		var monthsValue = $("#months");
		var slotsValue = $("#slots");
		var locationValue = $("#locationid");
		var promoValue = $("#promo");
		var balance = $("#balance");
		$("#buyServer").html("<img src=\"https://vk.com/images/upload_inv.gif\" style=\"margin: 5px;\">").show().delay(3000);
		
			$.ajax({
			
				url: "/order/buy",
				type: "POST",
				data: {ajax: "order", rate: rateValue.val(),months: monthsValue.val(),slots: slotsValue.val(), location: locationValue.val(), promo: promoValue.val()},
				success: function (data) {
					data = $.parseJSON(data);
					if(data.status == 1){
						fly_p('2', data.error);
						$("#buyServer").html("Оформить заказ").show().delay(3000);
					} else {
						fly_p('1', data.success);
						balance.html(balance.html()-data.minus);
						gotoServer(data.serverid);
					}
				}
				
			})
	});
	
	function saveConfig(serverid) {
	
		var hostname = $("#hostname").val(); 
		var rcon_password = $("#rcon_password").val(); 
		var gamemode = $("#gamemode").val(); 
		var filterscripts = $("#filterscripts").val(); 
		var announce = $("#announce").val(); 
		var query = $("#query").val(); 
		var weburl = $("#weburl").val(); 
		var lanmode = $("#lanmode").val(); 
		var maxnpc = $("#maxnpc").val(); 
		var onfoot_rate = $("#onfoot_rate").val(); 
		var incar_rate = $("#incar_rate").val(); 
		var weapon_rate = $("#weapon_rate").val(); 
		var stream_distance = $("#stream_distance").val(); 
		var stream_rate = $("#stream_rate").val(); 
		var mapname = $("#mapname").val(); 
		var plugins = $("#plugins").val(); 
		var password = $("#password").val(); 

		$("#saveConfig").html("<img src=\"https://vk.com/images/upload_inv.gif\" style=\"margin: 5px;\">").show().delay(3000);
		
			$.ajax({
			
				url: "/order/action",
				type: "POST",
				data: {ajax: "true", sid: serverid, action: 'saveConfig', hostname: hostname, rcon_password: rcon_password, gamemode: gamemode, filterscripts: filterscripts, announce: announce, query: query, weburl: weburl, lanmode: lanmode, maxnpc: maxnpc, onfoot_rate: onfoot_rate, incar_rate: incar_rate, weapon_rate: weapon_rate, stream_distance: stream_distance, stream_rate: stream_rate, mapname: mapname, plugins: plugins, password: password},
				success: function (data) {
					data = $.parseJSON(data);
					if(data.status == 2){
						fly_p('2', data.error);
						$("#saveConfig").html("Сохранить").show().delay(3000);
					} else {
						fly_p('1', data.success);
						ajax_url('/order/config/'+serverid);
					}
				}
				
			})
		
	};

	function restoreConfig(serverid) {
	
		$("#restoreConfig").html("<img src=\"https://vk.com/images/upload_inv.gif\" style=\"margin: 5px;\">").show().delay(3000);
		
			$.ajax({
			
				url: "/order/action",
				type: "POST",
				data: {ajax: "true", sid: serverid, action: 'restoreConfig'},
				success: function (data) {
					data = $.parseJSON(data);
					if(data.status == 2){
						fly_p('2', data.error);
						$("#restoreConfig").html("Восстановить стандартный конфиг").show().delay(3000);
					} else {
						fly_p('1', data.success);
						ajax_url('/order/config/'+serverid);
					}
				}
				
			})
		
	};
	
	function sendAction(serverid, action) {
		$('.load-action').css('display', 'block');
		switch(action) {
			case "reinstall":
			{
				if(!confirm("Вы уверенны в том, что хотите переустановить сервер? Все данные будут удалены.")) return;
				break;
			}
		}
		$.ajax({
			
			url: "/order/action/",
			type: "POST",
			data: {ajax: "true", sid: serverid,action: action},
			success: function (data) {
				data = $.parseJSON(data);
				$('.load-action').css('display', 'none');
				if(data.status == 2){
					fly_p('2', data.error);
				} else {
					fly_p('1', data.success);
					ajax_url(data.url)
					//gotoServer(data.serverid);
				}
			}
			
		})
	}
	
	function kickPlayer(serverid, playerid) {
		$.ajax({ 
			
			url: "/order/action/",
			type: "POST",
			data: {ajax: "true", sid: serverid,action: "kickplayer",playerid: playerid},
			success: function (data) {
				data = $.parseJSON(data);
				if(data.status == 2){
					fly_p('2', data.error);
				} else {
					fly_p('1', data.success);
					ajax_url("/order/control/"+serverid);
				}
			}
			
		})
	}
	
	function updatelog() {
		var serverid = $("#serverid").html();
		var autoscroll = $("#autoscroll");
			if (autoscroll.checked == false) {
				setTimeout(updatelog, 15000);
				return;
			}
		
		$.ajax({
			
			url: "/order/action/",
			type: "POST",
			data: {ajax: "true", sid: serverid,action: "getconsole"},
			success: function (data) {
				displayconsole(serverid, data);
				setTimeout(updatelog, 15000);
			}
			
		})
	}
						
	function displayconsole(serverid, sText) {
		var divConsole = $("#textAreaObject");
		divConsole.val(sText);
		divConsole.scrollTop = divConsole.scrollHeight;
		return;
	}
	
	$("#sendRcon").click(function(){
		var serverid = $("#serverid").html();
		var cmd = $("#cmd").val();
		$("#sendRcon").html("<img src=\"https://vk.com/images/upload_inv.gif\" style=\"margin: 5px;\">").show().delay(3000);
		
			$.ajax({
			
				url: "/order/action",
				type: "POST",
				data: {ajax: "true", sid: serverid,action: "rcon_cmd",cmd: cmd},
				success: function (data) {
					data = $.parseJSON(data);
						fly_p('1', data.success);
						$("#sendRcon").html("Отправить").show().delay(3000);
				}
			})
		
	});
	
	function installMode(serverid, action) {
		$("#"+action).html("<img src=\"https://vk.com/images/upload_inv.gif\" style=\"margin: 5px;\">").show().delay(3000);
		
		$.ajax({
			
			url: "/order/action/",
			type: "POST",
			data: {ajax: "true", sid: serverid,action: "installMode",mode: action},
			success: function (data) {
				data = $.parseJSON(data);
				if(data.status == 2){
					fly_p('2', data.error);
					ajax_url("/order/gamemode/"+serverid);
				} else {
					fly_p('1', data.success);
					ajax_url("/order/gamemode/"+serverid);
				}
			}
			
		})
	}

	$('body').on('click', '.next_step', function(){
		$('#step_1').removeClass("active");
		$('#step_2').addClass("active");
		$('#step_3').removeClass("active");
		$('#open-step-1').removeClass("active");
		$('#open-step-2').addClass("active");
		$('#open-step-3').removeClass("active");
		$('.next_step').addClass("next_step_two").removeClass("next_step");
	});

	$('body').on('click', '.next_step_two', function(){
		$('#step_1').removeClass("active");
		$('#step_2').removeClass("active");
		$('#step_3').addClass("active");
		$('#open-step-1').removeClass("active");
		$('#open-step-2').removeClass("active");
		$('#open-step-3').addClass("active");
		$('.next_step_two').hide();
		$('#buyServer').show();
	});

