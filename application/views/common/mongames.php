<?php
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
?>
<style type="text/css">
.m-widget4 .m-widget4__item .m-widget4__img.m-widget4__img--logo img {
    width: 2.5rem;
    border-radius: 20%;
</style>
<div class="m-widget4">
	<ul class="m-nav m-nav--hover-bg m-portlet-fit--sides">
		<?$tserverov12 = 0;
foreach($servers as $item): ?>
<? if (!($item['server_status'] == 2)) { // пропуск нечетных чисел
                        continue;
                        }?>
<? $tserverov12++; ?>
<?endforeach;?>
<?if($tserverov12 > 0):?>
		<li class="m-nav__item">
			<a href="/monitor/" class="m-nav__link">
				<div class="m-widget4__item">
					<div class="m-widget4__img m-widget4__img--logo">
						<img src="/application/public/img/monitor/all.png" alt="">
					</div>
					<div class="m-widget4__info">
						<span class="m-widget4__title">Все сервера</span>
						<br>
						<span class="m-widget4__sub">Серверов онлайн:</span>
					</div>
					<span class="m-widget4__ext">
						<span class="m-widget4__number m--font-brand"><?echo $tserverov12; ?></span>
					</span>
				</div>
			</a>
		</li>
		<?endif;?>
		<?$tserverov2 = 0;
foreach($servers as $item): ?>
<? if (!($item['game_code'] == 'samp' && $item['server_status'] == 2)) { // пропуск нечетных чисел
                        continue;
                        }?>
<? $tserverov2++; ?>
<?endforeach;?>
<?if($tserverov2 > 0):?>
		<li class="m-nav__item">
			<a href="/monitor/samp" class="m-nav__link">
				<div class="m-widget4__item">
					<div class="m-widget4__img m-widget4__img--logo">
						<img src="/application/public/img/monitor/samp.png" alt="">
					</div>
					<div class="m-widget4__info">
						<span class="m-widget4__title">San Andreas Multiplayer</span>
						<br>
						<span class="m-widget4__sub">Серверов онлайн:</span>
					</div>
					<span class="m-widget4__ext">
						<span class="m-widget4__number m--font-brand"><?echo $tserverov2; ?></span>
					</span>
				</div>
			</a>
		</li>
		<?endif;?>
		<?$tserverov3 = 0;
foreach($servers as $item): ?>
<? if (!($item['game_code'] == 'crmp' && $item['server_status'] == 2)) { // пропуск нечетных чисел
                        continue;
                        }?>
<? $tserverov3++; ?>
<?endforeach;?><?if($tserverov3 > 0):?>
		<li class="m-nav__item">
			<a href="/monitor/crmp" class="m-nav__link">
				<div class="m-widget4__item">
					<div class="m-widget4__img m-widget4__img--logo">
						<img src="/application/public/img/monitor/crmp.png" alt="">
					</div>
					<div class="m-widget4__info">
						<span class="m-widget4__title">Criminal Russia Multiplayer</span>
						<br>
						<span class="m-widget4__sub">Серверов онлайн:</span>
					</div>
					<span class="m-widget4__ext">
						<span class="m-widget4__number m--font-brand"><?echo $tserverov3; ?></span>
					</span>
				</div>
			</a>
		</li>
		<?endif;?>
		<?$tserverov5 = 0;
foreach($servers as $item): ?>
<? if (!($item['game_code'] == 'mta' && $item['server_status'] == 2)) { // пропуск нечетных чисел
                        continue;
                        }?>
<? $tserverov5++; ?>
<?endforeach;?><?if($tserverov5 > 0):?>
		<li class="m-nav__item">
			<a href="/monitor/mta" class="m-nav__link">
				<div class="m-widget4__item">
					<div class="m-widget4__img m-widget4__img--logo">
						<img src="/application/public/img/monitor/mta.png" alt="">
					</div>
					<div class="m-widget4__info">
						<span class="m-widget4__title">Multi Theft Auto</span>
						<br>
						<span class="m-widget4__sub">Серверов онлайн:</span>
					</div>
					<span class="m-widget4__ext">
						<span class="m-widget4__number m--font-brand"><?echo $tserverov5; ?></span>
					</span>
				</div>
			</a>
		</li>
		<?endif;?>
		<?$tserverov10 = 0;
foreach($servers as $item): ?>
<? if (!($item['game_code'] == 'unit' && $item['server_status'] == 2)) { // пропуск нечетных чисел
                        continue;
                        }?>
<? $tserverov10++; ?>
<?endforeach;?>
<?if($tserverov10 > 0):?>
		<li class="m-nav__item">
			<a href="/monitor/unit" class="m-nav__link">
				<div class="m-widget4__item">
					<div class="m-widget4__img m-widget4__img--logo">
						<img src="/application/public/img/monitor/mtasa.png" alt="">
					</div>
					<div class="m-widget4__info">
						<span class="m-widget4__title">United Multiplayer</span>
						<br>
						<span class="m-widget4__sub">Серверов онлайн:</span>
					</div>
					<span class="m-widget4__ext">
						<span class="m-widget4__number m--font-brand"><?echo $tserverov10; ?></span>
					</span>
				</div>
			</a>
		</li>
		<?endif;?>
		<?$tserverov1 = 0;
foreach($servers as $item): ?>
<? if (!($item['game_code'] == 'cs' && $item['server_status'] == 2)) { // пропуск нечетных чисел
                        continue;
                        }?>
<? $tserverov1++; ?>
<?endforeach;?>
<?if($tserverov1 > 0):?>
		<li class="m-nav__item">
			<a href="/monitor/cs" class="m-nav__link">
				<div class="m-widget4__item">
					<div class="m-widget4__img m-widget4__img--logo">
						<img src="/application/public/img/monitor/cs.png" alt="">
					</div>
					<div class="m-widget4__info">
						<span class="m-widget4__title">Counter-Strike: 1.6</span>
						<br>
						<span class="m-widget4__sub">Серверов онлайн:</span>
					</div>
					<span class="m-widget4__ext">
						<span class="m-widget4__number m--font-brand"><?echo $tserverov1; ?></span>
					</span>
				</div>
			</a>
		</li>
		<?endif;?>
		<?$tserverov4 = 0;
foreach($servers as $item): ?>
<? if (!($item['game_code'] == 'css' && $item['server_status'] == 2)) { // пропуск нечетных чисел
                        continue;
                        }?>
<? $tserverov4++; ?>
<?endforeach;?>
<?if($tserverov4 > 0):?>
		<li class="m-nav__item">
			<a href="/monitor/css" class="m-nav__link">
				<div class="m-widget4__item">
					<div class="m-widget4__img m-widget4__img--logo">
						<img src="/application/public/img/monitor/css.png" alt="">
					</div>
					<div class="m-widget4__info">
						<span class="m-widget4__title">Counter-Strike: Source</span>
						<br>
						<span class="m-widget4__sub">Серверов онлайн:</span>
					</div>
					<span class="m-widget4__ext">
						<span class="m-widget4__number m--font-brand"><?echo $tserverov4; ?></span>
					</span>
				</div>
			</a>
		</li>
		<?endif;?>
		<?$tserverov6 = 0;
foreach($servers as $item): ?>
<? if (!($item['game_query'] == 'mine' && $item['server_status'] == 2)) { // пропуск нечетных чисел
                        continue;
                        }?>
<? $tserverov6++; ?>
<?endforeach;?><?if($tserverov6 > 0):?>
		<li class="m-nav__item">
			<a href="/monitor/mcpe" class="m-nav__link">
				<div class="m-widget4__item">
					<div class="m-widget4__img m-widget4__img--logo">
						<img src="/application/public/img/monitor/mine.png" alt="">
					</div>
					<div class="m-widget4__info">
						<span class="m-widget4__title">Minecraft</span>
						<br>
						<span class="m-widget4__sub">Серверов онлайн:</span>
					</div>
					<span class="m-widget4__ext">
						<span class="m-widget4__number m--font-brand"><?echo $tserverov6; ?></span>
					</span>
				</div>
			</a>
		</li>
		<?endif;?>
	</ul>
</div>