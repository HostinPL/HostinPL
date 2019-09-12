<?php
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
class serversFirewallsModel extends Model {
	public function createFirewall($data) {
		$sql = "INSERT INTO `servers_firewalls` SET ";
		$sql .= "server_id = '" . $data['server_id'] . "', ";
		$sql .= "server_ip = '" . $this->db->escape($data['server_ip']) . "', ";
		$sql .= "firewall_add = NOW()";
		$this->db->query($sql);
		
		return $this->db->getLastId();
	}
	
	public function deleteFirewallDB($firewallid) {
		$this->db->query("DELETE FROM `servers_firewalls` WHERE firewall_id = '".(int)$firewallid."'");
		
		return true;
	}
	
	public function addFirewall($firewallid) {		
		$this->load->library('ssh2');
		$this->load->model('servers');
		$Firewall = $this->getFirewallById($firewallid);
		$server = $this->serversModel->getServerById($Firewall['server_id'], array('locations'));
		
		$ssh2Lib = new ssh2Library();
		$link = $ssh2Lib->connect($server['location_ip'], $server['location_user'], $server['location_password']);
		
		$ssh2Lib->execute($link, "iptables -I INPUT -s ".$Firewall['server_ip']." -p udp -d ".$server['location_ip']." --dport ".$server['server_port']." -j DROP;");
		$ssh2Lib->execute($link, "iptables -I INPUT -s ".$Firewall['server_ip']." -p tcp -d ".$server['location_ip']." --dport ".$server['server_port']." -j DROP;");
		
		$ssh2Lib->disconnect($link);

		return true;
	}
	
	public function deleteFirewall($firewallid) {
		$this->load->library('ssh2');
		$this->load->model('servers');
		$Firewall = $this->getFirewallById($firewallid);
		$server = $this->serversModel->getServerById($Firewall['server_id'], array('locations'));
		
		$ssh2Lib = new ssh2Library();
		$link = $ssh2Lib->connect($server['location_ip'], $server['location_user'], $server['location_password']);
		
		$ssh2Lib->execute($link, "iptables -D INPUT -s ".$Firewall['server_ip']." -p udp -d ".$server['location_ip']." --dport ".$server['server_port']." -j DROP;");
		$ssh2Lib->execute($link, "iptables -D INPUT -s ".$Firewall['server_ip']." -p tcp -d ".$server['location_ip']." --dport ".$server['server_port']." -j DROP;");
		
		$ssh2Lib->disconnect($link);
		
		$this->deleteFirewallDB($firewallid);
		
		return true;
	}
	
	public function deleteFirewalls($serverfirewalls) {		
		$this->load->library('ssh2');
		$this->load->model('servers');
		$Firewalls = $this->getFirewallsById($serverfirewalls);
		$server = $this->serversModel->getServerById($Firewall['server_id'], array('locations'));
		
		$ssh2Lib = new ssh2Library();
		$link = $ssh2Lib->connect($server['location_ip'], $server['location_user'], $server['location_password']);
		
		foreach($Firewalls as $item) {
			$command .= "iptables -D INPUT -s ".$item['server_ip']." -p udp -d ".$server['location_ip']." --dport ".$server['server_port']." -j DROP;";
			$command .= "iptables -D INPUT -s ".$item['server_ip']." -p tcp -d ".$server['location_ip']." --dport ".$server['server_port']." -j DROP;";

			$this->deleteFirewallDB($item['firewall_id']);
		}	
		$ssh2Lib->execute($link, $command);
		
		$ssh2Lib->disconnect($link);
		
		return $result;
	}
	
	public function getFirewalls($data = array(), $sort = array(), $options = array()) {
		$sql = "SELECT * FROM `servers_firewalls`";
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
	
	public function getFirewallsById($firewallid) {
		$query = $this->db->query("SELECT * FROM `servers_firewalls` WHERE `server_id` = '".(int)$firewallid."'");
		
		return $query->rows;
	}
	
	public function getFirewallById($firewallid) {
		$query = $this->db->query("SELECT * FROM `servers_firewalls` WHERE `firewall_id` = '".(int)$firewallid."'  LIMIT 1");
		
		return $query->row;
	}
	
	public function getTotalFirewalls($data = array()) {
		$sql = "SELECT COUNT(*) AS count FROM `servers_firewalls`";
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
}
?>
