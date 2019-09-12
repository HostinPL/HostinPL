<?php
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
class ticketsCategoryModel extends Model {

	public function createTicketCategory($data) {
		$sql = "INSERT INTO `tickets_category` SET ";
		$sql .= "category_name = '" . $this->db->escape($data['category_name']) . "', ";
		$sql .= "category_status = '" . (int)$data['category_status'] . "' ";
		$this->db->query($sql);
		return $this->db->getLastId();
	}
	
	public function deleteTicketCategory($categoryid) {
		$sql = "DELETE FROM `tickets_category` WHERE category_id = '" . (int)$categoryid . "'";
		$this->db->query($sql);
	}
	
	public function updateTicketCategory($categoryid, $data = array()) {
		$sql = "UPDATE `tickets_category`";
		if(!empty($data)) {
			$count = count($data);
			$sql .= " SET";
			foreach($data as $key => $value) {
				$sql .= " $key = '" . $this->db->escape($value) . "'";
				
				$count--;
				if($count > 0) $sql .= ",";
			}
		}
		$sql .= " WHERE `category_id` = '" . (int)$categoryid . "'";
		$query = $this->db->query($sql);
		return true;
	}
	
	public function getTicketsCategory($data = array(), $joins = array(), $sort = array(), $options = array()) {
		$sql = "SELECT * FROM `tickets_category`";
		foreach($joins as $join) {
			$sql .= " LEFT JOIN $join";
			switch($join) {
				case "tickets":
					$sql .= " ON tickets_category.category_id=tickets.category_id";
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
	
		public function getTicketCategoryById($categoryid, $joins = array()) {
		$sql = "SELECT * FROM `tickets_category`";
		foreach($joins as $join) {
			$sql .= " LEFT JOIN $join";
			switch($join) {
				case "tickets":
					$sql .= " ON tickets_category.user_id=tickets.user_id";
					break;
			}
		}
		$sql .=  " WHERE `category_id` = '" . (int)$categoryid . "' LIMIT 1";
		$query = $this->db->query($sql);
		return $query->row;
	}
	public function getTotalTicketsCategory($data = array()) {
		$sql = "SELECT COUNT(*) AS count FROM `tickets_category`";
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
