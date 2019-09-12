<?php
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
class serversModel extends Model {
	public function createServer($data) {
		
		$sql = "INSERT INTO `servers` SET ";
		$sql .= "`user_id` = '" . (int)$data['user_id'] . "', ";
		$sql .= "`game_id` = '" . (int)$data['game_id'] . "', ";
		$sql .= "`location_id` = '" . (int)$data['location_id'] . "', ";
		$sql .= "`server_mysql` = '0', ";
		$sql .= "`server_slots` = '" . (int)$data['server_slots'] . "', ";
		$sql .= "`server_port` = '" . (int)$data['server_port'] . "', ";
		$sql .= "`server_password` = '" . $this->db->escape($data['server_password']) . "', ";
		$sql .= "`server_status` = '" . (int)$data['server_status'] . "', ";
		$sql .= "server_date_reg = NOW(), ";
		
		if($data['test_periud'] == false){
            $sql .= "server_date_end = NOW() + INTERVAL " . (int)$data['server_months'] . " MONTH";
		} 
		elseif($data['test_periud'] == true) {
			$sql .= "`server_date_end` = NOW() + INTERVAL 3 DAY";
			$ss = mysql_query("UPDATE `users` SET `test_server` = '2' WHERE `user_id` = '{$this->user->getId()}'");
		}
		$this->db->query($sql);
		$return=$this->db->getLastId();		
		return $return;
	}

	public function createMySQL($serverid) {  
    $chars="qazxswedcvfrtgbnhyujmkiolp1234567890QAZXSWEDCVFRTGBNHYUJMKIOLP"; 
    $max=10; 
    $size=StrLen($chars)-1; 
    $dbpass=null; 
    while($max--) 
    $dbpass.=$chars[rand(0,$size)]; 
    $sql = "create database gs".$serverid;
	$this->db->query($sql);
	$sql = "grant usage on *.* to gs".$serverid."@'%' identified by '" . $dbpass."'";
	$this->db->query($sql);
	$sql = "grant all privileges on gs".$serverid.".* to gs".$serverid."@'%'";
	$this->db->query($sql);	
	$sql = "UPDATE `servers` SET db_pass = '" . $dbpass."' WHERE server_id = '" . (int)$serverid . "'";
	$this->db->query($sql);
	$return=$this->db->getLastId();
	return $return;
	}
	
	public function promisedServer($serverid) {		
		$this->db->query("UPDATE `servers` SET server_date_end = server_date_end +INTERVAL 3 DAY WHERE server_id = '" . (int)$serverid . "'");
		
		$this->updateServer($serverid, array('server_status' => 1));
		return true;
	}
	
	public function deleteServer($serverid) {
		$sql = "DELETE FROM `servers` WHERE server_id = '" . (int)$serverid . "'";
		$this->db->query($sql);
	}
	
	public function blockServer($serverid) {
		$sql = "DELETE FROM `servers` WHERE server_id = '" . (int)$serverid . "'";
		$this->db->query($sql);
	}
	
	public function updateServer($serverid, $data = array()) {
		if(!empty($data['db_pass'])){
			$sql="UPDATE mysql.user SET Password=PASSWORD('".$data['db_pass']."') WHERE User='gs".$serverid."'";
			$this->db->query($sql);
			$sql="FLUSH PRIVILEGES;";
			$this->db->query($sql);
		}
		$sql = "UPDATE `servers`";
		if(!empty($data)) {
			$count = count($data);
			$sql .= " SET";
			foreach($data as $key => $value) {
				$sql .= " $key = '" . $this->db->escape($value) . "'";
				
				$count--;
				if($count > 0) $sql .= ",";
			}
		}
		$sql .= " WHERE `server_id` = '" . (int)$serverid . "'";
		$query = $this->db->query($sql);
	}
	
