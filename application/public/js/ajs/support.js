	$("#newTicket").click(function(){
	
		var inputName = $("#name");
		var inputServer = $("#server"); 
		var inputDep = $("#dep"); 
		var inputText = $("#text"); 
		$("#newTicket").html("<img src=\"https://vk.com/images/upload_inv.gif\" style=\"margin: 5px;\">").show().delay(3000);
		
		if (inputName.val() == "" || inputText.val() == "") {
			fly_p('2', 'Заполните все поля');
			$("#newTicket").html("<i class=\"glyphicon glyphicon-ok\"></i> Создать").show().delay(3000);
		} else {
			
			$.ajax({
			
				url: "/support/new",
				type: "POST",
				data: {ajax: "new", name: inputName.val(),server: inputServer.val(),dep: inputDep.val(),text: inputText.val()},
				success: function (data) {
					ajax_url("/support/ticket/"+data);
				}
				
			})
			
		}
		
	});
	
	function refreshmessagess(){
		$.ajax({
			
			url: "/support/ticket",
			type: "POST",
			data: {ajax: "getMessagess", tid: $('#ticketid').html()},
			success: function (data) {
				$("#messagess").html(data);
			}
		})
	}
	
	function assAnswer(messageid, asstype, uid){
		$("#assAnswer_"+messageid).html("<img src=\"https://vk.com/images/upload_inv.gif\" style=\"margin: 5px;\">").show().delay(3000);
		$.ajax({ 
			
			url: "/support/ticket",
			type: "POST",
			data: {ajax: "assmessage", mid: messageid,ass: asstype,uid: uid},
			success: function (data) {
				refreshmessagess();
			}
			
		})
	}
	
	function closeticket(ticketid){
		$.ajax({ 
			
			url: "/support/ticket",
			type: "POST",
			data: {ajax: "closeticket", tid: ticketid},
			success: function (data) {
				refreshmessagess();
				$('#ticketOpen').hide();
				$('#ticketClose').show();
			}
			
		})
	}
	
	$("#addAnswer").click(function(){
	
		var inputText = $("#text"); 
		$("#addAnswer").html("<img src=\"https://vk.com/images/upload_inv.gif\" style=\"margin: 5px;\">").show().delay(3000);
		
		if (inputText.val() == "") {
			fly_p('2', 'Введите сообщение для ответа');
			$("#addAnswer").html("Отправить").show().delay(3000);
		} else {
			
			$.ajax({
			
				url: "/support/ticket",
				type: "POST",
				data: {ajax: "addmessage", text: inputText.val(), tid: $('#ticketid').html()},
				success: function (data) {
					if(data == 1){
						refreshmessagess();
						inputText.val("");
						$("#addAnswer").html("Отправить").show().delay(3000);
					} else {
						fly_p('2', data);
						$("#addAnswer").html("Отправить").show().delay(3000);
					}
				}
				
			})
			
		}
		
	});
	
	setInterval(refreshmessagess, 20000);