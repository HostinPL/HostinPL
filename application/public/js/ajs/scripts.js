var conf = [];
	conf['load'] = 0; 
	opts = {
			"closeButton": true,
			"debug": false,
			"positionClass": "toast-top-right",
			"onclick": null,
			"showDuration": "300",
			"hideDuration": "1000",
			"timeOut": "5000",
			"extendedTimeOut": "1000",
			"showEasing": "swing",
			"hideEasing": "linear",
			"showMethod": "fadeIn",
			"hideMethod": "fadeOut"
		};
function fly_p(name,text){
	switch(name){
		case "1":
			toastr.success(text, null, opts);
		break;
		case "2":
			toastr.error(text, null, opts);
		break;
		case "3":
			toastr.warning(text, null, opts);
		break;
		default:
			toastr.info(text, opts);
		break;
	}
}
function ajax_url(url,s){
	$("#url_report").val("http://my.serversamp.ru"+ url);
	if(conf['load'] == 1){
		fly_p('2', 'Повторите запрос через несколько секунд');
	}else{
		conf['load'] = 1;
		$('#loading-page').css('display', 'block');
		if(s != "1"){
			$("html,body").scrollTop(0);
		}
		$.ajax({
			url: url,
			type: "POST",
			data: 'ajax=loadpage',
			dataType: "html",
			success: function(data){
				$('.block-body').empty();
				$('.block-body').html(data);
				$('#main-menu').html($('#nurl_nav').html());
				$('title').html($('#nurl_title').html());
				conf['load'] = 0;
				$('#loading-page').css('display', 'none');
				$('a[rel=tooltip]').tooltip();
			}
		});
	}
}

$(document).ready(function(){
	$("#balanceButton").click(function(){
	
		var inputammountValue = $("#ammount"); 
		$("#balanceButton").html("<img src=\"https://vk.com/images/upload_inv.gif\" style=\"margin: 5px;\">").show().delay(3000);
		
		if (inputammountValue.val() == "") {
			fly_p('2', 'Введите сумму пополнения');
			$("#balanceButton").html("Пополнить").show().delay(3000);
		} else {
			if(inputammountValue.val() >= "10"){
				$.ajax({
				
					url: "/account/billing",
					type: "POST",
					data: {ajax: "balance", ammount: inputammountValue.val()},
					success: function (data) {
						location.href = data;
					}
					
				})
			} else {
				fly_p('2', 'Сумма пополнения должна быть больше <b>10 руб.</b>');
				$("#balanceButton").html("Пополнить").show().delay(3000);
			}
		}
		
	});
	
	$("#reportButton").click(function(){
	
		var message = $("#message"); 
		var url = $("#url_report");
		$("#reportButton").html("<img src=\"https://vk.com/images/upload_inv.gif\" style=\"margin: 5px;\">").show().delay(3000);
		
		if (message.val() == "") {
			fly_p('2', 'Введите текст сообщения');
			$("#reportButton").html("Отправить").show().delay(3000);
		} else {
			$.ajax({
			
				url: "/main/index",
				type: "POST",
				data: {ajax: "report", message: message.val(),url: url.val()},
				success: function (data) {
					if(data == 1){
						fly_p('1', 'Сообщение отправлено. Благодарим за помощь!');
						$('#reportModal').modal('hide');
						$("#reportButton").html("Отправить").show().delay(3000);
					} else {
						fly_p('2', data);
						$("#reportButton").html("Отправить").show().delay(3000);
					}
				}
				
			})
		}
		
	});
	
	$("#logout").click(function(){
		$.ajax({
		
			url: "/account/exit",
			type: "POST",
			data: {ajax: "exit"},
			success: function (data) {
				$('#contentWrapper').hide (function () { });
				setTimeout (function (){location.href = '/';}, 800);
			}
			
		})
	});
	
	$('[data-toggle=offcanvas]').click(function() {
		$('.row-offcanvas').toggleClass('active');
	});

	function getNotifications(){
		$.ajax({
			url: "/main/notifications",
			type: "POST",
			data: {ajax: "get"},
			success: function(data){
				if(data == 0){
					console.log("Возникла ошибка при получении уведомлений");
				} else {
					$("#notifications").html(data);
				}
			}
		});
	}
	
	function readNotification(){
		$.ajax({
			url: "/main/notifications",
			type: "POST",
			data: {ajax: "read", type: "all"},
			success: function(data){
				getNotifications();
			}
		});
	}

	$('#updateNotif').click(getNotifications());
	$("body").on('click', '#readAllNotif', function(){
		readNotification("all");
	});
	$("body").on('click', '#readNotif', function(){
		getNotifications();
	});

	window.setInterval(function(){
			$.ajax({
				url: "/main/notifications",
				type: "POST",
				data: {ajax: "check"},
				success: function(data){
					if(data != 0){
						$("#new_notifications").html(data).css("display", "block");
						$("#new_notifications_second").html("Вы имеете <strong>" + data + "</strong> новых уведомлений.");
						getNotifications();
						if(notif < data){
							notif = data;
							document.getElementById('notif_sound').play();
							console.log(notif + "," + data);
						} else {
							notif = data;
						}
					} else {
						$("#new_notifications_second").html("У вас нет новых уведомлений.");
						$("#new_notifications").css("display", "none");
					}
				}
			});
	}, 10000);

	$('body').on('click', 'a', function(){
		var url = $(this).attr('href');
			
		if(url.indexOf("#") + 1){
			return true;
		}

		ajax_url(url);

		if(url != window.location){
			window.history.pushState(null, null, url);
		}

		return false;
	});

	if(location.pathname == "/") {
		ajax_url("/");
	} else {	
		ajax_url(location.pathname);
	}

	$('body').tooltip({
		selector: "[data-toggle=tooltip]",
		container: "body"
	})
	$("[data-toggle=popover]")
		.popover()
});