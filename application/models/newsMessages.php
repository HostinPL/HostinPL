<?php
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
class newsMessagesModel extends Model {
	public function createNewsMessage($data) {
		$sql = "INSERT INTO `news_messages` SET ";
		$sql .= "news_id = '" . (int)$data['news_id'] . "', ";
		$sql .= "user_id = '" . (int)$data['user_id'] . "', ";
		$sql .= "news_message = '" . $this->db->escape($data['news_message']) . "', ";
		$sql .= "news_message_date_add = NOW()";
		$this->db->query($sql);
		return $this->db->getLastId();
	}
	
	public function deleteNewsMessage($messageid) {
		$sql = "DELETE FROM `news_messages` WHERE news_message_id = '" . (int)$messageid . "'";
		$this->db->query($sql);
	}
	
	public function updateNewsMessage($messageid, $data = array()) {
		$sql = "UPDATE `news_messages`";
		if(!empty($data)) {
			$count = count($data);
			$sql .= " SET";
			foreach($data as $key => $value) {
				$sql .= " $key = '" . $this->db->escape($value) . "'";
				
				$count--;
				if($count > 0) $sql .= ",";
			}
		}
		$sql .= " WHERE `news_message_id` = '" . (int)$messageid . "'";
		$query = $this->db->query($sql);
		return true;
	}
	
	public function getNewsMessages($data = array(), $joins = array(), $sort = array(), $options = array()) {
		$sql = "SELECT * FROM `news_messages`";
		foreach($joins as $join) {
			$sql .= " LEFT JOIN $join";
			switch($join) {
				case "users":
					$sql .= " ON news_messages.user_id=users.user_id";
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
	
	public function getNewsMessageById($messageid, $joins = array()) {
		$sql = "SELECT * FROM `news_messages`";
		foreach($joins as $join) {
			$sql .= " LEFT JOIN $join";
			switch($join) {
				case "users":
					$sql .= " ON news_messages.user_id=users.user_id";
					break;
			}
		}
		$sql .=  " WHERE `news_message_id` = '" . (int)$messageid . "' LIMIT 1";
		$query = $this->db->query($sql);
		return $query->row;
	}
	
	public function getTotalNewsMessages($data = array()) {
		$sql = "SELECT COUNT(*) AS count FROM `news_messages`";
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
