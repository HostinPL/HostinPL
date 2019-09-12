<?php
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
?>
<script src='https://www.google.com/recaptcha/api.js'></script>
<script type="text/javascript">
$(document).ready(
	function get() {
		setTimeout(getstatus('online'), 105000);
		setTimeout(get, 35000);
	}
);
function getstatus(action) {
	$.ajax({ 
		url: '/common/footer/getstatus/'+action,
		dataType: 'text',
		success: function(data) {
			data = $.parseJSON(data);
			switch(data.status) {
				case 'error':
					toastr.error(data.error);
					$('#controlBtns button').prop('disabled', false);
					break;
				case 'online':
					console.info(data.online); 
					$("#online").html(data.online_usr)
					break
			}
		},
	});
}
</script>