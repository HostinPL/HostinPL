<?php
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS)
Developed by Samir Shelenko (https://vk.com/id00v)
*/
?>
<?echo $header?>
<div class="col-12">
<div class="m-content">
<div class="row">
<?if($unitpay == 1):?>
<div class="col-lg-4">
    <div class="m-portlet m-portlet--full-height">
        <div class="m-portlet__body">
            <div class="m-card-profile">
                <center><img src="/application/public/img/pay/unitpay.png" style="max-width:100%;height:auto;" alt=""></center>
            </div>
            <div class="m-portlet__body-separator"></div>
            <button data-toggle="modal" data-target="#unitpayhostin" class="btn btn-accent m-btn m-btn--air btn-outline  btn-block sbold uppercase">Пополнить</button>
        </div>
    </div>
</div>
<?endif;?>
<?if($robokassa == 1):?>
<div class="col-lg-4">
    <div class="m-portlet m-portlet--full-height">
        <div class="m-portlet__body">
            <div class="m-card-profile">
                <center><img src="/application/public/img/pay/freekassa.png" style="max-width:100%;height:auto;" alt=""></center>
            </div>
            <div class="m-portlet__body-separator"></div>
            <button data-toggle="modal" data-target="#hostin" class="btn btn-accent m-btn m-btn--air btn-outline  btn-block sbold uppercase">Пополнить</button>
        </div>
    </div>
</div>
<?endif;?>
<?if($yandexkassa == 1):?>
<div class="col-lg-4">
    <div class="m-portlet m-portlet--full-height">
        <div class="m-portlet__body">
            <div class="m-card-profile">
                <center><img src="/application/public/img/pay/yandex.png" style="max-width:100%;height:auto;" alt=""></center>
            </div>
            <div class="m-portlet__body-separator"></div>
            <button data-toggle="modal" data-target="#yandexkassabox" class="btn btn-accent m-btn m-btn--air btn-outline  btn-block sbold uppercase">Пополнить</button>
        </div>
    </div>
</div>
<?endif;?>
<?if($interkassa == 1):?>
<div class="col-lg-4">
    <div class="m-portlet m-portlet--full-height">
        <div class="m-portlet__body">
            <div class="m-card-profile">
                <center><img src="/application/public/img/pay/interkassa.png" style="max-width:100%;height:auto;" alt=""></center>
            </div>
            <div class="m-portlet__body-separator"></div>
            <button data-toggle="modal" data-target="#interpayhostin" class="btn btn-accent m-btn m-btn--air btn-outline  btn-block sbold uppercase">Пополнить</button>
        </div>
    </div>
</div>
<?endif;?>
</div>
</div>
</div>
<!-- ================================================ /unitpay ================================================ -->
<div class="modal fade" id="unitpayhostin" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Пополнение баланса</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form id="unitpay" method="POST" class="form_1" style="padding:0px; margin:0px;">
                <div class="form-group m-form__group">
                    <label>Введите сумму</label>
                    <input class="form-control m-input m-input--air" id="ammount" name="ammount" placeholder="100">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                <input class="btn m-btn--square  btn-info" type="submit" value="Пополнить">
            </div>
            </form>
        </div>
    </div>
</div>
<!-- ================================================ /unitpay ================================================ -->
<!-- ================================================ /interpay ================================================ -->
<div class="modal fade" id="interpayhostin" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Пополнение баланса</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form id="interpay" method="POST" class="form_2" style="padding:0px; margin:0px;">
                <div class="form-group m-form__group">
                    <label>Введите сумму</label>
                    <input class="form-control m-input m-input--air" id="ammount" name="ammount" placeholder="100">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                <input class="btn m-btn--square  btn-info" type="submit" value="Пополнить">
            </div>
            </form>
        </div>
    </div>
</div>
<!-- ================================================ /interpay ================================================ -->
<div class="modal fade" id="yandexkassabox" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Пополнение баланса</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form id="yandexkassa" method="POST" class="form_2" style="padding:0px; margin:0px;">
                <div class="form-group m-form__group">
                    <label>Введите сумму</label>
                    <input class="form-control m-input m-input--air" id="ammount" name="ammount" placeholder="100">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                <input class="btn m-btn--square  btn-info" type="submit" value="Пополнить">
            </div>
            </form>
        </div>
    </div>
</div>
<script>
                    $('#yandexkassa').ajaxForm({ 
                        url: '/account/yandexkassa/ajax',
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
                                    redirect(data.url);
                                    break;
                            }
                        },
                        beforeSubmit: function(arr, $form, options) {
                            $('button[type=submit]').prop('disabled', true);
                        }
                    });
</script>
<script>
                    $('#unitpayhostin').ajaxForm({ 
                        url: '/account/unitpay/ajax',
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
                                    redirect(data.url);
                                    break;
                            }
                        },
                        beforeSubmit: function(arr, $form, options) {
                            $('button[type=submit]').prop('disabled', true);
                        }
                    });
</script>
<script>
                    $('#interpayhostin').ajaxForm({ 
                        url: '/account/interpay/ajax',
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
                                    redirect(data.url);
                                    break;
                            }
                        },
                        beforeSubmit: function(arr, $form, options) {
                            $('button[type=submit]').prop('disabled', true);
                        }
                    });
</script>
<?echo $footer?>