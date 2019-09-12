<?php
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
class indexController extends Controller {
	public function index() {
		return "Error:";
	}
	
	public function vkbot() {
		if (!isset($_REQUEST)) {
			return;
		}
		
		$confirmationToken = $this->config->VK_confirmationToken;
		$token = $this->config->VK_token;
		$secretKey = $this->config->VK_secretKey;
		
		$this->load->model('users');
		$this->load->model('servers');
		$this->load->library('query');

		$data = json_decode(file_get_contents('php://input'));

		if (strcmp($data->secret, $secretKey) !== 0 && strcmp($data->type, 'confirmation') !== 0)
			return;
		
		switch($data->type) {
			case 'confirmation': {
					echo $confirmationToken;
				break;
			}
			case 'message_new': {
					$userId = $data->object->user_id;
					$message = $data->object->body;
					$users = $this->usersModel->getUserByUser_vk_id($userId);
				
					switch($message) {
						case '/help': {
								$mes = '
									Команды бота:
									/ping - Доступен ли сайт?
									/getpromo - Возможность получить 100% промокод на одну из услуг на хостинге !
									/start ID - Запуск сервера
									/restart ID - Перезапуск сервера
									/stop ID - Остановка сервера
									/status ID - Статус сервера (QUERY / CPU / RAM )
									/gservers - Запрос списка арендованных Вами game серверов
								';
							break;
						}
						case '/ping': {
								$mes = 'Сайт доступен!';
							break;
						}
						case '/getpromo': {
							$this->load->model('promos');
							if($users['user_vk_id'] ==	$userId){					
								if($users['user_promo_date'] == date("Y-m-d")){
									$mes = 'Услугой можно пользоваться только 1 раз за сутки!';
								} else {
									$LastTime = time() - 50;
									if($users['user_online_date'] > $LastTime){
										$this->usersModel->updateUser($users['user_id'], array('user_promo_date' => date("Y-m-d")));
										
										$day = date("j");
										$val = rand(1, 31);
										$months = rand(1, 12);
										if($val == $day){
											$code = $this->load->genpass(18);
											$promoData = array(
												'cod'		=> $code,
												'uses'		=> 1,
												'used'		=> 0,
												'skidka'	=> 100
											);
											
											$this->promosModel->createPromo($promoData);


											$mes = "Вы выйграли промокод ".$code." на 100% для заказа любого игрового сервера!
											<br>
											Промокод на оплату ".$months." месяца(ев)!
											
											
											";
										} else {
											$mes = 'Сегодня вам неповезло. Ваш результат [Рандомное число '.$val.' | День месяца '.$day.']';
										}
									} else {
										$mes = 'Вам необходимо авторизоваться на сайте для получения бонуса!';
									}
								}
							} else {
								$mes = 'Вы должны быть зарегистрированы на нашем сайте, и привязать учётную запись VK Для получения ежедневного бонуса!';
							}
							break;
						}
						case mb_strtolower(explode(' ', $message)[0], 'UTF-8') == '/status': {
							if($users['user_vk_id'] ==	$userId){	
								if (explode(' ', $message)[1]) {
									$gameid = (int)explode(' ', $message)[1];
									if($this->serversModel->getTotalServers(array('server_id' => $gameid, 'user_id' => $users['user_id']))) {
										$gameServer = $this->serversModel->getServerById($gameid, array('games', 'locations'));
										if($gameServer['server_status'] == 0) {
											$mes = "Не оплачен";
										} elseif($gameServer['server_status'] == 1) {
											$mes = "Выключен";
										} elseif($gameServer['server_status'] == 2) {
											$queryLib = new queryLibrary($gameServer['game_code']);
											$queryLib->connect($gameServer['location_ip'], $gameServer['server_port']);
											$QueryGameServer = $queryLib->getInfo();
											$queryLib->disconnect();

											$mes = "Сервер включен! <br>";
												$mes .= "Query данные <br>";
												$mes .= "Название сервера: ".$QueryGameServer['hostname']." <br>";
												$mes .= "Карта на сервере: ".$QueryGameServer['mapname']." <br>";
												$mes .= "Игроков на сервере: ".$QueryGameServer['players']." <br>";
											$mes .= "<br>";
												$mes .= "Ресурсы сервера <br>";
												$mes .= "CPU: ".$gameServer['server_cpu_load']."% <br>";
												$mes .= "RAM: ".$gameServer['server_ram_load']."% <br>";
										} elseif($gameServer['server_status'] == 3) {
											$mes = "Сервер устанавливается";
										} elseif($gameServer['server_status'] == 4) {
											$mes = "Сервер переустанавливается";
										} else {
											$mes = "Ошибка!";
										}
									} else {
										$mes = "У вас нет доступа к данному серверу!";
									}
								} else {
									$mes = "Ошибка парсинга ID сервера! [/status ID]";
								}
							} else {
								$mes = 'Вы должны быть зарегистрированы на нашем сайте, и привязать учётную запись VK!';
							}
							break;
						}
						case mb_strtolower(explode(' ', $message)[0], 'UTF-8') == '/start': {
							if($users['user_vk_id'] ==	$userId){	
								if (explode(' ', $message)[1]) {
									$gameid = (int)explode(' ', $message)[1];
									if($this->serversModel->getTotalServers(array('server_id' => $gameid, 'user_id' => $users['user_id']))) {
										$gameServer = $this->serversModel->getServerById($gameid);
										if($gameServer['server_status'] == 1) {
											$result = $this->serversModel->execServerAction($gameid, 'start');
											if($result['status'] == "OK") {
												$this->serversModel->updateServer($gameid, array('server_status' => 2));

												$mes = "Вы успешно запустили сервер!";
											} else {
												$mes = $result['description'];
											}
										} else {
											$mes = "Сервер должен быть выключен!";
										}
									} else {
										$mes = "У вас нет доступа к данному серверу!";
									}
								} else {
									$mes = "Ошибка парсинга ID сервера! [/status ID]";
								}
							} else {
								$mes = 'Вы должны быть зарегистрированы на нашем сайте, и привязать учётную запись VK!';
							}
							break;
						}
						case mb_strtolower(explode(' ', $message)[0], 'UTF-8') == '/stop': {
							if($users['user_vk_id'] ==	$userId){	
								if (explode(' ', $message)[1]) {
									$gameid = (int)explode(' ', $message)[1];
									if($this->serversModel->getTotalServers(array('server_id' => $gameid, 'user_id' => $users['user_id']))) {
										$gameServer = $this->serversModel->getServerById($gameid);
										if($gameServer['server_status'] == 2) {
											$result = $this->serversModel->execServerAction($gameid, 'stop');
											if($result['status'] == "OK") {
												$this->serversModel->updateServer($gameid, array('server_status' => 1));

												$mes = "Вы успешно выключили сервер!";
											} else {
												$mes = $result['description'];
											}
										} else {
											$mes = "Сервер должен быть включен!";
										}
									} else {
										$mes = "У вас нет доступа к данному серверу!";
									}
								} else {
									$mes = "Ошибка парсинга ID сервера! [/status ID]";
								}
							} else {
								$mes = 'Вы должны быть зарегистрированы на нашем сайте, и привязать учётную запись VK!';
							}
							break;
						}
						case mb_strtolower(explode(' ', $message)[0], 'UTF-8') == '/restart': {
							if($users['user_vk_id'] ==	$userId){	
								if (explode(' ', $message)[1]) {
									$gameid = (int)explode(' ', $message)[1];
									if($this->serversModel->getTotalServers(array('server_id' => $gameid, 'user_id' => $users['user_id']))) {
										$gameServer = $this->serversModel->getServerById($gameid);
										if($gameServer['server_status'] == 2) {
											$result = $this->serversModel->execServerAction($gameid, 'restart');
											if($result['status'] == "OK") {
												$this->serversModel->updateServer($gameid, array('server_status' => 2));

												$mes = "Вы успешно перезапустили сервер!";
											} else {
												$mes = $result['description'];
											}
										} else {
											$mes = "Сервер должен быть включен!";
										}
									} else {
										$mes = "У вас нет доступа к данному серверу!";
									}
								} else {
									$mes = "Ошибка парсинга ID сервера! [/status ID]";
								}
							} else {
								$mes = 'Вы должны быть зарегистрированы на нашем сайте, и привязать учётную запись VK!';
							}
							break;
						}
						case mb_strtolower(explode(' ', $message)[0], 'UTF-8') == '/gservers': {
							if($users['user_vk_id'] ==	$userId){	
								$gameServers = $this->serversModel->getServers(array('user_id' => $users['user_id']), array('games', 'locations'));
								if(!empty($gameServers)){
									foreach ($gameServers as $item) {	
										$gameServersList .= "<br> ID ".$item['server_id']." Игра ".$item['game_name']." IP:PORT ".$item['location_ip'].":".$item['server_port'];
									}
									$mes = "Список ваших игровых серверов <br>".$gameServersList;
								} else {
									$mes = "На данный момент у вас нет game серверов.";
								}
							} else {
								$mes = 'Вы должны быть зарегистрированы на нашем сайте, и привязать учётную запись VK!';
							}
							break;
						}
					}

					$request_params = array(
						'message' => $mes,
						'user_id' => $userId,
						'access_token' => $token,
						'v' => '5.0'
					);

					$get_params = http_build_query($request_params);
					file_get_contents('https://api.vk.com/method/messages.send?'.$get_params);
					
					echo('ok');
				break;
			}
		}
	}
}
?>
