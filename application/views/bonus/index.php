<?php
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
?>
<?php echo $header ?>
<div class="col-12">
    <div class="m-content">
        <div class="m-portlet">
            <div class="m-portlet__body m-portlet__body--no-padding">
                <div class="m-pricing-table-2">
                    <div class="m-pricing-table-2__head">
                        <div class="m-pricing-table-2__title m--font-light">
                            <h1>Обменик бонусов <br>У вас <?php echo $users['rmoney'] ?> бонусов</h1>
                        </div>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane active show" id="m-pricing-table_content1" aria-expanded="true">
                            <div class="m-pricing-table-2__content">
                                <div class="m-pricing-table-2__container">
                                    <div class="m-pricing-table-2__items row">
                                        <div class="m-pricing-table-2__item col-lg-3">
                                            <div class="m-pricing-table-2__visual">
                                                <div class="m-pricing-table-2__hexagon"></div>
                                                <span class="m-pricing-table-2__icon m--font-info">
                                                    <i class="fa fa-grin"></i>
                                                </span>
                                            </div>
                                            <h2 class="m-pricing-table-2__subtitle">100 COINS</h2>
                                            <span class="m-pricing-table-2__price">50</span>
                                            <span class="m-pricing-table-2__label">₽</span>
                                            <div class="m-pricing-table-2__btn">
                                                <button type="button" onClick="sendAction_exchange('100DEB')" class="btn m-btn--pill  btn-info m-btn--wide m-btn--uppercase m-btn--bolder m-btn--lg">Обменять</button>
                                            </div>
                                        </div>
                                        <div class="m-pricing-table-2__item col-lg-3">
                                            <div class="m-pricing-table-2__visual">
                                                <div class="m-pricing-table-2__hexagon"></div>
                                                <span class="m-pricing-table-2__icon m--font-info">
                                                    <i class="fa fa-grin-tongue"></i>
                                                </span>
                                            </div>
                                            <h2 class="m-pricing-table-2__subtitle">300 COINS</h2>
                                            <span class="m-pricing-table-2__price">150</span>
                                            <span class="m-pricing-table-2__label">₽</span>
                                            <div class="m-pricing-table-2__btn">
                                                <button type="button" onClick="sendAction_exchange('300DEB')" class="btn m-btn--pill  btn-info m-btn--wide m-btn--uppercase m-btn--bolder m-btn--lg">Обменять</button>
                                            </div>
                                        </div>
                                        <div class="m-pricing-table-2__item col-lg-3">
                                            <div class="m-pricing-table-2__visual">
                                                <div class="m-pricing-table-2__hexagon"></div>
                                                <span class="m-pricing-table-2__icon m--font-info">
                                                    <i class="fa fa-grin-hearts"></i>
                                                </span>
                                            </div>
                                            <h2 class="m-pricing-table-2__subtitle">600 COINS</h2>
                                            <span class="m-pricing-table-2__price">300</span>
                                            <span class="m-pricing-table-2__label">₽</span>
                                            <div class="m-pricing-table-2__btn">
                                                <button type="button" onClick="sendAction_exchange('600DEB')" class="btn m-btn--pill  btn-info m-btn--wide m-btn--uppercase m-btn--bolder m-btn--lg">Обменять</button>
                                            </div>
                                        </div>
                                        <div class="m-pricing-table-2__item col-lg-3">
                                            <div class="m-pricing-table-2__visual">
                                                <div class="m-pricing-table-2__hexagon"></div>
                                                <span class="m-pricing-table-2__icon m--font-info">
                                                    <i class="fa fa-grin-stars"></i>
                                                </span>
                                            </div>
                                            <h2 class="m-pricing-table-2__subtitle">1000 COINS</h2>
                                            <span class="m-pricing-table-2__price">507</span>
                                            <span class="m-pricing-table-2__label">₽</span>
                                            <div class="m-pricing-table-2__btn">
                                                <button type="button" onClick="sendAction_exchange('1000DEB')" class="btn m-btn--pill  btn-info m-btn--wide m-btn--uppercase m-btn--bolder m-btn--lg">Обменять</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
function sendAction_exchange(action) {
$.ajax({ 
		url: '/bonus/index/ajax_action_exchange/'+action,
		dataType: 'text',
		success: function(data) {
			data = $.parseJSON(data);
			switch(data.status) {
				case 'error':
					toastr.error(data.error);
					break;
				case 'success':
					toastr.success(data.success);
					break;
			}
		}
	});
}
</script>
<?php echo $footer ?>