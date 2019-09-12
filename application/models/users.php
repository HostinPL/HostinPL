<?php
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
class usersModel extends Model {
	public function createUser($data) {
		$sql = "INSERT INTO `users` SET ";
		$sql .= "user_email = '" . $this->db->escape($data['user_email']) . "', ";
		$sql .= "user_password = '" . $this->db->escape($data['user_password']) . "', ";
		$sql .= "user_firstname = '" . $this->db->escape($data['user_firstname']) . "', ";
		$sql .= "user_lastname = '" . $this->db->escape($data['user_lastname']) . "', ";
		$sql .= "user_status = '" . (int)$data['user_status'] . "', ";
		$sql .= "user_balance = '" . (float)$data['user_balance'] . "', ";
		$sql .= "user_access_level = '" . (int)$data['user_access_level'] . "', ";
		$sql .= "ref = '" . (int)$data['ref'] . "', ";
		$sql .= "rmoney = '" . (float)$data['rmoney'] . "', ";
		
		$sql .= "user_activate = '" . (int)$data['user_activate'] . "', ";
		$sql .= "key_activate = '" . $data['key_activate'] . "', ";
		
		$sql .= "user_date_reg = NOW()";
		$this->db->query($sql);
		return $this->db->getLastId();
	}
	
	//Ключь активации акаунта в процессе регистрации
	public function getUserByKey($key) {
		$sql = "SELECT * FROM `users` WHERE `key_activate` = '" . $this->db->escape($key) . "' LIMIT 1";
		$query = $this->db->query($sql);
		return $query->row;
	}	
	
	public function deleteTicketMessage($userid) {
		$sql = "DELETE FROM `users` WHERE user_id = '" . (int)$userid . "'";
		$this->db->query($sql);
	}
	
	public function updateUser($userid, $data = array()) {
		$sql = "UPDATE `users`";
		if(!empty($data)) {
			$count = count($data);
			$sql .= " SET";
			foreach($data as $key => $value) {
				$sql .= " $key = '" . $this->db->escape($value) . "'";
				
				$count--;
				if($count > 0) $sql .= ",";
			}
		}
		$sql .= " WHERE `user_id` = '" . (int)$userid . "'";
		$query = $this->db->query($sql);
		return true;
	}
	
	public function getUsers($data = array(), $sort = array(), $options = array()) {
		$sql = "SELECT * FROM `users`";
		if(!empty($data)) {
			$count = count($data);
			$sql .= " WHERE";
			foreach($data as $key => $value) {
				$sql .= " $key = '" . $this->db->escape($value) . "'";
				
				$count--;
				if($count > 0) $sql .= " AND";
			}
		}
		
		if(!empty($sort)) {
			$count = count($sort);
			$sql .= " ORDER BY";
			foreach($sort as $key => $value) {
				$sql .= " $key " . $value;
				
				$count--;
				if($count > 0) $sql .= ",";
			}
		}
		
		if(!empty($options)) {
			if($options['start'] < 0) {
				$options['start'] = 0;
			}
			if($options['limit'] < 1) {
				$options['limit'] = 20;
			}
			$sql .= " LIMIT " . (int)$options['start'] . "," . (int)$options['limit'];
		}
		$query = $this->db->query($sql);
		return $query->rows;
	}
	
	public function getUserById($userid) {
		$sql = "SELECT * FROM `users` WHERE `user_id` = '" . (int)$userid . "' LIMIT 1";
		$query = $this->db->query($sql);
		return $query->row;
	}
	
	public function getUserByEmail($useremail) {
		$sql = "SELECT * FROM `users` WHERE `user_email` = '" . $this->db->escape($useremail) . "' LIMIT 1";
		$query = $this->db->query($sql);
		return $query->row;
	}
	
	public function getTotalUsers($data = array()) {
		$sql = "SELECT COUNT(*) AS count FROM `users`";
		if(!empty($data)) {
			$count = count($data);
			$sql .= " WHERE";
			foreach($data as $key => $value) {
				$sql .= " $key = '" . $this->db->escape($value) . "'";
				
				$count--;
				if($count > 0) $sql .= " AND";
			}
		}
		$query = $this->db->query($sql);
		return $query->row['count'];
	}
	
	public function upUserBalance($userid, $value) {
	  	$query = $this->db->query("UPDATE `users` SET user_balance = user_balance+" . (float)$value . " WHERE user_id = '" . (int)$userid . "'");
	}
	public function upUserRMoney($userid, $value) {
	  	$query = $this->db->query("UPDATE `users` SET rmoney = rmoney+" . (float)$value . " WHERE user_id = '" . (int)$userid . "'");
	}
	public function downUserRMoney($userid, $value) {
	  	$query = $this->db->query("UPDATE `users` SET rmoney = rmoney-" . (float)$value . " WHERE user_id = '" . (int)$userid . "'");
	}
	public function downUserBalance($userid, $value) {
	  	$query = $this->db->query("UPDATE `users` SET user_balance = user_balance-" . (float)$value . " WHERE user_id = '" . (int)$userid . "'");
	}
	public function createAuthLog($userid, $ip, $status, $password) {
		$ipDetail=array();
		$f = file_get_contents("http://api.2ip.ua/geo.xml?ip=".$ip);
		 
		//Получаем название города
		preg_match("@<city_rus>(.*?)</city_rus>@si", $f, $city);
		//$ipDetail['city'] = ($city AND $city[2]) ? $city[2] : ''; 
		 $ipDetail['city'] = $city[1];
		//Получаем название страны
		preg_match("@<country_rus>(.*?)</country_rus>@si", $f, $country);
		$ipDetail['country'] = $country[1];
		 
		//Получаем код страны
		preg_match("@<country_code>(.*?)</country_code>@si", $f, $countryCode);
		$ipDetail['countryCode'] = $countryCode[1];
		
	  	$query=$this->db->query("INSERT INTO `authlog` (`id`, `user`, `ip`, `city`, `country`, `code`, `datetime`, `status`, `password`) VALUES (NULL, '".$userid."', '".$ip."', '".$ipDetail['city']."', '".$ipDetail['country']."', '".$ipDetail['countryCode']."', NOW(), '".$status."', '".$password."');");
	}
	
