<?php
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
?>
<?php echo $admheader ?>
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
                                <img src="/application/public/img/tex.png" alt="">
                            </div>
                        </div>
                        <div class="m-card-profile__details">
                            <span class="m-card-profile__name">Запросы пользователей</span>
                        </div>
                    </div>  
                    <ul class="m-nav m-nav--hover-bg m-portlet-fit--sides">
                        <li class="m-nav__separator m-nav__separator--fit"></li>
                        <li class="m-nav__section m--hide">
                            <span class="m-nav__section-text"></span>
                        </li>
                        <li class="m-nav__item">
                            <a href="/admin/tickets/index?status=1" class="m-nav__link">
                                <i class="m-nav__link-icon fa flaticon-security"></i>
                                <span class="m-nav__link-text">Новые запросы</span>
                            </a>
                        </li>
                        <li class="m-nav__item">
                            <a href="/admin/tickets/" class="m-nav__link">
                                <i class="m-nav__link-icon fa flaticon-list-3"></i>
                                <span class="m-nav__link-text">Все запросы</span>
                            </a>
                        </li>
                        <li class="m-nav__item">
                            <a href="/admin/tickets/index?status=0" class="m-nav__link">
                                <i class="m-nav__link-icon fa flaticon-list-2"></i>
                                <span class="m-nav__link-text">Закрытые запросы</span>
                            </a>
                        </li>
                        <li class="m-nav__item">
                            <a href="/admin/tickets/create" class="m-nav__link">
                                <i class="m-nav__link-icon fa flaticon-paper-plane"></i>
                                <span class="m-nav__link-text">Написать клиенту</span>
                            </a>
                        </li>
                        <li class="m-nav__item">
                            <a href="/admin/ticketcategory" class="m-nav__link">
                                <i class="m-nav__link-icon fa flaticon-folder-2"></i>
                                <span class="m-nav__link-text">Все категории</span>
                            </a>
                        </li>
                        <li class="m-nav__item">
                            <a href="/admin/ticketcategory/create" class="m-nav__link">
                                <i class="m-nav__link-icon fa flaticon-add"></i>
                                <span class="m-nav__link-text">Создать категорию</span>
                            </a>
                        </li>
                    </ul>
                </div>          
            </div>  
        </div>
        <div class="col-xl-9 col-lg-8">
            <div class="m-portlet m-portlet--full-height m-portlet--tabs   m-portlet--unair">
                <div class="m-portlet__body">
                    <div class="m-section__content">
                        <table class="table table-striped m-table"">
                            <thead>
                                <tr>
                                    <th>
                                        <i class="flaticon-list"></i>
                                    </th>
                                    <th>
                                        <i class="flaticon-interface-7"></i> Статус
                                    </th>
                                    <th>
                                        <i class="flaticon-book"></i> Тема
                                    </th>
                                    <th>
                                        <i class="flaticon-tool-1"></i> Категория
                                    </th>
                                    <th>
                                        <i class="flaticon-calendar-2"></i> Дата создания
                                    </th>
                                    <th>
                                        <i class="flaticon-multimedia"></i> Действие
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($tickets as $item): ?> 
                                <tr> 
                                    <td><?php echo $item['ticket_id'] ?></td>
                                    <td>
                                        <?php if($item['ticket_status'] == 0): ?> 
                                        Вопрос закрыт.
                                        <?php elseif($item['ticket_status'] == 1): ?> 
                                        Ожидает ответа.
                                        <?php elseif($item['ticket_status'] == 2): ?> 
                                        Ответ от администрации.
                                        <?php endif; ?> 
                                    </td>
                                    <td><?php echo $item['ticket_name'] ?></td>
                                    <td><?php if($item['category_id'] == NULL){echo 'Сервер';} else {echo $item['category_name'];}?></td>
                                    <td><?php echo date("d.m.Y в H:i", strtotime($item['ticket_date_add'])) ?></td>
                                    <td><a href="/admin/tickets/view/index/<?php echo $item['ticket_id'] ?>" data-container="body" data-toggle="m-popover" data-placement="top" data-content="Управление запросом" data-original-title="" title="" class="btn btn-outline-brand m-btn m-btn--icon m-btn--icon-only"><i class="fa fa-share"></i></a>
                                    </td>
                                </tr>
                                <?php endforeach; ?> 
                                <?php if(empty($tickets)): ?> 
                                <tr>
                                    <td colspan="8" style="text-align: center;">На данный момент в тех.поддержку нет запросов.</td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>  
    </div>
    <?php echo $pagination ?>      
</div>
<?php echo $footer ?>
