	function gotoServer (id) {
		ajax_url('/admin/order/control/' + id);
		window.history.pushState(null, null, '/admin/order/control/' + id);
	}
	
	function plusSlots() {
		value = parseInt($('#slots').val());
		$('#slots').val(value+1);
	}
	function minusSlots() {
		value = parseInt($('#slots').val());
		$('#slots').val(value-1);
	}
	
	$("#payServer").click(function(){
		var serverid = $("#serverid").html();
		var months = $("#months option:selected").val();
		$("#payServer").html("<img src=\"https://vk.com/images/upload_inv.gif\" style=\"margin: 5px;\">").show().delay(3000);
		
			$.ajax({
			
				url: "/admin/order/action",
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
			
				url: "/admin/order/action",
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
			
				url: "/admin/order/action",
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
			
			url: "/admin/order/action/",
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
	
	function updatelog() {
		var serverid = $("#serverid").html();
		var autoscroll = $("#autoscroll");
			if (autoscroll.checked == false) {
				setTimeout(updatelog, 15000);
				return;
			}
		
		$.ajax({
			
			url: "/admin/order/action/",
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
			
				url: "/admin/order/action",
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
			
			url: "/admin/order/action/",
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