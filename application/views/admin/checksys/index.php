<?php
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
?>
<?php echo $admheader ?>
<?php
$mysqlExists = false;
if(function_exists("mysql_connect"))
	$mysqlExists = true;

$ssh2Exists = false;
if(function_exists("ssh2_connect"))
	$ssh2Exists = true;

$gdExists = false;
if(function_exists("gd_info"))
	$gdExists = true;

$curlExists = false;
if(function_exists("curl_getinfo"))	
	$curlExists = true;

$modRewriteExists = false;
if(in_array('mod_rewrite', apache_get_modules()))
	$modRewriteExists = true;

?>
<div class="col-12">
    <div class="m-content">
        <div class="row">
        	<div class="col-lg-12">
                <div class="m-portlet m-portlet--brand m-portlet--head-solid-bg">
					<div class="m-portlet__head">
						<div class="m-portlet__head-caption">
							<div class="m-portlet__head-title">
								<span class="m-portlet__head-icon">
									<i class="flaticon-medical"></i>
								</span>
								<h3 class="m-portlet__head-text">
									Проверка системы
								</h3>
							</div>
						</div>
					</div>
					<div class="m-portlet__body" style="padding-top: 0px;">
						<div class="table-scrollable table-scrollable-borderless" style="margin-top: 0px !important;">
                            <table class="table table-hover table-light">
                                <thead>
                                    <tr>
                                        <th>Функция</th>
                                        <th>Статус</th>
                                        <th>Установка</th>
                                        <th>Информация</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Система</td>
                                        <td>HOSTINPL 5.4</td>
                                        <td><i class="fa fa-check-circle"></td>
                                        <td><?php echo php_uname() ?></td>
                                    </tr>  
                                    <tr>
                                        <td>php_mysql</td>
                                        <td><?php if($mysqlExists): ?>Установлен<?php else: ?>Не установлен<?php endif; ?></td>
                                        <td><?php if($mysqlExists): ?><i class="fa fa-check-circle"></i><?php else: ?><code>apt-get install php5-mysql</code><?php endif; ?></td>
                                        <td>Работоспособность бд для сервера.</td>
                                    </tr>       
                                    <tr>
                                       <td>php_ssh2</td>
                                       <td><?php if($ssh2Exists): ?>Установлен<?php else: ?>Не установлен<?php endif; ?></td>
                                       <td><?php if($ssh2Exists): ?><i class="fa fa-check-circle"></i><?php else: ?><code>apt-get install libssh2-php</code><?php endif; ?></td>
                                       <td>Подключение по ssh.</td>
                                    </tr> 
                                    <tr>
                                    	<td>php_gd</td>
                                        <td><?php if($gdExists): ?>Установлен<?php else: ?>Не установлен<?php endif; ?></td>
                                        <td><?php if($gdExists): ?><i class="fa fa-check-circle"></i><?php else: ?><code>apt-get install php5-gd</code><?php endif; ?></td>
                                        <td>Просмотр каптчи.</td>
                                    </tr> 
                                    <tr>
                                        <td>mod_rewrite</td>
                                        <td><?php if($modRewriteExists): ?>Установлен<?php else: ?>Не установлен<?php endif; ?></td>
                                        <td><?php if($modRewriteExists): ?><i class="fa fa-check-circle"></i><?php else: ?><code>a2enmod rewrite</code><?php endif; ?></td>
                                        <td>Кэширование памяти.</td>
                                    </tr> 
                                    <tr>
                                        <td>cURL</td>
                                        <td><?php if($curlExists): ?>Установлен<?php else: ?>Не установлен<?php endif; ?></td>
                                        <td><?php if($curlExists): ?><i class="fa fa-check-circle"></i><?php else: ?><code>apt-get install curl</code><br><code>apt-get install php5-curl</code><?php endif; ?></td>
                                        <td>Обновление cron из ssh.</td>
                                    </tr> 
                                </tbody>
                            </table>
                        </div>
					</div>
				</div>
			</div>
			<div class="col-lg-12">
                <div class="m-portlet m-portlet--brand m-portlet--head-solid-bg">
					<div class="m-portlet__head">
						<div class="m-portlet__head-caption">
							<div class="m-portlet__head-title">
								<span class="m-portlet__head-icon">
									<i class="flaticon-calendar-1"></i>
								</span>
								<h3 class="m-portlet__head-text">
									Запуск cron
								</h3>
							</div>
						</div>
					</div>
					<div class="m-portlet__body" style="padding-top: 0px;">
						<div class="table-scrollable table-scrollable-borderless" style="margin-top: 0px !important;">
                            <table class="table table-hover table-light">
                                <thead>
                                    <tr>
                                        <th>Время</th>
                                        <th>Команда</th>
                                        <th>Crontab</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1 раз в 12 часов</td>
                                        <td><?php echo $url ?>main/cron/index?token=<?php echo $token ?></td>
                                        <td><code>0 12 * * * curl <?php echo $url ?>main/cron/index?token=<?php echo $token ?></code></td>
                                    </tr>   
                                    <tr>
                                        <td>1 раз в 1 минуту</td>
                                        <td><?php echo $url ?>main/cron/updateSystemLoad?token=<?php echo $token ?></td>
                                        <td><code>*/1 * * * * curl <?php echo $url ?>main/cron/updateSystemLoad?token=<?php echo $token ?></code></td>
                                    </tr>     
                                    <tr>
                                        <td>1 раз час</td>
                                        <td><?php echo $url ?>main/cron/updateStats?token=<?php echo $token ?></td>
                                        <td><code>0 */1 * * * curl <?php echo $url ?>main/cron/updateStats?token=<?php echo $token ?></code></td>
                                    </tr>
                                    <tr>
                                        <td>1 раз в 10 минут</td>
                                        <td><?php echo $url ?>main/cron/serverReloader?token=<?php echo $token ?></td>
                                        <td><code>0 */10 * * * curl <?php echo $url ?>main/cron/serverReloader?token=<?php echo $token ?></code></td>
                                    </tr>
                                    <tr>
                                        <td>1 раз в 12 часов</td>
                                        <td><?php echo $url ?>main/cron/gamelocationstatsupd?token=<?php echo $token ?></td>
                                        <td><code>0 12 * * * curl <?php echo $url ?>main/cron/gamelocationstatsupd?token=<?php echo $token ?></code></td>
                                    </tr>
                                    <tr>
                                        <td>1 раз в неделю</td>
                                        <td><?php echo $url ?>main/cron/clearLogs?token=<?php echo $token ?></td>
                                        <td><code>0 * 7 * * curl <?php echo $url ?>main/cron/clearLogs?token=<?php echo $token ?></code></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?echo $footer?>