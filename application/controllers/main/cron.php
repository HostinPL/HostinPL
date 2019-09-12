<?php
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
class cronController extends Controller {
	public function index() {
		$this->load->checkLicense();
		$this->load->library('mail');
		$this->load->model('servers');
		$this->load->model('serversStats');
		$this->load->model('invoices');
		$token = @$this->request->get['token'];
		if($this->config->token != $token) {
			return "Access Denied";
		}
		
		$mailLib = new mailLibrary();
		
		$mailLib->setFrom($this->config->mail_from);
		$mailLib->setSender($this->config->mail_sender);
		
		$servers = $this->serversModel->getServers(array(), array('users'));
		
		$datenow = date_create('now');
		
		foreach($servers as $item) {
			$serverid = $item['server_id'];
			$dateend = date_create($item['server_date_end']);
			$diff = date_diff($datenow, $dateend);
			
			if($diff->invert) {
				if($diff->days >= 3) {
					// Удаление
					$this->serversModel->execServerAction($serverid, 'delete');
					$this->serversModel->deleteServer($serverid);
					$this->serversStatsModel->deleteServerStats($serverid);
					
					echo "gs$item[server_id] - удален.\n";
					
					// Отправка уведомления
					$mailLib->setTo($item['user_email']);
					$mailLib->setSubject("Удаление сервера #$serverid");
					
					$mailData = array();
					$mailData['firstname'] = $item['user_firstname'];
					$mailData['lastname'] = $item['user_lastname'];
					$mailData['serverid'] = $serverid;
					
					$text = $this->load->view('mail/servers/deleted', $mailData);
					
					$mailLib->setText($text);
					$mailLib->send();
				} else {
					// Блокировка
					$this->serversModel->execServerAction($serverid, 'stop');
					$this->serversModel->updateServer($serverid, array('server_status' => 0));
					//$mailLib->execServerAction($serverid, 'stop');
					//$mailLib->updateServer($serverid, array('server_status' => 0));
					echo "gs$item[server_id] - заблокирован.\n";
					
					// Отправка уведомления
					$mailLib->setTo($item['user_email']);
					$mailLib->setSubject("Блокировка сервера #$serverid");
			
					$mailData = array();
					$mailData['firstname'] = $item['user_firstname'];
					$mailData['lastname'] = $item['user_lastname'];
					$mailData['serverid'] = $serverid;
			
					$text = $this->load->view('mail/servers/lock', $mailData);
			
					$mailLib->setText($text);
					$mailLib->send();
				}
			} else {
				if($diff->days < 3) {
					echo "gs$item[server_id] - отправлено уведомление.\n";
					
					// Отправка уведомления
					$mailLib->setTo($item['user_email']);
					$mailLib->setSubject("Завершение оплаченного периода сервера #$serverid");
					
					$mailData = array();
					$mailData['firstname'] = $item['user_firstname'];
					$mailData['lastname'] = $item['user_lastname'];
					$mailData['serverid'] = $serverid;
					$mailData['days'] = $diff->days;
			
					$text = $this->load->view('mail/servers/needPay', $mailData);
			
					$mailLib->setText($text);
					$mailLib->send();
				}
			}
		}
		$getData = array('invoice_status' => 0 );
        $invoices = $this->invoicesModel->getInvoices($getData, array(), array(), $options);
		foreach($invoices as $item) {
		$invoiceid = $item['invoice_id'];
		$this->invoicesModel->deleteInvoice($invoiceid);
		}
		return null;
	}
	