	public function getServers($data = array(), $joins = array(), $sort = array(), $options = array()) {
		$sql = "SELECT * FROM `servers`";
		foreach($joins as $join) {
			$sql .= " LEFT JOIN $join";
			switch($join) {
				case "users":
					$sql .= " ON servers.user_id=users.user_id";
					break;
				case "games":
					$sql .= " ON servers.game_id=games.game_id";
					break;
				case "locations":
					$sql .= " ON servers.location_id=locations.location_id";
					break;
			}
		}
		
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
			if ($options['start'] < 0) {
				$options['start'] = 0;
			}
			if ($options['limit'] < 1) {
				$options['limit'] = 20;
			}
			$sql .= " LIMIT " . (int)$options['start'] . "," . (int)$options['limit'];
		}
		$query = $this->db->query($sql);
		return $query->rows;
	}
	
	public function getServerById($serverid, $joins = array()) {
		$sql = "SELECT * FROM `servers`";
		foreach($joins as $join) {
			$sql .= " LEFT JOIN $join";
			switch($join) {
				case "users":
					$sql .= " ON servers.user_id=users.user_id";
					break;
				case "games":
					$sql .= " ON servers.game_id=games.game_id";
					break;
				case "locations":
					$sql .= " ON servers.location_id=locations.location_id";
					break;
			}
		}
		$sql .=  " WHERE `server_id` = '" . (int)$serverid . "' LIMIT 1";
		$query = $this->db->query($sql);
		return $query->row;
	}
	
	public function getTotalServerOwners($data = array()) {
		$sql = "SELECT COUNT(*) AS count FROM `servers_owners`";
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
	
	public function getTotalServers($data = array()) {
		$sql = "SELECT COUNT(*) AS count FROM `servers`";
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

	public function getServerNewPort($locationid, $min, $max) {
		for($i = $min; $i < $max; $i += 2) {
			$sql = "SELECT COUNT(*) AS total FROM `servers` WHERE location_id = '" . (int)$locationid . "' AND server_port = '" . (int)$i . "' LIMIT 1";
			$query = $this->db->query($sql);
			if($query->row['total'] == 0) {
				return $i;
			}
		}
		return null;
	}
	
	public function getGameServerPortList($locationid, $min, $max) {		
		for($i = $min; $i < $max; $i += 2) {
			$query = $this->db->query("SELECT COUNT(*) AS count FROM `servers` WHERE location_id = '" . (int)$locationid . "' AND server_port = '" . (int)$i . "'");
			if(!$query->row['count']) {
				$ports[] = $i;
			}
		}
		
		return $ports;
	}
	
	public function getServerSystemLoad($serverid) {

		$this->load->library('ssh2');
		
		$ssh2Lib = new ssh2Library();
		
		$server = $this->getServerById($serverid, array('users', 'locations', 'games'));
		$link = $ssh2Lib->connect($server['location_ip'], $server['location_user'], $server['location_password']);

		$cpu = $ssh2Lib->execute($link, "ps u -U gs".$server['server_id']." | awk '{print $3}'");
		$cpu = explode("\n",$cpu);		
		$cpu = preg_replace('~[^0-9/.]+~','',$cpu); 
		$output['cpu'] = 0.0;
		if($cpu) {
			foreach ($cpu as $item) {
				$output['cpu'] += $item;
			}
		} else {
			$output['cpu'] = 0.0;
		}		
				
		$ram = $ssh2Lib->execute($link, "ps u -U gs".$server['server_id']." | awk '{print $4}'");
		$ram = explode("\n",$ram);		
		$ram = preg_replace('~[^0-9/.]+~','',$ram); 
		$output['ram'] = 0.0;
		if($ram) {
			foreach ($ram as $item) {
				$output['ram'] += $item;
			}
		}		
		
		$ssh2Lib->disconnect($link);
		return $output;
	}	

	
	public function getHDD($serverid) {

		$this->load->library('ssh2');
		
		$ssh2Lib = new ssh2Library();
		
		$server = $this->getServerById($serverid, array('users', 'locations', 'games'));
		$link = $ssh2Lib->connect($server['location_ip'], $server['location_user'], $server['location_password']);
		$output = (int)$ssh2Lib->execute($link, "du -scm /home/gs".$server['server_id']." | tail -1 | sed 's/[^0-9]//g'");
		
		$ssh2Lib->disconnect($link);
		return $output;
	}	
	
	public function extendServer($serverid, $month, $fromCurrent) {
		$sql = "UPDATE `servers` SET server_date_end = ";
		if($fromCurrent)
			$sql .= "NOW()";
		else
			$sql .= "server_date_end";
		$sql .= "+INTERVAL " . (int)$month . " MONTH WHERE server_id = '" . (int)$serverid . "'";
		
		$this->db->query($sql);
	}
	
	public function slotsServer($serverid, $slots) {
		$sql = "UPDATE `servers` SET server_slots = '" . (int)$slots . "' WHERE server_id = '" . (int)$serverid . "'";		
		$this->db->query($sql);
	}
	
	public function execServerAction($serverid, $action) {
		$this->load->library('ssh2');
		
		$ssh2Lib = new ssh2Library();
		
		$server = $this->getServerById($serverid, array('users', 'locations', 'games'));
		$link = $ssh2Lib->connect($server['location_ip'], $server['location_user'], $server['location_password']);
		$output = $ssh2Lib->execute($link, "/home/cp/gameservers.py $action $server[server_id] $server[game_code] $server[location_ip] $server[server_port] $server[server_slots] $server[server_password]");
		if(preg_match("/\[\[(.*)::(.*)?\]\]/", $output, $matches)) {
			$result['status'] = $matches[1];
			$result['description'] = $matches[2];
		} else {
			$result['status'] = "ERROR";
			$result['description'] = "å èçâåñòíàß îøèáêà.";
		}
		$ssh2Lib->disconnect($link);
		switch($action){
		case 'install': {						$this->serversModel->updateServer($serverid, array(
					'server_install' => 1
				));	}
		case 'reinstall': {						$this->serversModel->updateServer($serverid, array(
					'server_install' => 1
				));	}
		}
		return $result;
		/*
		„ëß òåñòèðîâàíèß áåç ñåðâåðîíîé ÷àñòè:
		return array('status' => 'OK', 'description' => '');
		*/
	}
}
?>
