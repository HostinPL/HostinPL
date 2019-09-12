	$("#loginButton").click(function(){
	
		var inputloginValue = $("#login"); 
		var inputpasswordValue = $("#password"); 
		$("#loginButton").html("<img src=\"https://vk.com/images/upload_inv.gif\" style=\"margin: 5px;\">").show().delay(3000);
		
		if (inputloginValue.val() == "" || inputpasswordValue.val() == "") {
			fly_p('2', 'Заполните все поля!');
			$("#loginButton").html("Авторизация").show().delay(3000);
		} else {
			
			$.ajax({
			
				url: "/account/login",
				type: "POST",
				data: {ajax: "login", login: inputloginValue.val(),password: inputpasswordValue.val()},
				success: function (data) {
					if(data == 1){
						$('#contentWrapper').hide (function () { });
						setTimeout (function (){location.href = (location.href + '?');}, 800);
					} else {
						fly_p('2', 'Неверный логин или пароль!');
						$("#loginButton").html("Авторизация").show().delay(3000);
					}
				}
				
			})
			
		}
		
	});

	$("#restoreButton").click(function(){
	
		$("#restoreButton").html("<img src=\"https://vk.com/images/upload_inv.gif\" style=\"margin: 5px;\">").show().delay(3000);
		
		if ($("#login").val() == "" || $("#email").val() == "") {
			fly_p('2', 'Заполните все поля!');
			$("#restoreButton").html("Восстановить пароль").show().delay(3000);
		} else {
			
			$.ajax({
			
				url: "/account/restore",
				type: "POST",
				data: {ajax: "restore", login: $("#login").val(),email: $("#email").val()},
				success: function (data) {
					console.log(data);
					if(data == 1){
						fly_p('1', 'На ваш Email отправлен новый пароль!');
						$("#restoreButton").html("Восстановить пароль").show().delay(3000);
					} else {
						fly_p('2', 'Логин и Email не совпадают!');
						$("#restoreButton").html("Восстановить пароль").show().delay(3000);
					}
				}
				
			})
			
		}
		
	});
	
	$("#registerButton").click(function(){
	
		var login = $("#login").val(); 
		var firstname = $("#firstname").val(); 
		var lastname = $("#lastname").val(); 
		var email = $("#email").val(); 
		var password = $("#password").val(); 
		var password_repeat = $("#password_repeat").val(); 
		$("#registerButton").html("<img src=\"https://vk.com/images/upload_inv.gif\" style=\"margin: 5px;\">").show().delay(3000);
		
		if (login == "" || firstname == "" || lastname == "" || email == "" || password == "" || password_repeat == "") {
			fly_p('2', 'Заполните все поля!');
			$("#registerButton").html("Зарегестрироваться").show().delay(3000);
		} else {
			
			if(password != password_repeat){
				fly_p('2', 'Пароли должны совпадать!');
				$("#registerButton").html("Зарегестрироваться").show().delay(3000);
			} else {
			
				$.ajax({
				
					url: "/account/register",
					type: "POST",
					data: {ajax: "reg", login: login, firstname: firstname, lastname: lastname, email: email, password: password,referal: $("#partner").html()},
					success: function (data) {
						if(data == 1){
							fly_p('1', 'Вы успешно зарегестрировались!');
							setTimeout (function (){location.href = ('/?regcash');}, 800);
						} 
						if(data == 2) {
							fly_p('2', 'При регистрации произошла ошибка! Повторите попытку!');
							$("#registerButton").html("Зарегестрироваться").show().delay(3000);
						}
						if(data == 3) {
							fly_p('2', 'Укажите верный Email адрес!');
							$("#registerButton").html("Зарегестрироваться").show().delay(3000);
						}
						if(data == 4) {
							fly_p('2', 'Указанный вами логин уже занят! Придумайте другой!');
							$("#registerButton").html("Зарегестрироваться").show().delay(3000);
						}
						if(data == 5) {
							fly_p('2', 'Указанный вами Email адрес уже занят! Используйте другой!');
							$("#registerButton").html("Зарегестрироваться").show().delay(3000);
						}
						if(data == 6){
							fly_p('2', 'Пароль должен содержать от 6 до 32 латинских букв, цифр и знаков <i>,.!?_-</i>!');
							$("#registerButton").html("Зарегестрироваться").show().delay(3000);
						}
						if(data == 7){
							fly_p('2', 'Укажите реальное Имя!');
							$("#registerButton").html("Зарегестрироваться").show().delay(3000);
						}
						if(data == 8){
							fly_p('2', 'Укажите реальную Фамилию!');
							$("#registerButton").html("Зарегестрироваться").show().delay(3000);
						}
						if(data == 9){
							fly_p('2', 'Логин должен содержать от 6 до 15 латинских букв и цифр!');
							$("#registerButton").html("Зарегестрироваться").show().delay(3000);
						}
					}
					
				})

			}
		}
		
	});
	
	$("#saveName").click(function(){
	
		var inputloginValue = $("#login"); 
		var inputfirstnameValue = $("#firstname"); 
		var inputlastnameValue = $("#lastname"); 
		$("#saveName").html("<img src=\"https://vk.com/images/upload_inv.gif\" style=\"margin: 5px;\">").show().delay(3000);
		
		if (inputloginValue.val() == "" || inputfirstnameValue.val() == "" || inputlastnameValue.val() == "") {
			fly_p('2', 'Заполните все поля');
			$("#saveName").html("Сохранить").show().delay(3000);
		} else {
			
			$.ajax({
			
				url: "/account",
				type: "POST",
				data: {ajax: "changename", login: inputloginValue.val(),firstname: inputfirstnameValue.val(),lastname: inputlastnameValue.val()},
				success: function (data) {
					if(data == 1){
						fly_p('1', 'Данные изменены');
						$("#saveName").html("Сохранить").show().delay(3000);
					} else {
						fly_p('2', 'Логин уже занят');
						$("#saveName").html("Сохранить").show().delay(3000);
					}
				}
				
			})
			
		}
		
	});
	
	$("#saveEmail").click(function(){
	
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
						
							url: "/account",
							type: "POST",
							data: {ajax: "changemail", newmail: inputnewmailValue.val(),newmail_repeat: inputnewmail_repeatValue.val()},
							success: function (data) {
								if(data == 1){
									fly_p('1', 'Email адрес изменен');
									inputemailValue.val(inputnewmailValue.val());
									inputnewmailValue.val('');
									inputnewmail_repeatValue.val('');
									$("#saveEmail").html("Сохранить").show().delay(3000);
								} else {
									fly_p('2', 'Email уже занят');
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
	
	$("#savePass").click(function(){
	
		var inputpasswordValue = $("#password"); 
		var inputpasswordnewValue = $("#passwordnew"); 
		var inputpasswordnew_repeatValue = $("#passwordnew_repeat"); 
		$("#savePass").html("<img src=\"https://vk.com/images/upload_inv.gif\" style=\"margin: 5px;\">").show().delay(3000);
		
		if (inputpasswordValue.val() == "" || inputpasswordnewValue.val() == "" || inputpasswordnew_repeatValue.val() == "") {
			fly_p('2', 'Заполните все поля');
			$("#savePass").html("Сохранить").show().delay(3000);
		} else {
			if(inputpasswordValue.val() != inputpasswordnewValue.val()){
				if(inputpasswordnewValue.val() == inputpasswordnew_repeatValue.val()){
					$.ajax({
					
						url: "/account",
						type: "POST",
						data: {ajax: "changepass", password: inputpasswordValue.val(),newpass: inputpasswordnewValue.val()},
						success: function (data) {
							if(data == 1){
								fly_p('1', 'Пароль изменен');
								inputpasswordValue.val('');
								inputpasswordnewValue.val('');
								inputpasswordnew_repeatValue.val('');
								$("#savePass").html("Сохранить").show().delay(3000);
							} 
							if(data == 2){
								fly_p('2', 'Введен неверный текущий пароль');
								$("#savePass").html("Сохранить").show().delay(3000);
							}
						}
						
					})
				} else {
					fly_p('2', 'Введеные новые пароли не совпадают');
					$("#savePass").html("Сохранить").show().delay(3000);
				}
			} else {
				fly_p('2', 'Новый пароль совпадает с текущим');
				$("#savePass").html("Сохранить").show().delay(3000);
			}
		}
		
	});
	
	function refreshIPlist(){
		$.ajax({
			
			url: "/account/security",
			type: "POST",
			data: {ajax: "getIP"},
			success: function (data) {
				$("#IPlist").html(data);
			}
		})
	}
	
	function removeIP(id){
		$("#ip_"+id+"").html("<img src=\"https://vk.com/images/upload_inv.gif\" style=\"margin: 5px;\">").show().delay(3000);

			$.ajax({ 
			
				url: "/account/security",
				type: "POST",
				data: {ajax: "removeIP", id: id},
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
	
		var inputipValue = $("#ip"); 
		$("#addIP").html("<img src=\"https://vk.com/images/upload_inv.gif\" style=\"margin: 5px;\">").show().delay(3000);
		
		if (inputipValue.val() == "") {
			fly_p('2', 'Введите IP адрес');
			$("#addIP").html("Сохранить").show().delay(3000);
		} else {
			
			$.ajax({
			
				url: "/account/security",
				type: "POST",
				data: {ajax: "addIP", ip: inputipValue.val()},
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