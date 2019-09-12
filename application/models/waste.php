<?php
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
class wasteModel extends Model {
	public function createWaste($data) {
		$sql = "INSERT INTO `waste` SET ";
		$sql .= "user_id = '" . (int)$data['user_id'] . "', ";
		$sql .= "waste_ammount = '" . (float)$data['waste_ammount'] . "', ";
		$sql .= "waste_status = '" . (int)$data['waste_status'] . "', ";
		$sql .= "waste_usluga = '" . $this->db->escape($data['waste_usluga']) . "', ";
		$sql .= "waste_date_add = NOW()";
		$this->db->query($sql);
		return $this->db->getLastId();
	}
	
	public function deleteWaste($wasteid) {
		$sql = "DELETE FROM `waste` WHERE waste_id = '" . (int)$wasteid . "'";
		$this->db->query($sql);
	}
	
	public function updateWaste($wasteid, $data = array()) {
		$sql = "UPDATE `waste`";
		if(!empty($data)) {
			$count = count($data);
			$sql .= " SET";
			foreach($data as $key => $value) {
				$sql .= " $key = '" . $this->db->escape($value) . "'";
				
				$count--;
				if($count > 0) $sql .= ",";
			}
		}
		$sql .= " WHERE `waste_id` = '" . (int)$wasteid . "'";
		$query = $this->db->query($sql);
		return true;
	}
	
	public function getWaste($data = array(), $joins = array(), $sort = array(), $options = array()) {
		$sql = "SELECT * FROM `waste`";
		foreach($joins as $join) {
			$sql .= " LEFT JOIN $join";
			switch($join) {
				case "users":
					$sql .= " ON waste.user_id=users.user_id";
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
	
	public function getWasteById($wasteid, $joins = array()) {
		$sql = "SELECT * FROM `waste`";
		foreach($joins as $join) {
			$sql .= " LEFT JOIN $join";
			switch($join) {
				case "users":
					$sql .= " ON waste.user_id=users.user_id";
					break;
			}
		}
		$sql .=  " WHERE `waste_id` = '" . (int)$wasteid . "' LIMIT 1";
		$query = $this->db->query($sql);
		return $query->row;
	}
	
	public function getTotalWaste($data = array()) {
		$sql = "SELECT COUNT(*) AS count FROM `waste`";
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
