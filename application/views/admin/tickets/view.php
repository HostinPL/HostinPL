<?php
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
?>
<?php echo $admheader ?>
<div class="m-content">
	<div class="row">
	    <div class="col-xl-3 col-lg-4">
		    <div class="m-portlet m-portlet--full-height   m-portlet--unair">
			    <div class="m-portlet__body">
				    <div class="m-card-profile">
					    <div class="m-card-profile__title m--hide"></div>
					    <div class="m-card-profile__pic">
						    <div class="m-card-profile__pic-wrapper">
						        <img src="/application/public/img/tex.png" alt="">
						    </div>
					    </div>
					    <div class="m-card-profile__details">
						    <span class="m-card-profile__name">Запрос №<?php echo $ticket['ticket_id'] ?></span>
						    <?php if($ticket['ticket_status'] == 0): ?> 
						    <a href="#" class="m-card-profile__email m-link">Закрыт</a>
						    <?php elseif($ticket['ticket_status'] == 1): ?> 
						    <a href="#" class="m-card-profile__email m-link">Ожидает ответа</a>
						    <?php elseif($ticket['ticket_status'] == 2): ?> 
						    <a href="#" class="m-card-profile__email m-link">Ответ отправлен</a>
						    <?php endif; ?>
					    </div>
				    </div>	
				    <ul class="m-nav m-nav--hover-bg m-portlet-fit--sides">
					    <li class="m-nav__separator m-nav__separator--fit"></li>
					    <li class="m-nav__section m--hide">
						    <span class="m-nav__section-text"></span>
					    </li>
					    <?php if($ticket['ticket_status'] != 0): ?>
					    <li class="m-nav__item">
						    <a href="#javascript" onClick="sendAction(<?php echo $ticket['ticket_id'] ?>,'closed')" class="m-nav__link">
						        <i class="m-nav__link-icon fa flaticon-circle"></i>
							    <span class="m-nav__link-text">Закрыть запрос</span>
						    </a>
					    </li>
					    <?endif;?>
					    <li class="m-nav__item">
						    <a href="/admin/tickets/index?userid=<?php echo $ticket['user_id'] ?>" class="m-nav__link">
						        <i class="m-nav__link-icon fa flaticon-computer"></i>
							    <span class="m-nav__link-text">Все запросы клиента</span>
						    </a>
					    </li>
				    </ul>
			    </div>			
		    </div>	
	    </div>
	    <div class="col-xl-9 col-lg-8">
		    <div class="m-portlet m-portlet--full-height m-portlet--tabs   m-portlet--unair">
			    <div class="m-widget1">
				    <div class="m-quick-sidebar__content">
					    <form id="sendForm" action="" method="POST">
						<div class="m-messenger m-messenger--message-arrow m-messenger--skin-light">
							<div class="m-messenger__messages m-scrollable m-scroller" style="height: 486px; overflow: auto;">
								<?php foreach($messages as $item): ?> 
								<div class="m-messenger__wrapper"></div>
								<div class="m-messenger__datetime"><?php echo date("d.m.Y в H:i", strtotime($item['ticket_message_date_add'])) ?></div>
								<div class="m-messenger__wrapper">
									<div class="m-messenger__message m-messenger__message--in">
										<div class="m-messenger__message-pic">
											<img src="<?php echo $url ?><?if($item['user_img']) {echo $item['user_img'];}else{ echo '/application/public/img/user.png';}?>" alt="">
										</div>
										<div class="m-messenger__message-body">
											<div class="m-messenger__message-arrow"></div>
											<div class="m-messenger__message-content">
												<div class="m-messenger__message-username">
													<?php echo $item['user_firstname'] ?> <?php echo $item['user_lastname'] ?>
												</div>
												<div class="m-messenger__message-text">
													<?php echo nl2br($item['ticket_message']) ?>
												</div>
											</div>
										</div>
									</div>
								</div>
								<?php endforeach; ?>
							</div>
							<div class="m-messenger__seperator"></div>
							<div class="m-messenger__form">
								<div class="m-messenger__form-controls">
									<input type="text" id="text" name="text" placeholder="Введите текст" class="m-messenger__form-input">
								</div>
								<div class="m-messenger__form-tools">
									<button type="submit" class="m-messenger__form-attachment">
										<i class="la la-arrow-circle-o-right"></i>
									</button>
								</div>
							</div>
				        </div>
				        </form>
			        </div>
			    </div>
		    </div>
	    </div>
    </div>        
</div>
				<script>
					$('#sendForm').ajaxForm({ 
						url: '/admin/tickets/view/ajax/<?php echo $ticket['ticket_id'] ?>',
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
									$('#text').val('');
									setTimeout("reload()", 1500);
									break;
							}
						},
						beforeSubmit: function(arr, $form, options) {
							$('button[type=submit]').prop('disabled', true);
						}
					});
					function sendAction(ticketid, action) {
						switch(action) {
							case "closed":
							{
								if(!confirm("Вы уверенны в том, что хотите закрыть тикет?")) return;
								break;
							}
						}
						$.ajax({ 
							url: '/admin/tickets/view/action/'+ticketid+'/'+action,
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
							},
							beforeSend: function(arr, options) {
								if(action == "closed") toastr.warning("Закрываем тикет...");
								$('#controlBtns button').prop('disabled', true);
							}
						});
					}
					function toggleText() {
						var status = $('#closeticket').is(':checked');
						if(status) {
							$('#text').prop('disabled', true);
						} else {
							$('#text').prop('disabled', false);
						}
					}
				</script>
				</div>
<?php echo $footer ?>
