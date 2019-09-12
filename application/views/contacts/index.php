<?php
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
?>
<?php echo $header ?>
<div class="col-12">
    <div class="m-content">
        <div class="row">
        <?php foreach($users as $item): ?> 
        <? if (!($item['user_access_level'] == 3)) {
            continue;
        }?>
            <div class="col-lg-4">
                <div class="m-portlet m-portlet--full-height  ">
                    <div class="m-portlet__body">
                        <div class="m-card-profile">
                            <div class="m-card-profile__title m--hide"></div>
                            <div class="m-card-profile__pic">
                                <div class="m-card-profile__pic-wrapper">
                                    <img src="<?php echo $url ?><?if($item['user_img']) {echo $item['user_img'];}else{ echo '/application/public/img/user.png';}?>" alt="">
                                </div>
                            </div>
                            <div class="m-card-profile__details">
                                <span class="m-card-profile__name"><?php echo $item['user_lastname'] ?> <?php echo $item['user_firstname'] ?></span>
                                <a href="#" class="m-card-profile__email m-link">Администратор</a><br>
                            </div>
                        </div>
                        <ul class="m-nav m-nav--hover-bg m-portlet-fit--sides">
                            <li class="m-nav__separator m-nav__separator--fit"></li>
                            <li class="m-nav__section m--hide">
                                <span class="m-nav__section-text"></span>
                            </li>
                            <li class="m-nav__item">
                                <a href="https://vk.com/write<?php echo $item['user_vk_id'] ?>" target="blank" class="m-nav__link">
                                    <i class="m-nav__link-icon fa flaticon-chat-1"></i>
                                    <span class="m-nav__link-title">
                                        <span class="m-nav__link-wrap">
                                            <span class="m-nav__link-text">Сообщение</span>
                                                <span class="m-nav__link-badge">
                                            </span>
                                        </span>
                                    </span>
                                </a>
                            </li>
                            <li class="m-nav__item">
                                <a href="https://vk.com/id<?php echo $item['user_vk_id'] ?>" target="blank" class="m-nav__link">
                                    <i class="m-nav__link-icon fa flaticon-profile-1"></i>
                                    <span class="m-nav__link-title">
                                        <span class="m-nav__link-wrap">
                                            <span class="m-nav__link-text">ВКонтакте</span>
                                                <span class="m-nav__link-badge">
                                            </span>
                                        </span>
                                    </span>
                                </a>
                            </li>
                            <li class="m-nav__item">
                                <a href="mailto:<?php echo $item['user_email'] ?>" class="m-nav__link">
                                    <i class="m-nav__link-icon fa flaticon-computer"></i>
                                    <span class="m-nav__link-title">
                                        <span class="m-nav__link-wrap">
                                            <span class="m-nav__link-text"><?php echo $item['user_email'] ?></span>
                                                <span class="m-nav__link-badge">
                                            </span>
                                        </span>
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        </div>
    </div>
</div>
<?php echo $footer ?>