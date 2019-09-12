<?php
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
class promosModel extends Model {
	public function createPromo($data) {
		$sql = "INSERT INTO `promo` SET ";
		$sql .= "cod = '" . $this->db->escape($data['cod']) . "', ";
		$sql .= "uses = '" . (int)$data['uses'] . "', ";
		$sql .= "used = '" . (int)$data['used'] . "', ";
		$sql .= "skidka = '" . (int)$data['skidka'] . "' ";
		$this->db->query($sql);
		
		return $this->db->getLastId();
	}
	
	public function deletepromo($promoid) {
		$sql = "DELETE FROM `promo` WHERE id = '" . (int)$promoid . "'";
		$this->db->query($sql);
	}
	
	public function updatepromo($promoid, $data = array()) {
		$sql = "UPDATE `promo`";
		if(!empty($data)) {
			$count = count($data);
			$sql .= " SET";
			foreach($data as $key => $value) {
				$sql .= " $key = '" . $this->db->escape($value) . "'";
				
				$count--;
				if($count > 0) $sql .= ",";
			}
		}
		$sql .= " WHERE `id` = '" . (int)$promoid . "'";
		$query = $this->db->query($sql);
		return true;
	}
	
	public function getpromo($data = array(), $sort = array(), $options = array()) {
		$sql = "SELECT * FROM `promo`";
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
	
	public function getpromoById($promoid) {
		$sql = "SELECT * FROM `promo` WHERE `id` = '" . (int)$promoid . "' LIMIT 1";
		$query = $this->db->query($sql);
		return $query->row;
	}
	
	public function getTotalpromo($data = array()) {
		$sql = "SELECT COUNT(*) AS count FROM `promo`";
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
