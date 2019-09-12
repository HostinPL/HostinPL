<?php
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
?>
<!DOCTYPE html>
<html lang="en">

    <!-- begin::Head -->
    <head>
        <meta charset="utf-8" />
        <title><?php echo $title ?> | <?php echo $description ?></title>
<?php
date_default_timezone_set('UTC');
$script_tz = date_default_timezone_get();
?>
        <meta name="description" content="<?php echo $description ?>">
        <meta name="keywords" content="<?php echo $keywords ?>">
        <meta name="generator" content="HOSTINRUS">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">

        <!--begin::Web font -->
        <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
        <script>
            WebFont.load({
                google: {
                    "families": ["Poppins:300,400,500,600,700", "Roboto:300,400,500,600,700"]
                },
                active: function() {
                    sessionStorage.fonts = true;
                }
            });
        </script>

        <!--end::Web font -->

        <!--begin::Page Vendors Styles -->
        <link href="/assets/vendors/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="http://gsri1987.github.io/notific8-responsive/css/jquery.notific8.css" media="screen">

        <!--RTL version:<link href="assets/vendors/custom/fullcalendar/fullcalendar.bundle.rtl.css" rel="stylesheet" type="text/css" />-->

        <!--end::Page Vendors Styles -->

        <!--begin::Base Styles -->
        <link href="/assets/vendors/base/vendors.bundle.css" rel="stylesheet" type="text/css" />

        <!--RTL version:<link href="assets/vendors/base/vendors.bundle.rtl.css" rel="stylesheet" type="text/css" />-->
        <link href="/assets/demo/default/base/style.bundle.css" rel="stylesheet" type="text/css" />

        <!--RTL version:<link href="assets/demo/default/base/style.bundle.rtl.css" rel="stylesheet" type="text/css" />-->
        <!--end::Base Styles -->
        <link rel="shortcut icon" href="/favicon.ico" />
    </head>

    <!-- end::Head -->

    <!-- begin::Body -->
    <body class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">

        <!-- begin:: Page -->
        <div class="m-grid m-grid--hor m-grid--root m-page">

            <!-- BEGIN: Header -->
            <header id="m_header" class="m-grid__item    m-header " m-minimize-offset="200" m-minimize-mobile-offset="200">
                <div class="m-container m-container--fluid m-container--full-height">
                    <div class="m-stack m-stack--ver m-stack--desktop">

                        <!-- BEGIN: Brand -->
                        <div class="m-stack__item m-brand  m-brand--skin-dark ">
                            <div class="m-stack m-stack--ver m-stack--general">
                                <div class="m-stack__item m-stack__item--middle m-brand__logo">
                                    <a href="/main/index" class="m-brand__logo-wrapper">
                                        <img width = "112" height = "20" alt="" src="<?php echo $logo ?>" />
                                    </a>
                                </div>
                                <div class="m-stack__item m-stack__item--middle m-brand__tools">

                                    <!-- BEGIN: Left Aside Minimize Toggle -->
                                    <a href="javascript:;" id="m_aside_left_minimize_toggle" class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-desktop-inline-block  ">
                                        <span></span>
                                    </a>

                                    <!-- END -->

                                    <!-- BEGIN: Responsive Aside Left Menu Toggler -->
                                    <a href="javascript:;" id="m_aside_left_offcanvas_toggle" class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-tablet-and-mobile-inline-block">
                                        <span></span>
                                    </a>

                                    <!-- END -->

                                    <!-- BEGIN: Responsive Header Menu Toggler -->
                                    <a id="m_aside_header_menu_mobile_toggle" href="javascript:;" class="m-brand__icon m-brand__toggler m--visible-tablet-and-mobile-inline-block">
                                        <span></span>
                                    </a>

                                    <!-- END -->

                                    <!-- BEGIN: Topbar Toggler -->
                                    <a id="m_aside_header_topbar_mobile_toggle" href="javascript:;" class="m-brand__icon m--visible-tablet-and-mobile-inline-block">
                                        <i class="flaticon-more"></i>
                                    </a>

                                    <!-- BEGIN: Topbar Toggler -->
                                </div>
                            </div>
                        </div>

                        <!-- END: Brand -->
                        <div class="m-stack__item m-stack__item--fluid m-header-head" id="m_header_nav">

                            <!-- BEGIN: Horizontal Menu -->
                            <button class="m-aside-header-menu-mobile-close  m-aside-header-menu-mobile-close--skin-dark " id="m_aside_header_menu_mobile_close_btn">
                                <i class="la la-close"></i>
                            </button>
                            <div id="m_header_menu" class="m-header-menu m-aside-header-menu-mobile m-aside-header-menu-mobile--offcanvas  m-header-menu--skin-light m-header-menu--submenu-skin-light m-aside-header-menu-mobile--skin-dark m-aside-header-menu-mobile--submenu-skin-dark ">
                                <ul class="m-menu__nav  m-menu__nav--submenu-arrow ">
                                    <?if($user_access_level > 1):?>
                                    <li class="m-menu__item  m-menu__item--submenu m-menu__item--rel" m-menu-submenu-toggle="click" m-menu-link-redirect="1" aria-haspopup="true">
                                        <a href="javascript:;" class="m-menu__link m-menu__toggle">
                                            <i class="m-menu__link-icon flaticon-profile"></i>
                                            <span class="m-menu__link-title">
                                                <span class="m-menu__link-wrap">
                                                    <span class="m-menu__link-text">Панель</span>
                                                    <span class="m-menu__link-badge">
                                                        <span class="m-badge m-badge--brand m-badge--wide"><?if($user_access_level == 3):?> Администратора<?elseif($user_access_level == 2):?> Тех.поддержки<?endif;?></span>
                                                    </span>
                                                </span>
                                            </span>
                                            <i class="m-menu__hor-arrow la la-angle-down"></i>
                                            <i class="m-menu__ver-arrow la la-angle-right"></i>
                                        </a>
                                        <div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--left">
                                            <span class="m-menu__arrow m-menu__arrow--adjust"></span>
                                            <ul class="m-menu__subnav">
                                                <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true">
                                                    <a href="/admin/" class="m-menu__link ">
                                                        <i class="m-menu__link-icon flaticon-profile"></i>
                                                        <span class="m-menu__link-text"><?if($user_access_level == 3):?> Админ-Центр<?elseif($user_access_level == 2):?> Тех.поддержка<?endif;?></span>
                                                    </a>
                                                </li>
                                                <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true">
                                                    <a href="/admin/servers" class="m-menu__link ">
                                                        <i class="m-menu__link-icon flaticon-puzzle"></i>
                                                        <span class="m-menu__link-text">Сервера</span>
                                                    </a>
                                                </li>
                                                <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true">
                                                    <a href="/admin/tickets" class="m-menu__link ">
                                                        <i class="m-menu__link-icon flaticon-computer"></i>
                                                        <span class="m-menu__link-text">Тикеты</span>
                                                    </a>
                                                </li>
                                                <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true">
                                                    <a href="/admin/users" class="m-menu__link ">
                                                        <i class="m-menu__link-icon flaticon-users"></i>
                                                        <span class="m-menu__link-text">Пользователи</span>
                                                    </a>
                                                </li>
                                                <?if($user_access_level == 3):?>
                                                <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true">
                                                    <a href="/admin/games" class="m-menu__link ">
                                                        <i class="m-menu__link-icon flaticon-light"></i>
                                                        <span class="m-menu__link-text">Игры</span>
                                                    </a>
                                                </li>
                                                <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true">
                                                    <a href="/admin/locations" class="m-menu__link ">
                                                        <i class="m-menu__link-icon flaticon-map-location"></i>
                                                        <span class="m-menu__link-text">Локации</span>
                                                    </a>
                                                </li>
                                                <?endif;?>
                                            </ul>
                                        </div>
                                    </li>
                                    <?endif;?>
                                    <li class="m-menu__item" m-menu-submenu-toggle="click" m-menu-link-redirect="1" aria-haspopup="true">
                                        <a href="javascript:;" class="m-menu__link m-menu__toggle">
                                            <i class="m-menu__link-icon flaticon-users"></i>
                                            <span class="m-menu__link-title">
                                                <span class="m-menu__link-wrap">
                                                    <span class="m-menu__link-text">Пользователей онлайн</span>
                                                    <span class="m-menu__link-badge">
                                                        <span class="m-badge m-badge--brand m-badge--wide" id="online"></span>
                                                    </span>
                                                </span>
                                            </span>
                                        </a>
                                    </li>
                                    <li class="m-menu__item" m-menu-submenu-toggle="click" m-menu-link-redirect="1" aria-haspopup="true">
                                        <a data-toggle="modal" data-target="#hostin" class="m-menu__link m-menu__toggle">
                                            <i class="m-menu__link-icon flaticon-coins"></i>
                                            <span class="m-menu__link-title">
                                                <span class="m-menu__link-wrap">
                                                    <span class="m-menu__link-text">Ваш баланс</span>
                                                    <span class="m-menu__link-badge">
                                                        <span class="m-badge m-badge--brand m-badge--wide"><?php echo $user_balance ?> ₽</span>
                                                    </span>
                                                </span>
                                            </span>
                                        </a>
                                    </li>
                               </ul>
                            </div>
                            <!-- END: Horizontal Menu -->
                            <!-- BEGIN: Topbar -->
                            <div id="m_header_topbar" class="m-topbar  m-stack m-stack--ver m-stack--general m-stack--fluid">
                                <div class="m-stack__item m-topbar__nav-wrapper">
                                    <ul class="m-topbar__nav m-nav m-nav--inline">
                                        <li class="m-nav__item m-topbar__notifications m-topbar__notifications--img m-dropdown m-dropdown--large m-dropdown--header-bg-fill m-dropdown--arrow m-dropdown--align-right m-dropdown--mobile-full-width" m-dropdown-toggle="click" m-dropdown-persistent="1">
                                            <a href="#" class="m-nav__link m-dropdown__toggle" id="m_topbar_notification_icon">
                                                <span class="m-nav__link-icon">
                                                    <i class="flaticon-placeholder"></i>
                                                </span>
                                            </a>
                                            <div class="m-dropdown__wrapper">
                                                <span class="m-dropdown__arrow m-dropdown__arrow--right"></span>
                                                <div class="m-dropdown__inner">
                                                    <div class="m-dropdown__header m--align-center" style="background: url(/assets/app/media/img/misc/notification_bg.jpg); background-size: cover;">
                                                        <span class="m-dropdown__header-title">Последние 20 действий</span>
                                                    </div>
                                                    <div class="m-dropdown__body">
                                                        <div class="m-dropdown__content">
                                                            <div class="m-scrollable" data-scrollable="true" data-height="250" data-mobile-height="200">
                                                                <div class="m-list-timeline m-list-timeline--skin-light">
                                                                    <div class="m-list-timeline__items">
                                                                        <?php foreach($visitors as $item):?>
                                                                        <div class="m-list-timeline__item">
                                                                            <span class="m-list-timeline__badge"></span>
                                                                            <span class="m-list-timeline__text">IP: <?php echo $item['ip'] ?>
                                                                            <?php if($item['status'] == 0): ?>
                                                                            <span class="m-badge m-badge--danger m-badge--wide">Ошибка входа</span>
                                                                            <?php elseif($item['status'] == 1): ?>
                                                                            <span class="m-badge m-badge--success m-badge--wide">Вход в систему</span>
                                                                            <?php elseif($item['status'] == 2): ?>
                                                                            <span class="m-badge m-badge--info m-badge--wide">Выход из системы</span>
                                                                            <?php endif; ?>
                                                                            </span>
                                                                            <span class="m-list-timeline__time"><?php echo date("d.m.Y в H:i", strtotime($item['datetime'])) ?></span>
                                                                        </div>
                                                                        <?php endforeach; ?>
                                                                        <?php if(empty($visitors)): ?>
                                                                        <span class="m-widget14__desc">
                                                                        <center>У вас нет активов.</center>
                                                                        </span>
                                                                        <?php endif; ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="m-nav__item m-topbar__quick-actions m-topbar__quick-actions--img m-dropdown m-dropdown--large m-dropdown--header-bg-fill m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push m-dropdown--mobile-full-width m-dropdown--skin-light"
                                         m-dropdown-toggle="click">
                                            <a href="#" class="m-nav__link m-dropdown__toggle">
                                               <?php foreach($tickets as $item): ?>
                                               <?php if($item['ticket_status'] == 2): ?>
                                                <span class="m-nav__link-badge m-badge m-badge--dot m-badge--dot-small m-badge--danger"></span>
                                                <?php endif; ?>
                                                <?php endforeach; ?> 
                                                <span class="m-nav__link-icon">
                                                    <i class="flaticon-computer"></i>
                                                </span>
                                            </a>
                                            <div class="m-dropdown__wrapper">
                                                <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                                                <div class="m-dropdown__inner">
                                                    <div class="m-dropdown__header m--align-center" style="background: url(/assets/app/media/img/misc/quick_actions_bg.jpg); background-size: cover;">
                                                        <span class="m-dropdown__header-title">Запросы в службу поддержки</span>
                                                    </div>
                                                    <div class="m-dropdown__body m-dropdown__body--paddingless">
                                                        <div class="m-portlet m-portlet--bordered-semi m-portlet--full-height ">
                                                            <div class="m-portlet__body">
                                                                <div class="m-scrollable" data-scrollable="true" data-height="250" data-mobile-height="200">
                                                                <div class="m-widget4">
                                                                    <?php foreach($tickets as $item): ?> 
                                                                    <a href="/tickets/view/index/<?php echo $item['ticket_id'] ?>">
                                                                    <div class="m-widget4__item">
                                                                        <div class="m-widget4__img m-widget4__img--logo">
                                                                            <img src="/application/public/img/sup.png" alt="">
                                                                        </div>
                                                                        <div class="m-widget4__info">
                                                                            <span class="m-widget4__title">
                                                                            <?php echo $item['ticket_name'] ?>
                                                                            </span>
                                                                            <br>
                                                                            <span class="m-widget4__sub">
                                                                            <?php if($item['ticket_status'] == 0): ?> Вопрос закрыт.
                                                                            <?php elseif($item['ticket_status'] == 1): ?> Ваш вопрос рассматривают.
                                                                            <?php elseif($item['ticket_status'] == 2): ?> Ответ от администрации.
                                                                            <?php endif; ?>
                                                                            </span>
                                                                        </div>
                                                                       <span class="m-widget4__ext">
                                                                       <span class="m-widget3__number m--font-brand"><?php echo date("d.m.Y в H:i", strtotime($item['ticket_date_add'])) ?></span>
                                                                       </span>
                                                                    </div>
                                                                    </a>
                                                                    <?php endforeach; ?>
                                                                    <?php if(empty($tickets)): ?>
                                                                    <span class="m-widget14__desc">
                                                                    <center>Запросов в данный момент нет.</center>
                                                                    </span>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="m-nav__item m-topbar__user-profile m-topbar__user-profile--img  m-dropdown m-dropdown--medium m-dropdown--arrow m-dropdown--header-bg-fill m-dropdown--align-right m-dropdown--mobile-full-width m-dropdown--skin-light" m-dropdown-toggle="click">
                                            <a href="#" class="m-nav__link m-dropdown__toggle">
                                                <span class="m-topbar__userpic">
                                                    <img src="<?php echo $url ?><?php echo $user_img ?>" class="m--img-rounded m--marginless" alt="" />
                                                </span>
                                                <span class="m-topbar__username m--hide">Nick</span>
                                            </a>
                                            <div class="m-dropdown__wrapper">
                                                <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                                                <div class="m-dropdown__inner">
                                                    <div class="m-dropdown__header m--align-center" style="background: url(/assets/app/media/img/misc/user_profile_bg.jpg); background-size: cover;">
                                                        <div class="m-card-user m-card-user--skin-dark">
                                                            <div class="m-card-user__pic">
                                                                <img src="<?php echo $url ?><?php echo $user_img ?>" class="m--img-rounded m--marginless" alt="" />
                                                            </div>
                                                            <div class="m-card-user__details">
                                                                <span class="m-card-user__name m--font-weight-500"><?php echo $user_lastname ?> <?php echo $user_firstname ?></span>
                                                                <a href="" class="m-card-user__email m--font-weight-300 m-link"><?php echo $user_email ?></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="m-dropdown__body">
                                                        <div class="m-dropdown__content">
                                                            <ul class="m-nav m-nav--skin-light">
                                                                <li class="m-nav__section m--hide">
                                                                    <span class="m-nav__section-text"></span>
                                                                </li>
                                                                <li class="m-nav__item">
                                                                    <a href="/main/acc" class="m-nav__link">
                                                                        <i class="m-nav__link-icon flaticon-profile-1"></i>
                                                                        <span class="m-nav__link-title">
                                                                            <span class="m-nav__link-wrap">
                                                                                <span class="m-nav__link-text">Мой профиль</span>
                                                                                <span class="m-nav__link-badge">
                                                                                </span>
                                                                            </span>
                                                                        </span>
                                                                    </a>
                                                                </li>
                                                                <li class="m-nav__item">
                                                                    <a href="/tickets" class="m-nav__link">
                                                                        <i class="m-nav__link-icon flaticon-share"></i>
                                                                        <span class="m-nav__link-text">Мои тикеты</span>
                                                                    </a>
                                                                </li>
                                                                <li class="m-nav__item">
                                                                    <a href="/servers" class="m-nav__link">
                                                                        <i class="m-nav__link-icon flaticon-chat-1"></i>
                                                                        <span class="m-nav__link-text">Мои сервера</span>
                                                                    </a>
                                                                </li>
                                                                <li class="m-nav__separator m-nav__separator--fit">
                                                                </li>
                                                                <li class="m-nav__item">
                                                                    <a href="/account/logout" class="btn m-btn--pill    btn-secondary m-btn m-btn--custom m-btn--label-brand m-btn--bolder">Выйти</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <!-- END: Topbar -->
                        </div>
                    </div>
                </div>
            </header>

            <!-- END: Header -->

            <!-- begin::Body -->
            <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">

                <!-- BEGIN: Left Aside -->
                <button class="m-aside-left-close  m-aside-left-close--skin-dark " id="m_aside_left_close_btn">
                    <i class="la la-close"></i>
                </button>
                <div id="m_aside_left" class="m-grid__item  m-aside-left  m-aside-left--skin-dark ">

                    <!-- BEGIN: Aside Menu -->
                    <div id="m_ver_menu" class="m-aside-menu  m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark " m-menu-vertical="1" m-menu-scrollable="1" m-menu-dropdown-timeout="500" style="position: relative;">
                        <ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow ">
                            <li class="m-menu__item  m-menu__item--active" aria-haspopup="true">
                                <a href="/servers/control/index/<?php echo $server['server_id'] ?>" class="m-menu__link ">
                                    <i class="m-menu__link-icon fa fa-home"></i>
                                    <span class="m-menu__link-title">
                                        <span class="m-menu__link-wrap">
                                            <span class="m-menu__link-text"><?php echo $server['location_ip'] ?>:<?php echo $server['server_port'] ?></span>
                                            <span class="m-menu__link-badge">
                                            </span>
                                        </span>
                                    </span>
                                </a>
                            </li>
                            <li class="m-menu__section ">
                                <h4 class="m-menu__section-text">Меню</h4>
                                <i class="m-menu__section-icon flaticon-like"></i>
                            </li>
                            <?if($server['server_status'] == 1 or $server['server_status'] == 2 or $server['server_status'] == 7):?>
                            <li class="m-menu__item" aria-haspopup="true">
                                <a href="/servers/config/index/<?php echo $server['server_id'] ?>" class="m-menu__link ">
                                    <i class="m-menu__link-icon fa fa-cogs"></i>
                                    <span class="m-menu__link-title">
                                        <span class="m-menu__link-wrap">
                                            <span class="m-menu__link-text">Настройки</span>
                                            <span class="m-menu__link-badge">
                                            </span>
                                        </span>
                                    </span>
                                </a>
                            </li>
                            <li class="m-menu__item" aria-haspopup="true">
                                <a href="/servers/ftp/index/<?php echo $server['server_id'] ?>" class="m-menu__link ">
                                    <i class="m-menu__link-icon fa fa-server"></i>
                                    <span class="m-menu__link-title">
                                        <span class="m-menu__link-wrap">
                                            <span class="m-menu__link-text">FTP</span>
                                            <span class="m-menu__link-badge">
                                            </span>
                                        </span>
                                    </span>
                                </a>
                            </li>
                            <li class="m-menu__item" aria-haspopup="true">
                                <a href="/servers/mysql/index/<?php echo $server['server_id'] ?>" class="m-menu__link ">
                                    <i class="m-menu__link-icon fa fa-podcast"></i>
                                    <span class="m-menu__link-title">
                                        <span class="m-menu__link-wrap">
                                            <span class="m-menu__link-text">MySQL</span>
                                            <span class="m-menu__link-badge">
                                            </span>
                                        </span>
                                    </span>
                                </a>
                            </li>
                            <li class="m-menu__item" aria-haspopup="true">
                                <a href="/servers/console/index/<?php echo $server['server_id'] ?>" class="m-menu__link ">
                                    <i class="m-menu__link-icon fa fa-terminal"></i>
                                    <span class="m-menu__link-title">
                                        <span class="m-menu__link-wrap">
                                            <span class="m-menu__link-text">Консоль</span>
                                            <span class="m-menu__link-badge">
                                            </span>
                                        </span>
                                    </span>
                                </a>
                            </li>
                            <li class="m-menu__item" aria-haspopup="true">
                                <a href="/servers/setting/index/<?php echo $server['server_id'] ?>" class="m-menu__link ">
                                    <i class="m-menu__link-icon fa fa-edit"></i>
                                    <span class="m-menu__link-title">
                                        <span class="m-menu__link-wrap">
                                            <span class="m-menu__link-text">Конфигурация</span>
                                            <span class="m-menu__link-badge">
                                            </span>
                                        </span>
                                    </span>
                                </a>
                            </li>
                            <li class="m-menu__item" aria-haspopup="true">
                                <a href="/servers/fastdl/index/<?php echo $server['server_id'] ?>" class="m-menu__link ">
                                    <i class="m-menu__link-icon fa fa-tachometer-alt"></i>
                                    <span class="m-menu__link-title">
                                        <span class="m-menu__link-wrap">
                                            <span class="m-menu__link-text">FastDL</span>
                                            <span class="m-menu__link-badge">
                                            </span>
                                        </span>
                                    </span>
                                </a>
                            </li>
                            <li class="m-menu__item" aria-haspopup="true">
                                <a href="/servers/firewall/index/<?php echo $server['server_id'] ?>" class="m-menu__link ">
                                    <i class="m-menu__link-icon fa flaticon-route"></i>
                                    <span class="m-menu__link-title">
                                        <span class="m-menu__link-wrap">
                                            <span class="m-menu__link-text">Firewall</span>
                                            <span class="m-menu__link-badge">
                                            </span>
                                        </span>
                                    </span>
                                </a>
                            </li>
                            <li class="m-menu__item" aria-haspopup="true">
                                <a href="/servers/repo/index/<?php echo $server['server_id'] ?>" class="m-menu__link ">
                                    <i class="m-menu__link-icon flaticon-open-box"></i>
                                    <span class="m-menu__link-title">
                                        <span class="m-menu__link-wrap">
                                            <span class="m-menu__link-text">Репозиторий</span>
                                            <span class="m-menu__link-badge">
                                            </span>
                                        </span>
                                    </span>
                                </a>
                            </li>
                            <li class="m-menu__item" aria-haspopup="true">
                                <a href="/servers/owner/index/<?php echo $server['server_id'] ?>" class="m-menu__link ">
                                    <i class="m-menu__link-icon fa flaticon-users"></i>
                                    <span class="m-menu__link-title">
                                        <span class="m-menu__link-wrap">
                                            <span class="m-menu__link-text">Совладельцы</span>
                                            <span class="m-menu__link-badge">
                                            </span>
                                        </span>
                                    </span>
                                </a>
                            </li>
                            <?endif;?>
                            <li class="m-menu__item" aria-haspopup="true">
                                <a href="/main/index" class="m-menu__link ">
                                    <i class="m-menu__link-icon fa fa-share"></i>
                                    <span class="m-menu__link-title">
                                        <span class="m-menu__link-wrap">
                                            <span class="m-menu__link-text">Главная</span>
                                            <span class="m-menu__link-badge">
                                            </span>
                                        </span>
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- END: Aside Menu -->
                </div>

                <!-- END: Left Aside -->
                <div class="m-grid__item m-grid__item--fluid m-wrapper">

            <!-- end:: Body -->

            <!-- begin::Footer -->

            <!-- end::Footer -->
        </div>

        <!-- end:: Page -->
        <!-- begin::Scroll Top -->
        <div id="m_scroll_top" class="m-scroll-top">
            <i class="la la-arrow-up"></i>
        </div>

        <!-- end::Scroll Top -->

        <!--begin::Base Scripts -->
        <script src="/assets/vendors/base/vendors.bundle.js" type="text/javascript"></script>
        <script src="/assets/demo/default/base/scripts.bundle.js" type="text/javascript"></script>

        <!--end::Base Scripts -->

        <!--begin::Page Vendors Scripts -->
        <script src="/assets/vendors/custom/fullcalendar/fullcalendar.bundle.js" type="text/javascript"></script>

        <!--end::Page Vendors Scripts -->

        <!--begin::Page Snippets -->
        <script src="/assets/app/js/dashboard.js" type="text/javascript"></script>
        <!--end::Page Snippets -->
        <!--begin::HOSTINPL -->
        <script src="/application/public/js/main.js"></script>
        <script src="/application/public/js/jquery.form.min.js"></script>
        <script src="http://gsri1987.github.io/notific8-responsive/js/jquery.notific8.js"></script>
        <script src="/application/public/js/jquery.form.min.js"></script>
        <script type="text/javascript" src="/application/public/js/highstock.js"></script>
        <script src="/application/public/assets/global/plugins/flot/jquery.flot.min.js" type="text/javascript"></script>