	public function getAuthLog($userid) {
		$sql = "SELECT * FROM `authlog` WHERE `user` = '".(int)$userid."' ORDER BY(`id`) DESC LIMIT 20";
		$query = $this->db->query($sql);
		return $query->rows;
	}
	
	public function getIdByEmail($email) {
		$sql = "SELECT `user_id` FROM `users` WHERE `user_email` = '" . $this->db->escape($email) . "' LIMIT 1";
		$query = $this->db->query($sql);
		return $query->row;
	}
	
	public function getUserByUser_vk_id($user_vk_id) {
		$sql = "SELECT * FROM `users` WHERE `user_vk_id` = '" . (int)$user_vk_id . "' LIMIT 1";
		$query = $this->db->query($sql);
		return $query->row;
	}
	
	public function getSkidkaByCode($code, $rewrite) {
		$sql = "SELECT `skidka` FROM `promo` WHERE `cod` = '" . $this->db->escape($code) . "' AND `used` < `uses` LIMIT 1";
		$query = $this->db->query($sql);
		
		if($rewrite == true){
			$zapros = $this->db->query("UPDATE `promo` SET `used`= `used`+1 WHERE `cod` = '" . $this->db->escape($code) . "' AND `used` < `uses` LIMIT 1");
		}
		return $query->row;
	}
	
	public function getStatisticsRegistersById() {
        $sql = "SELECT count(user_id), DATE(`user_date_reg`) mydate FROM users GROUP BY mydate;";
        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function deleteUser($user_id) {
		$sql = "DELETE FROM `users` WHERE user_id = '" . (int)$user_id . "'";
		$this->db->query($sql);
	}
	
	// $message = "Связь с локацией ".$item['location_name']." - ".$item['location_ip']." востановлена!";
	// $this->usersModel->sendInfo(array(), $message, true);	
	
	public function sendInfo($userid, $message, $metod) {	
		if($this->config->VK_bot == 1) {
			//Отправка только администраторам
			if($metod == true){	
				$users = $this->usersModel->getUsers();
				foreach($users as $item) {
					//Проверяем лвл аккаунта
					if($item['user_access_level'] == 3) {
						//Включены ли уведомления
						// if($item['user_notifications_vk'] == 1) {
							//Проверка на привязку вк
							if(empty($item['user_vk_id'])){
								//Если не задан userid
							} else {
								$userId = $item['user_vk_id'];
								//Данные из конфига
								$token = $this->config->VK_token;
								//Узнаём данные пользователя по его userid
								$userInfo = json_decode(file_get_contents("https://api.vk.com/method/users.get?user_ids={$userId}&v=5.0"));
								//извлекаем из ответа его имя
								$user_name = $userInfo->response[0]->first_name;
								//Текст сообщения 
								$mes = 'Здравствуйе '.$user_name.'! У вас есть новое уведомление от Zon.su <br>'.$message.'';
								//Массив данных
								$request_params = array(
									'message' => $mes,
									'user_id' => $userId,
									'access_token' => $token,
									'v' => '5.0'
								);
								//Билд в http
								$get_params = http_build_query($request_params);
								//Отправка  
								file_get_contents('https://api.vk.com/method/messages.send?' . $get_params);
								
							}
						// }
					}
				}
			//Отправка только на userid
			} else {
				//Узнаём данные о пользователе из его userId		
				$user = $this->usersModel->getUserById($userid);
				//Выгружаем массив
				unset($userid);
				
				$userId = $user['user_vk_id'];
				//Проверка на привязку вк
				if(empty($userId)){
					//Если не задан userid
				} else {
					//Включены ли уведомления
					// if($user['user_notifications_vk'] == 1) {
						//Данные из конфига
						$token = $this->config->VK_token;
						//Узнаём данные пользователя по его userid
						$userInfo = json_decode(file_get_contents("https://api.vk.com/method/users.get?user_ids={$userId}&v=5.0"));
						//извлекаем из ответа его имя
						$user_name = $userInfo->response[0]->first_name;
						//Текст сообщения 
						$mes = 'Здравствуйе '.$user_name.'! У вас есть новое уведомление от Zon.su '.$message.'';
						//Массив данных
						$request_params = array(
							'message' => $mes,
							'user_id' => $userId,
							'access_token' => $token,
							'v' => '5.0'
						);
						//Билд в http
						$get_params = http_build_query($request_params);
						//Отправка  
						file_get_contents('https://api.vk.com/method/messages.send?' . $get_params);
					// }
				}
			}
		}
	}
}
?>
