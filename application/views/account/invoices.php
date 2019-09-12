<?php
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
?>
<?php echo $header ?>
<div class="m-content">
    <div class="m-portlet">
        <div class="m-portlet__body m-portlet__body--no-padding">
            <div class="m-invoice-1">
                <div class="m-invoice__wrapper">
                    <div class="m-invoice__head" style="background-image: url(/assets/app/media/img//bg/bg-6.jpg);">
                        <div class="m-invoice__container m-invoice__container--centered">
                            <div class="m-invoice__logo">
                                <a href="#">
                                    <h1>Счета</h1>
                                </a>
                                <a href="#">
                                    <img src="<?php echo $logo ?>">
                                </a>
                            </div>
                            <span class="m-invoice__desc">
                                <span>Тел. <?php echo $phone ?></span>
                                <span>Email: <?php echo $mail_from ?></span>
                            </span>
                            <div class="m-invoice__items">
                                <div class="m-invoice__item">
                                    <span class="m-invoice__subtitle">Клиент</span>
                                    <span class="m-invoice__text"><?php echo $user_firstname ?> <?php echo $user_lastname ?></span>
                                </div>
                                <div class="m-invoice__item">
                                    <span class="m-invoice__subtitle">Баланс</span>
                                    <span class="m-invoice__text"><? echo $user_balance?> рублей.</span>
                                </div>
                                <div class="m-invoice__item">
                                    <span class="m-invoice__subtitle">Общая сумма пополнений</span>
                                    <span class="m-invoice__text"><?$invo = 0;
foreach($invoices as $item): ?>
<? if (!($item['invoice_status'] == 1)) { // пропуск нечетных чисел
continue;
}?>
<? $invo=$invo+$item['invoice_ammount']; ?>
<?endforeach; echo $invo; ?> рублей.</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="m-invoice__body m-invoice__body--centered">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Ид платежа</th>
                                        <th>Статус</th>
                                        <th>Дата</th>
                                        <th>Сумма</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($invoices as $item): ?>
                                    <tr>
                                        <td><?php echo $item['invoice_id'] ?></td>
                                        <td><?php if($item['invoice_status'] == 0): ?> 
                                Не оплачен
                                <?php elseif($item['invoice_status'] == 1): ?> 
                                Оплачен
                                <?php endif; ?>
                                        </td>
                                        <td><?php echo date("d.m.Y в H:i", strtotime($item['invoice_date_add'])) ?></td>
                                        <td><?php echo $item['invoice_ammount'] ?> руб.</td>
                                    </tr>
                                    <?php endforeach; ?>
                                    <?php if(empty($invoices)): ?>
                                        <tr>
                                            <td colspan="8" style="text-align: center;">На данный момент у вас нет счетов.</td>
                                        <tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="m-invoice__footer">
                        <div class="m-invoice__container m-invoice__container--centered">
                            <div class="m-invoice__content">
                                <span><?php echo $title ?></span>
                                <span>
                                    <span>Адрес:</span>
                                    <span><?php echo $city_country ?> <?php echo $homed ?></span>
                                </span>
                                <span>
                                    <span>Номер счета:</span>
                                    <span><?php echo $user_id ?></span>
                                </span>
                            </div>                                                
                            <div class="m-invoice__content">
                                <a href="/account/pay" class="btn btn-accent m-btn m-btn--air m-btn--custom">Пополнить баланс</a>&nbsp;&nbsp;
                                <button type="reset" onclick="javascript:window.print();" class="btn btn-secondary m-btn m-btn--air m-btn--custom">Распечатать</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $footer ?>