	public function updateSystemLoad() {
		$this->load->checkLicense();
		$this->load->model('servers');
		$this->load->model('serverLog');
		$this->load->library('ssh2');
		$token = @$this->request->get['token'];
		if($this->config->token != $token) {
			return "Access Denied";
		}
		$servers = $this->serversModel->getServers(array(), array('games', 'users', 'locations'));

		foreach($servers as $item) {
			$serverid = $item['server_id'];
			
			if($item['server_status'] == 2) {
				$sysload = $this->serversModel->getServerSystemLoad($serverid);
				//new
				$cpu = round($sysload['cpu']);
				$ram = $sysload['ram'] > 100 ? 100 : round($sysload['ram']);
				$this->serversModel->updateServer($serverid, array(
					'server_cpu_load'	=>	$cpu,
					'server_ram_load'	=>	$ram
				));
			} 
			elseif($item['server_status'] == 3 & $item['server_install'] == 2) {
				$this->serversModel->execServerAction($serverid, "install");
			}
			elseif($item['server_status'] == 4 & $item['server_install'] == 2) {
				$this->serversModel->execServerAction($serverid, 'reinstall');	
			}
			elseif($item['server_status'] == 3 & $item['server_install'] == 1) {
				$this->serversModel->updateServer($serverid, array(
					'server_status'	=>	1,
					'server_install' => 0
				));
										$logData = array(
							'server_id'			=> $serverid,
							'reason'            => 'Сервер успешно установлен.',
							'status'            => 1
						);
                 $this->serverLogModel->createLog($logData);
			}
			elseif($item['server_status'] == 4 & $item['server_install'] == 1) {
				$this->serversModel->updateServer($serverid, array(
					'server_status'	=>	1,
					'server_install' => 0
				));
										$logData = array(
							'server_id'			=> $serverid,
							'reason'            => 'Сервер успешно установлен.',
							'status'            => 1
						);
                 $this->serverLogModel->createLog($logData);
			}
			elseif($item['server_status'] == 7) {
				//Этап установки
				if($item['server_install'] == 1) {
					$ssh = new ssh2Library();
											
					$connect = $ssh->connect($item['location_ip'], $item['location_user'], $item['location_password']);
					//Узнаём активена ли screen задача 
					$res = $ssh->execute($connect, "screen -ls | grep -c repo_wget" . $item['server_id'] . ";");
					//Если сервер установлен
					if($res == 0) {
						$this->serversModel->updateServer($serverid, array(
							'server_status'	=>	7,
							'server_install' => 2
						));	
						//Создание лога об установке сервера 
						//
						
						$cmd = "cd /home/gs".$item['server_id'].";";
						$cmd .= "screen -AmdSL repo_unzip".$item['server_id']." unzip ".$item['repozitory_item'].";";
						$ssh->execute($connect, $cmd);
									
					//Если сервер не установлен и ещё висит задача
					} else {
						//Проверка кол.ва задач 
						if($res == 1) {
							//Создание лога об установке сервера 
						//
						//Если больше 1 то это ошибка
						} else {
													//Создание лога об установке сервера 
						//
						}
					}
				}
				//Этап установки
				if($item['server_install'] == 2) {
					$ssh = new ssh2Library();
											
					$connect = $ssh->connect($item['location_ip'], $item['location_user'], $item['location_password']);
					//Узнаём активена ли screen задача 
					$res = $ssh->execute($connect, "screen -ls | grep -c repo_unzip" . $item['server_id'] . ";");
					//Если сервер установлен
					if($res == 0) {
						$this->serversModel->updateServer($serverid, array(
							'server_status'	=>	1,
							'server_install' => 0
						));	
												//Создание лога об установке сервера 
						//
						//Ставим права и пользователя
						$ssh->execute($connect, "cd /home/;chmod 777 -R /home/gs" . $item['server_id'] . ";");
						$ssh->execute($connect, "cd /home/gs" . $item['server_id'] . ";rm ".$item['repozitory_item'].";");
						$ssh->execute($connect, "sudo chown -R gs" . $item['server_id'] . ":gameservers /home/gs" . $item['server_id'] . ";");
					//Если сервер не установлен и ещё висит задача
					} else {
						//Проверка кол.ва задач 
						if($res == 1) {
													//Создание лога об установке сервера 
						//
						//Если больше 1 то это ошибка
						} else {
													//Создание лога об установке сервера 
						//
						}
					}
					//Закрываем соединение с сервером
					$ssh->disconnect($connect);
				}
			}
			
		}
		return null;
	}
	public function gamelocationstatsupd() {
		$this->load->checkLicense();
		$token = @$this->request->get['token'];
		if($this->config->token != $token) {
			return "Access Denied";
		}
		$this->load->model('locations');
		
		$locations = $this->locationsModel->getLocations(array(), array(), array());
		
		$today = date("Y-m-d H:i:s");
		
		foreach($locations as $item) {
		$locationid = $item['location_id'];
			if($item['location_status'] == 1) {
					$sysload = $this->locationsModel->getSystemLoad($locationid);
					$cpu = $sysload['cpu'];
					$ram = $sysload['ram'];	
					$hdd = $sysload['hdd'];	
					$hddold = $sysload['hddold'];	
					$players = $sysload['players'];
					$uptime = $sysload['uptime'];
					
					$locationData = array(
						'location_cpu'			=> $cpu,
						'location_ram'			=> $ram,
						'location_hdd'			=> $hdd,
						'location_hddold'		=> $hddold,
						'location_players'		=> $players,
						'location_uptime'		=> $uptime,
						'location_upd'		    => $today
					);				
					$this->locationsModel->updateLocation($locationid, $locationData);
									
			}
			if($item['location_status'] == 0) {
					$locationData = array(
						'location_cpu'			=> 0,
						'location_ram'			=> 0,
						'location_hdd'			=> 0,
						'location_hddold'		=> 0,
						'location_players'		=> 0,
						'location_uptime'		=> 0,
						'location_upd'		    => $today
					);				
					$this->locationsModel->updateLocation($locationid, $locationData);
			}
		}		
		return null;
    }
	
