<?php
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
?>
<?php echo $admheader ?>
<div class="col-12">
    <div class="">
        <div class="m-portlet ">
            <div class="m-portlet__body  m-portlet__body--no-padding">
                <div class="row m-row--no-padding m-row--col-separator-xl">
                    <div class="col-md-12 col-lg-6 col-xl-3">
                        <div class="m-widget24">
                            <div class="m-widget24__item">
                                <h4 class="m-widget24__title">
                                    Клиентов
                                </h4>
                                <br>
                                <a href="/admin/users">
                                <span class="m-widget24__desc">
                                    Перейти к списку
                                </span>
                                </a>
                                <span class="m-widget24__stats m--font-brand">
                                    <?$userov = 0;
                                    foreach($users as $itemr): ?>
                                    <? $userov++; ?>
                                    <?endforeach;echo $userov; ?>
                                </span>
                                <div class="m--space-10"></div>
                                <div class="progress m-progress--sm">
                                    <div class="progress-bar m--bg-brand" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
                                    </div>
                                </div>
                                <span class="m-widget24__change">
                                    Неактивных
                                </span>
                                <span class="m-widget24__number">
                                    <?$userov2 = 0;
                                    foreach($users as $itemr): ?>
                                    <? if (!($itemr['user_status'] == 0)) { // пропуск нечетных чисел
                                    continue;
                                    }?>
                                    <? $userov2++; ?>
                                    <?endforeach;echo $userov2; ?>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6 col-xl-3">
                        <div class="m-widget24">
                            <div class="m-widget24__item">
                                <h4 class="m-widget24__title">
                                    Тикеты
                                </h4>
                                <br>
                                <a href="/admin/tickets/index?status=1">
                                <span class="m-widget24__desc">
                                    Новые запросы ( <?$ticketov2 = 0;
                                    foreach($tickets as $item): ?>
                                    <? if (!($item['ticket_status'] == 1)) { // пропуск нечетных чисел
                                    continue;
                                    }?>
                                    <? $ticketov2++; ?> <?endforeach;echo $ticketov2; ?> )
                                </span>
                                </a>
                                <span class="m-widget24__stats m--font-info">
                                    <?$ticketov = 0;
                                    foreach($tickets as $item): ?>
                                    <? $ticketov++; ?>
                                    <?endforeach;echo $ticketov; ?>
                                </span>
                                <div class="m--space-10"></div>
                                <div class="progress m-progress--sm">
                                    <div class="progress-bar m--bg-info" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
                                    </div>
                                </div>
                                <span class="m-widget24__change">
                                    Закрытые
                                </span>
                                <span class="m-widget24__number">
                                    <?$ticketov1 = 0;
                                    foreach($tickets as $item): ?>
                                    <? if (!($item['ticket_status'] == 0)) { // пропуск нечетных чисел
                                    continue;
                                    }?>
                                    <? $ticketov1++; ?> <?endforeach;echo $ticketov1; ?>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6 col-xl-3">
                        <div class="m-widget24">
                            <div class="m-widget24__item">
                                <h4 class="m-widget24__title">
                                    Серверов
                                </h4>
                                <br>
                                <a href="/admin/servers">
                                <span class="m-widget24__desc">
                                    Перейти к списку
                                </span>
                                </a>
                                <span class="m-widget24__stats m--font-danger">
                                    <?$tserverov1 = 0;
                                    foreach($tservers as $item): ?>
                                    <? $tserverov1++; ?>
                                    <?endforeach;echo $tserverov1; ?>
                                </span>
                                <div class="m--space-10"></div>
                                <div class="progress m-progress--sm">
                                    <div class="progress-bar m--bg-danger" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
                                    </div>
                                </div>
                                <span class="m-widget24__change">
                                    Онлайн
                                </span>
                                <span class="m-widget24__number">
                                    <?$tserverov = 0;
                                    foreach($tservers as $item): ?>
                                    <? if (!($item['server_status'] == 2)) { // пропуск нечетных чисел
                                    continue;
                                    }?>
                                    <? $tserverov++; ?>
                                    <?endforeach;echo $tserverov; ?>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6 col-xl-3">
                        <div class="m-widget24">
                            <div class="m-widget24__item">
                                <h4 class="m-widget24__title">
                                    Заработано
                                </h4>
                                <br>
                                <a href="/admin/invoices">
                                <span class="m-widget24__desc">
                                    Перейти к списку
                                </span>
                                </a>
                                <span class="m-widget24__stats m--font-success">
                                    <?$invo = 0;
                                    foreach($invoices as $item): ?>
                                    <? if (!($item['invoice_status'] == 1)) { // пропуск нечетных чисел
                                    continue;
                                    }?>
                                    <? $invo=$invo+$item['invoice_ammount']; ?>
                                    <?endforeach; echo $invo; ?>
                                </span>
                                <div class="m--space-10"></div>
                                <div class="progress m-progress--sm">
                                    <div class="progress-bar m--bg-success" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
                                    </div>
                                </div>
                                <span class="m-widget24__change">
                                    Последний счет
                                </span>
                                <span class="m-widget24__number">
                                    <?echo $item['invoice_ammount'];?> руб.
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-6">
                <div class="m-portlet m-portlet--mobile m-portlet--body-progress-">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <span class="m-portlet__head-icon">
                                    <i class="flaticon-profile-1"></i>
                                </span>
                                <h3 class="m-portlet__head-text">
                                    Администрация
                                    <small>Хостинга</small>
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="m-widget1">
                        <?php foreach($users as $item): ?>
                        <?if($item['user_access_level'] == 1)
                        continue;?>
                        <div class="m-widget1__item">
                            <div class="row m-row--no-padding align-items-center">
                                <div class="col">
                                    <h3 class="m-widget1__title"><?php echo $item['user_firstname'] ?> <?php echo $item['user_lastname'] ?></h3>
                                    <span class="m-widget1__desc">ID <?php echo $item['user_id'] ?></span>
                                </div>
                                <div class="col m--align-right">
                                    <?php if($item['user_access_level'] == 2): ?>
                                    <span class="m-widget2__number m--font-info">Тех. поддержка</span>
                                    <?php elseif($item['user_access_level'] == 3): ?>
                                    <span class="m-widget2__number m--font-brand">Администратор</span>
                                    <?php endif; ?> 
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="m-portlet m-portlet--mobile m-portlet--body-progress-">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <span class="m-portlet__head-icon">
                                    <i class="flaticon-folder-2"></i>
                                </span>
                                <h3 class="m-portlet__head-text">
                                    10 Последних операций
                                    <small>Пользователей</small>
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="m-widget1">
                        <?php foreach($waste as $item): ?>
                        <div class="m-widget1__item">
                            <div class="row m-row--no-padding align-items-center">
                                <div class="col">
                                    <h3 class="m-widget1__title"><?php echo $item['user_firstname'] ?> <?php echo $item['user_lastname'] ?></h3>
                                    <span class="m-widget1__desc"><?php echo $item['waste_usluga'] ?></span>
                                </div>
                                <div class="col m--align-right">
                                    <?php if($item['waste_status'] == 1): ?>
                                    <span class="m-widget1__number m--font-danger">- <?php echo $item['waste_ammount'] ?> руб</span>
                                    <?php elseif($item['waste_status'] == 0): ?>
                                    <span class="m-widget1__number m--font-success">+ <?php echo $item['waste_ammount'] ?> руб</span>
                                    <?php endif; ?> 
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $footer ?>