<?php
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
class serversOwnersModel extends Model {
	public function createOwner($data) {
		$sql = "INSERT INTO `servers_owners` SET ";
		$sql .= "server_id = '" . $data['server_id'] . "', ";
		$sql .= "user_id = '" . $data['user_id'] . "', ";
		$sql .= "owner_status = '" . $data['owner_status'] . "', ";
		$sql .= "owner_add = NOW()";
		$this->db->query($sql);
		
		return $this->db->getLastId();
	}
	
	public function deleteOwner($ownerid) {
		$this->db->query("DELETE FROM `servers_owners` WHERE owner_id = '".(int)$ownerid."'");
		
		return true;
	}
	
	public function updateOwner($ownerid, $data = array()) {
		$sql = "UPDATE `servers_owners`";
		if(!empty($data)) {
			$count = count($data);
			$sql .= " SET";
			foreach($data as $key => $value) {
				$sql .= " $key = '" . $this->db->escape($value) . "'";
				
				$count--;
				if($count > 0) $sql .= ",";
			}
		}
		$sql .= " WHERE `owner_id` = '" . (int)$ownerid . "'";
		$query = $this->db->query($sql);
		
		return true;
	}

	public function getOwners($data = array(), $joins = array(), $sort = array(), $options = array()) {
		$sql = "SELECT * FROM `servers_owners`";
		foreach($joins as $join) {
			$sql .= " LEFT JOIN $join";
			switch($join) {
				case "users":
					$sql .= " ON servers_owners.user_id=users.user_id";
					break;
				case "servers":
					$sql .= " ON servers_owners.server_id=servers.server_id";
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
	
	public function getOwnerById($ownerid) {
		$query = $this->db->query("SELECT * FROM `servers_owners` WHERE `owner_id` = '".(int)$ownerid."'  LIMIT 1");
		
		return $query->row;
	}
	
	public function getTotalOwners($data = array()) {
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
}
?>
