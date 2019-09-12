	$("#saveName").click(function(){
		var userid = $("#userid").html();
		var inputloginValue = $("#login"); 
		var inputfirstnameValue = $("#firstname"); 
		var inputlastnameValue = $("#lastname"); 
		$("#saveName").html("<img src=\"https://vk.com/images/upload_inv.gif\" style=\"margin: 5px;\">").show().delay(3000);
		
		if (inputloginValue.val() == "" || inputfirstnameValue.val() == "" || inputlastnameValue.val() == "") {
			fly_p('2', 'Заполните все поля');
			$("#saveName").html("Сохранить").show().delay(3000);
		} else {
			
			$.ajax({
			
				url: "/admin/account/user",
				type: "POST",
				data: {ajax: "changename", login: inputloginValue.val(),firstname: inputfirstnameValue.val(),lastname: inputlastnameValue.val(),uid: userid},
				success: function (data) {
					if(data == 1){
						fly_p('1', 'Данные изменены');
						$("#saveName").html("Сохранить").show().delay(3000);
					} else {
						fly_p('2', data);
						$("#saveName").html("Сохранить").show().delay(3000);
					}
				}
				
			})
			
		}
		
	});
	
	$("#saveOther").click(function(){
		var userid = $("#userid").html();
		var balance = $("#balance"); 
		var group = $("#group"); 
		$("#saveOther").html("<img src=\"https://vk.com/images/upload_inv.gif\" style=\"margin: 5px;\">").show().delay(3000);
		
		if (balance.val() == "" || group.val() == "") {
			fly_p('2', 'Заполните все поля');
			$("#saveOther").html("Сохранить").show().delay(3000);
		} else {
			
			$.ajax({
			
				url: "/admin/account/user",
				type: "POST",
				data: {ajax: "saveother", balance: balance.val(),group: group.val(),uid: userid},
				success: function (data) {
					if(data == 1){
						fly_p('1', 'Данные изменены');
						$("#saveOther").html("Сохранить").show().delay(3000);
					} else {
						fly_p('2', 'Вы не администратор');
						$("#saveOther").html("Сохранить").show().delay(3000);
					}
				}
				
			})
			
		}
		
	});
	
	$("#saveEmail").click(function(){
		var userid = $("#userid").html();
		var inputemailValue = $("#email"); 
		var inputnewmailValue = $("#newmail"); 
		var inputnewmail_repeatValue = $("#newmail_repeat"); 
		$("#saveEmail").html("<img src=\"https://vk.com/images/upload_inv.gif\" style=\"margin: 5px;\">").show().delay(3000);
		
		if (inputnewmailValue.val() == "" || inputnewmail_repeatValue.val() == "") {
			fly_p('2', 'Заполните все поля');
			$("#saveEmail").html("Сохранить").show().delay(3000);
		} else {
			if(inputemailValue.val() != inputnewmailValue.val()){
				if(inputnewmailValue.val() == inputnewmail_repeatValue.val()){
						$.ajax({ 
						
							url: "/admin/account/user",
							type: "POST",
							data: {ajax: "changemail", newmail: inputnewmailValue.val(),newmail_repeat: inputnewmail_repeatValue.val(),uid: userid},
							success: function (data) {
								if(data == 1){
									fly_p('1', 'Email адрес изменен');
									inputemailValue.val(inputnewmailValue.val());
									inputnewmailValue.val('');
									inputnewmail_repeatValue.val('');
									$("#saveEmail").html("Сохранить").show().delay(3000);
								} else {
									fly_p('2', data);
									$("#saveEmail").html("Сохранить").show().delay(3000);
								}
							}
							
						})
				} else {
					fly_p('2', 'Введенные почтовые адреса не совпадают');
					$("#saveEmail").html("Сохранить").show().delay(3000);
				}
			} else {
				fly_p('2', 'Почтовый адрес совпадает с уже существующим.');
				$("#saveEmail").html("Сохранить").show().delay(3000);
			}
		}
	});
	
	function refreshIPlist(){
		var userid = $("#userid").html();
		$.ajax({
			
			url: "/admin/account/security",
			type: "POST",
			data: {ajax: "getIP",uid: userid},
			success: function (data) {
				$("#IPlist").html(data);
			}
		})
	}
	
	function removeIP(id){
		var userid = $("#userid").html();
		$("#ip_"+id+"").html("<img src=\"https://vk.com/images/upload_inv.gif\" style=\"margin: 5px;\">").show().delay(3000);

			$.ajax({
			
				url: "/admin/account/security",
				type: "POST",
				data: {ajax: "removeIP", id: id,uid: userid},
				success: function (data) {
					if(data == 1){
						fly_p('1', 'IP адрес удален');
						refreshIPlist();
					} else {
						fly_p('2', data);
					}
				}
				
			})
		
	};
	
	$("#addIP").click(function(){
		var userid = $("#userid").html();
		var inputipValue = $("#ip"); 
		$("#addIP").html("<img src=\"https://vk.com/images/upload_inv.gif\" style=\"margin: 5px;\">").show().delay(3000);
		
		if (inputipValue.val() == "") {
			fly_p('2', 'Введите IP адрес');
			$("#addIP").html("Сохранить").show().delay(3000);
		} else {
			
			$.ajax({
			
				url: "/admin/account/security",
				type: "POST",
				data: {ajax: "addIP", ip: inputipValue.val(),uid: userid},
				success: function (data) {
					if(data == 1){
						fly_p('1', 'IP адрес добавлен');
						refreshIPlist();
						$("#addIP").html("Сохранить").show().delay(3000);
					} else {
						fly_p('2', data);
						$("#addIP").html("Сохранить").show().delay(3000);
					}
				}
				
			})
			
		}
	});