<?php
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
?>
<?php echo $header ?>
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
                        <span class="m-card-profile__name">Новый запрос</span>
                    </div>
                </div>  
                <ul class="m-nav m-nav--hover-bg m-portlet-fit--sides">
                    <li class="m-nav__separator m-nav__separator--fit"></li>
                    <li class="m-nav__section m--hide">
                        <span class="m-nav__section-text"></span>
                    </li>
                    <li class="m-nav__item">
                        <a href="/tickets" class="m-nav__link">
                            <i class="m-nav__link-icon fa flaticon-speech-bubble"></i>
                            <span class="m-nav__link-text">Мои запросы</span>
                        </a>
                    </li>
                    <li class="m-nav__item">
                        <a href="/faq" class="m-nav__link">
                            <i class="m-nav__link-icon fa flaticon-folder-2"></i>
                            <span class="m-nav__link-text">База знаний</span>
                        </a>
                    </li>
                </ul>
            </div>          
        </div>  
    </div>
    <div class="col-xl-9 col-lg-8">
        <div class="m-portlet m-portlet--full-height m-portlet--tabs   m-portlet--unair">
            <div class="m-portlet__body">
                <form action="#" method="POST" id="createForm" class="form-group form-md-line-input">
                    <div class="form-group form-md-line-input">
                        <input type="text" class="form-control" id="name" name="name" placeholder="Введите тему">
                    </div>
                    <div class="form-group form-md-line-input">
                        <select class="form-control" id="category" name="category" aria-required="true" aria-invalid="false" aria-describedby="delivery-error">
                            <?php foreach($category as $item): ?> 
                            <option value="<?php echo $item['category_id'] ?>"><?php echo $item['category_name'] ?></option>
                            <?php endforeach; ?> 
                            <?php foreach($servers as $item2): ?> 
                            <option value="NULL">Сервер (<?php echo $item2['location_ip'] ?>:<?php echo $item2['server_port'] ?>)</option>
                            <?php endforeach; ?> 
                        </select>
                    </div>
                    <div class="form-group form-md-line-input">
                        <textarea class="form-control" id="text" name="text" rows="3" placeholder="Сообщение..."></textarea>
                    </div>
                    <div class="recaptcha">
                        <center><div class="g-recaptcha" data-sitekey="<?php echo $recaptcha ?>"></div></center>
                    </div>
                    <hr>
                    <input type="submit" class="btn btn-accent m-btn m-btn--air btn-outline  btn-block sbold uppercase" value="Отправить">
                </form>
            </div>
        </div>
    </div>        
</div>
<script>
					$('#createForm').ajaxForm({ 
						url: '/tickets/create/ajax',
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
									setTimeout("redirect('/tickets/view/index/" + data.id + "')", 1500);
									break;
							}
						},
						beforeSubmit: function(arr, $form, options) {
							$('button[type=submit]').prop('disabled', true);
						}
					});
				</script>
				
<?php echo $footer ?>