<?php
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
?>
<?php echo $admheader ?>
<div class="col-12">
    <div class="m-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="m-portlet m-portlet--brand m-portlet--head-solid-bg">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <span class="m-portlet__head-icon">
                                    <i class="flaticon-gift"></i>
                                </span>
                                <h3 class="m-portlet__head-text">
                                    Создание промо-кода
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        <form class="form-group form-md-line-input" action="#" id="createForm" method="POST">
                        <div class="form-group form-md-line-input">
                            <input type="text" class="form-control" id="cod" name="cod" placeholder="Введите промо-код">
                        </div>
                        <div class="form-group form-md-line-input">
                            <select class="form-control" id="skidka" name="skidka" aria-required="true" aria-invalid="false" aria-describedby="delivery-error">
                                <option value="5">5%</option>
                                <option value="10">10%</option>
                                <option value="15">15%</option>
                                <option value="20">20%</option>
                                <option value="25">25%</option>
                                <option value="30">30%</option>
                                <option value="35">35%</option>
                                <option value="40">40%</option>
                                <option value="45">45%</option>
                                <option value="50">50%</option>
                                <option value="55">55%</option>
                                <option value="60">60%</option>
                                <option value="65">65%</option>
                                <option value="70">70%</option>
                                <option value="75">75%</option>
                                <option value="80">80%</option>
                                <option value="85">85%</option>
                                <option value="90">90%</option>
                                <option value="95">95%</option>
                                <option value="100">100%</option>
                            </select>
                        </div>
                        <div class="form-group form-md-line-input">
                            <input type="text" class="form-control" id="uses" name="uses" placeholder="Введите количество использований">
                        </div>
                        <div class="m-portlet__foot">
                            <div class="m--align-center">
                                <a href="/admin/promo" class="btn btn-secondary m-btn m-btn--icon m-btn--wide m-btn--md m--margin-right-10 m-btn--air">
                                    <span>
                                        <i class="la la-arrow-left"></i>
                                        <span>Отмена</span>
                                    </span>
                                </a>
                                <button type="submit" class="btn btn-brand  m-btn m-btn--icon m-btn--wide m-btn--md m-btn--air">
                                    <span>
                                        <i class="la la-check"></i>
                                        <span>Создать</span>
                                    </span>
                                </button>
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
					$('#createForm').ajaxForm({ 
						url: '/admin/promo/create/ajax',
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
									setTimeout("redirect('/admin/promo')", 1500);
									break;
							}
						},
						beforeSubmit: function(arr, $form, options) {
							$('button[type=submit]').prop('disabled', true);
						}
					});
</script>
<?php echo $footer ?>