	public function updateStats() {
		$this->load->checkLicense();
		$this->load->library('query');
		$this->load->model('servers');
		$this->load->model('serversStats');
		
		$token = @$this->request->get['token'];
		if($this->config->token != $token) {
			return "Access Denied";
		}
		
		$servers = $this->serversModel->getServers(array(), array('games', 'locations'));
		
		// Удаление устаревшей статистики
		$this->serversStatsModel->clearServersStats();
		
		foreach($servers as $item) {
			$serverid = $item['server_id'];
			
			if($item['server_status'] == 2) {
				$queryLib = new queryLibrary($item['game_query']);
				$queryLib->connect($item['location_ip'], $item['server_port']);
				$query = $queryLib->getInfo();
				$queryLib->disconnect();
				
				$sysload = $this->serversModel->getServerSystemLoad($serverid);
				$hdd = $this->serversModel->getHDD($serverid);
				$cpu = round($sysload['cpu']);
				$ram = round($sysload['ram']);				
				
				$this->serversStatsModel->createServerStats(array(
					'server_id'				=> $serverid,
					'server_stats_players'	=> round($query['players']),
					'server_stats_cpu'		=> $cpu,
					'server_stats_ram'		=> $ram,
					'server_stats_hdd'		=> $hdd								
				));	

				if($cpu > 90) {
					$connect = $this->serversModel->execServerAction($serverid, 'stop');
					if($connect['status'] == "OK") {								
						// "Остановка сервера: OVERLOAD-cpu = ".$cpu."%",
					} else {							
						// "Ошибка остановки сервера!",
					}
				}elseif($ram > 90){
					$connect = $this->serversModel->execServerAction($serverid, 'stop');
					if($connect['status'] == "OK") {								
						// "Остановка сервера: OVERLOAD-ram = ".$ram."%",
					} else {							
						// "Ошибка остановки сервера!",
					}
				}elseif($query['players'] > ($item['server_slots']+2)){
					$connect = $this->serversModel->execServerAction($serverid, 'stop');
					if($connect['status'] == "OK") {								
						// "Остановка сервера: Чрезмерное кол.во игроков на сервере, игроков ".$query['players']." слотов ".$item['server_slots']
					} else {							
						// лог ошибки остановка
					}
				}	
				
			}
		}
		return null;
	}

	public function serverReloader() {
		$this->load->checkLicense();
		
		$token = @$this->request->get['token'];
		if($this->config->token != $token) {
			return "Access Denied";
		}
		
		$this->load->library('query');
		$this->load->model('servers');
		$this->load->model('serverLog');
		
		$servers = $this->serversModel->getServers(array(), array('games', 'locations'));
		
		$i=0;
		
		foreach($servers as $item) {
			$serverid = $item['server_id'];
			
			 if($item['server_status'] == 2) { 
                if($item['game_id'] == 1 || $item['game_id'] == 2 || $item['game_id'] == 3 || $item['game_id'] == 4 || $item['game_id'] == 5 || $item['game_id'] == 6 || $item['game_id'] == 7 || $item['game_id'] == 8 || $item['game_id'] == 9 || $item['game_id'] == 10 || $item['game_id'] == 11 || $item['game_id'] == 12 || $item['game_id'] == 13)
             {
			$queryLib = new queryLibrary($item['game_query']);
			$queryLib->connect($item['location_ip'], $item['server_port']);
			$query = $queryLib->getInfo();
			$queryLib->disconnect();
			
			if(empty($query['hostname'])){
				$i++;
			$result = $this->serversModel->execServerAction($serverid, 'start');
					if($result['status'] == "OK") {
						$this->serversModel->updateServer($serverid, array('server_status' => 2));
						$logData = array(
							'server_id'			=> $serverid,
							'reason'            => 'Сервер был восcтановлен после падения',
							'status'            => 2
						);
                        $this->serverLogModel->createLog($logData);
						echo "Сервер №".$serverid." был перезапущен!<br>";
					} else {
						$logData = array(
							'server_id'			=> $serverid,
							'reason'            => 'Ошибка востановления работы сервера',
							'status'            => 3
						);
						echo "Ошибка сервера №".$serverid.": ".$result['description'];
			}}
			
		}}
		}
		if($i==0) echo 'Все сервера отлично работают!';
		return null;
	}
	
	public function clearLogs() {
		$this->load->checkLicense();
		$this->load->model('waste');
		$this->load->model('serverLog');
		$token = @$this->request->get['token'];
		if($this->config->token != $token) {
			return "Access Denied";
		}
		
		$wasteLogs = $this->wasteModel->getWaste();
		$serverLogs = $this->serverLogModel->getLogs();
		
		$datenow = date_create('now');
		
		foreach($serverLogs as $item) {
			$diff = date_diff($datenow, date_create($item['date']));
			
			if($diff->invert) {
				if($diff->days >= 7) {
					$this->serverLogModel->deleteLog($item['log_id']);
				}
			}
		}
		
		foreach($wasteLogs as $item) {
			$diff = date_diff($datenow, date_create($item['waste_date_add']));
			
			if($diff->invert) {
				if($diff->days >= 7) {
					$this->wasteModel->deleteWaste($item['waste_id']);
				}
			}
		}

		return null;
	}
}
?>