<script src="/application/public/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="/application/public/assets/global/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
        <!--end::HOSTINPL -->        
        <!--begin::Modal-->
                        <div class="modal fade" id="hostin" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Пополнение баланса</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                    <form id="samirForm" method="POST" class="form_0" style="padding:0px; margin:0px;">
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
        <!-- Yandex.Metrika counter -->
    <script type="text/javascript">
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter35431120 = new Ya.Metrika({
                    id:35431120,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true
                });
            } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/watch.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/35431120" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
<!-- END PAGE LEVEL SCRIPTS -->
<script>
jQuery(document).ready(function() {    
   Metronic.init(); // init metronic core componets
   Layout.init(); // init layout
   Demo.init(); // init demo features 
   UIBlockUI.init();
});
</script>
<script>
                    $('#hostin').ajaxForm({ 
                        url: '/account/robopay/ajax',
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

<!-- END JAVASCRIPTS -->
<!-- END BODY -->
        <?php if(isset($error)): ?><script>toastr.error('<?php echo $error ?>');</script><?php endif; ?> 
        <?php if(isset($warning)): ?><script>toastr.warning('<?php echo $warning ?>');</script><?php endif; ?> 
        <?php if(isset($success)): ?><script>toastr.success('<?php echo $success ?>');</script><?php endif; ?> 
    </body>

    <!-- end::Body -->
</html>