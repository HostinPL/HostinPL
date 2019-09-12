<?php
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
class adapsModel extends Model {
	public function createAdap($data) {
		
		$sql = "INSERT INTO `servers_adap` SET ";
		$sql .= "`game_id` = '" . (int)$data['game_id'] . "', ";
		$sql .= "`adap_act` = '" . (int)$data['adap_act'] . "', ";
		$sql .= "`adap_status` = '" . (int)$data['adap_status'] . "', ";
		$sql .= "`adap_url` = '" . $data['adap_url'] . "', ";
		$sql .= "`adap_name` = '" . $data['adap_name'] . "', ";
		$sql .= "`adap_action` = '" . $data['adap_action'] . "', ";
		$sql .= "`adap_textx` = '" . strip_tags(htmlspecialchars_decode($this->db->escape($data['adap_textx'])), '<img><span><ul><ol><pre><li><div><em><strong><sup><code>') . "', ";
		$sql .= "`adap_img` = '" . $data['adap_img'] . "', ";
		$sql .= "`adap_patch` = '" . $data['adap_patch'] . "', ";
		$sql .= "`adap_arch` = '" . $data['adap_arch'] . "', ";
		$sql .= "`adap_price` = '" . $data['adap_price'] . "', ";
		$sql .= "`adap_category` = '" . $data['adap_category'] . "'";
		$this->db->query($sql);
		$return=$this->db->getLastId();		
		return $return;
	}


	public function deleteAdap($adapid) {
		$sql = "DELETE FROM `servers_adap` WHERE adap_id = '" . (int)$adapid . "'";
		$this->db->query($sql);
	}
	
	public function blockAdap($adapid) {
		$sql = "DELETE FROM `servers_adap` WHERE adap_id = '" . (int)$adapid . "'";
		$this->db->query($sql);
	}
	
	public function updateAdap($adapid, $data = array()) {
		$sql = "UPDATE `servers_adap`";
		if(!empty($data)) {
			$count = count($data);
			$sql .= " SET";
			foreach($data as $key => $value) {
				$sql .= " $key = '" . $this->db->escape($value) . "'";
				
				$count--;
				if($count > 0) $sql .= ",";
			}
		}
		$sql .= " WHERE `adap_id` = '" . (int)$adapid . "'";
		$query = $this->db->query($sql);
	}
	public function getAdaps($data = array(), $joins = array(),$sort = array(), $options = array()) {
		$sql = "SELECT * FROM `servers_adap`";
		foreach($joins as $join) {
			$sql .= " LEFT JOIN $join";
			switch($join) {
				case "games":
					$sql .= " ON servers_adap.game_id=games.game_id";
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
	 
	public function getAdapById($adapid, $joins = array()) {
		$sql = "SELECT * FROM `servers_adap`";
		foreach($joins as $join) {
			$sql .= " LEFT JOIN $join";
			switch($join) {
				case "games":
					$sql .= " ON servers_adap.game_id=games.game_id";
					break;
			}
		}
		$sql .=  " WHERE `adap_id` = '" . (int)$adapid . "' LIMIT 1";
		$query = $this->db->query($sql);
		return $query->row;
	}
	
	public function getTotalAdaps($data = array()) {
		$sql = "SELECT COUNT(*) AS count FROM `servers_adap`";
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
