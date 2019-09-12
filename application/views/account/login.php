<?php echo $loginheader ?>
		<script>
			$('#loginForm').ajaxForm({ 
				url: '/account/login/ajax',
				dataType: 'text',
				success: function(data) {
					console.log(data);
					data = $.parseJSON(data);
					switch(data.status) {
						case 'error':
							toastr.error(data.error);
							$('button[type=submit]').prop('disabled', false);
							break;
						case 'success':
							toastr.success(data.success);
							setTimeout("redirect('/')", 1500);
							break;
					}
				},
				beforeSubmit: function(arr, $form, options) {
					$('button[type=submit]').prop('disabled', true);
				}
			});
		</script>
<?php echo $loginfooter ?>
