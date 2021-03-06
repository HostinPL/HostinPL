<?php
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
class locationsModel extends Model {
	public function createLocation($data) {
		$sql = "INSERT INTO `locations` SET ";
		$sql .= "location_name = '" . $this->db->escape($data['location_name']) . "', ";
		$sql .= "location_ip = '" . $this->db->escape($data['location_ip']) . "', ";
		$sql .= "location_ip2 = '" . $this->db->escape($data['location_ip2']) . "', ";
		$sql .= "location_user = '" . $this->db->escape($data['location_user']) . "', ";
		$sql .= "location_password = '" . $this->db->escape($data['location_password']) . "', ";
		$sql .= "location_status = '" . (int)$data['location_status'] . "'";
		$this->db->query($sql);
		return $this->db->getLastId();
	}
	
	public function deleteLocation($locationid) {
		$sql = "DELETE FROM `locations` WHERE location_id = '" . (int)$locationid . "'";
		$this->db->query($sql);
	}
	
	public function updateLocation($locationid, $data = array()) {
		$sql = "UPDATE `locations`";
		if(!empty($data)) {
			$count = count($data);
			$sql .= " SET";
			foreach($data as $key => $value) {
				$sql .= " $key = '" . $this->db->escape($value) . "'";
				
				$count--;
				if($count > 0) $sql .= ",";
			}
		}
		$sql .= " WHERE `location_id` = '" . (int)$locationid . "'";
		$query = $this->db->query($sql);
		return true;
	}
	
	public function getLocations($data = array(), $sort = array(), $options = array()) {
		$sql = "SELECT * FROM `locations`";
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
	
	public function getLocationById($locationid) {
		$sql = "SELECT * FROM `locations` WHERE `location_id` = '" . (int)$locationid . "' LIMIT 1";
		$query = $this->db->query($sql);
		return $query->row;
	}
	
	public function getTotalLocations($data = array()) {
		$sql = "SELECT COUNT(*) AS count FROM `locations`";
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
	public function getSystemLoad($locationid) {
		$this->load->library('ssh2');
		$this->load->model('locations');
		$location = $this->locationsModel->getLocationById($locationid);
		
		$ssh2Lib = new ssh2Library();
		$link = $ssh2Lib->connect($location['location_ip'], $location['location_user'], $location['location_password']);

		$cpu = $ssh2Lib->execute($link, "ps aux | awk '{s += $3} END {print s }'");	
		$output['cpu'] = $cpu;

		$ram = $ssh2Lib->execute($link, "ps aux | awk '{s += $4} END {print s}'");
		$output['ram'] = $ram;
		
		$hdd = $ssh2Lib->execute($link, "du -sh /home/ | tail -1 | sed 's/[^0-9]//g'");
		$output['hdd'] = $hdd;
		
		$hddold = $ssh2Lib->execute($link, "df -lh / | awk '{print $2}' | sed 's/[^0-9]//g'");
		$output['hddold'] = $hddold;
		
		$uptime = $ssh2Lib->execute($link, "cat /proc/uptime");
		$days = sprintf( "%2d", ($uptime/(3600*24)) );
		$output['uptime'] = $days;

		$ssh2Lib->disconnect($link);
		
		$this->load->library('query');
		$this->load->model('servers');
		$servers = $this->serversModel->getServers(array(), array('games', 'locations'));
		
		foreach($servers as $item) {
			if($item['server_status'] == 2) {
				$queryLib = new queryLibrary($item['game_query']);
				$queryLib->connect($item['location_ip'], $item['server_port']);
				$query = $queryLib->getInfo();
				$queryLib->disconnect();
				
				$players += $query['players'];
				
				$output['players'] = $players;
			}
		}
		return $output;
	}
}
?>
