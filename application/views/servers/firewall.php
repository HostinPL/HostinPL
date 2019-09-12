<?php
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
?>
<?php include 'application/views/common/menuserver.php';?>
<style>
.m-btn--icon.m-btn--icon-only {
  width: 23px;
  height: 23px;
}
.m-btn--icon.m-btn--icon-only [class^="flaticon-"], .m-btn--icon.m-btn--icon-only [class*=" flaticon-"] {
  font-size: 1.1rem;
}
</style>
<div class="m-content">
	<div class="row">
	    <div class="col-xl-3 col-lg-4">
		    <div class="m-portlet m-portlet--full-height   m-portlet--unair">
			    <div class="m-portlet__body">
				    <div class="m-card-profile">
					    <div class="m-card-profile__title m--hide"></div>
					    <div class="m-card-profile__pic">
						    <div class="m-card-profile__pic-wrapper">
						        <img src="/application/public/img/firewall.png" alt="">
						    </div>
					    </div>
					    <div class="m-card-profile__details">
						    <span class="m-card-profile__name">Firewall</span>
							<a href="#" class="m-card-profile__email m-link">Блокировка ip адресов.</a>						
						</div>
				    </div>	
				    <ul class="m-nav m-nav--hover-bg m-portlet-fit--sides">
					    <li class="m-nav__separator m-nav__separator--fit"></li>
					    <li class="m-nav__section m--hide">
						    <span class="m-nav__section-text"></span>
					    </li>
					    <li class="m-nav__item">
						    <a href="#" data-toggle="modal" data-target="#firewallinfo" class="m-nav__link">
							    <i class="m-nav__link-icon fa flaticon-list-3"></i>
							    <span class="m-nav__link-text">Информация</span>
						    </a>
					    </li>
					</ul>
			   </div>			
		    </div>	
	    </div>
	    <div class="col-xl-9 col-lg-8">
		    <div class="m-portlet m-portlet--full-height m-portlet--tabs   m-portlet--unair">
			    <div class="m-portlet__head">
				    <div class="m-portlet__head-caption">
			            <div class="m-portlet__head-title">
				            <h3 class="m-portlet__head-text">Добавить адрес</h3>
			            </div>
		            </div>
			    </div>
			    <div class="m-portlet__body">
					<div class="m-portlet__body">
						<form class="form-horizontal" action="#" id="addForm" method="POST">
							<div class="form-group m-form__group">
								<label>Введите IP адресс</label>
								<input class="form-control m-input m-input--air" id="address" name="address" placeholder="0.0.0.0">
							</div>
							<button type="submit" class="btn btn-accent m-btn m-btn--air m-btn--custom">Добавить</button>
						 </form>
					</div>
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
									<h3 class="m-portlet__head-text">Заблокированые адреса</h3>
								</div>
							</div>	
						</div>
						<div class="m-portlet__body">
							<div class="m-section">
								<div class="m-section__content">
									<table class="table table-striped m-table">
										<thead>
											<tr>
												<th><i class="flaticon-list"></i></th>
												<th><i class="flaticon-placeholder-2"></i> Адрес</th>
												<th><i class="flaticon-calendar-2"></i> Дата добавления</th>
												<th><i class="flaticon-multimedia"></i> Действие</th>
											</tr>
										</thead>
										<tbody>
											<?php foreach($Firewalls as $item): ?>
											<tr>
												<th scope="row"><?php echo $item['firewall_id'] ?></th>
												<td><?php echo $item['server_ip'] ?></td>
												<td><?php echo $item['firewall_add'] ?></td>
												<td>
													<a href="#javascript" onclick="sendAction('delete', <?php echo $item['firewall_id'] ?>)" data-container="body" data-toggle="m-popover" data-placement="top" data-content="Удалить" data-original-title="" title="" class="btn btn-outline-danger m-btn m-btn--icon m-btn--icon-only">
														<i class="fa flaticon-delete-2"></i>
													</a>
												</td>
											</tr>
											<?php endforeach; ?>
											<?php if(empty($Firewalls)): ?> 
											<tr>
												<td colspan="6" style="text-align: center;">На данный момент нет IP адресов.</td>
											</tr>
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
<!--begin::Modal-->
<div class="modal fade" id="firewallinfo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Информация</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            	<p>
            	Firewall - это гарантированная защита Вашего сервера от нежелательных гостей. Он позволяет ограничить доступ определенным лицам по IP-адресу прямо из Панели управления. В отличие от бана в игре, такая блокировка полностью фильтрует весь трафик с данного IP-адреса.
                </p>
            </div>
        </div>
    </div>
</div>
<!--end::Modal-->
<script>	
	$('#addForm').ajaxForm({ 
		url: '/servers/firewall/ajax/<?php echo $server['server_id'] ?>',
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
					setTimeout("reload()", 1500);
					break;
			}
		},
		beforeSubmit: function(arr, $form, options) {
			$('button[type=submit]').prop('disabled', true);
		}
	});

	function sendAction(action, firewallid) {
		
		$.ajax({ 
			url: '/servers/firewall/action/'+action+'/<?php echo $server['server_id'] ?>/'+firewallid,
			dataType: 'text',
			success: function(data) {
				console.log(data);
				data = $.parseJSON(data);
				switch(data.status) {
					case 'error':
						toastr.error(data.error);
						$('#controlBtns button').prop('disabled', false);
						break;
					case 'success':
						toastr.success(data.success);
						setTimeout("reload()", 1500);
						break;
				}
			}
		});
	}	
</script>
<?php echo $footer ?>
