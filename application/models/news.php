<?php
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
class newsModel extends Model {
	public function createNews($data) {
		$sql = "INSERT INTO `news` SET ";
		$sql .= "user_id = '" . (int)$data['user_id'] . "', ";
		$sql .= "news_title = '" . $data['news_title'] . "', ";
		$sql .= "news_text = '" . $data['news_text'] . "', ";
		$sql .= "category_id = '" . $data['category_id'] . "', ";
		$sql .= "place = '" . $data['place'] . "', ";
		$sql .= "news_date_add = NOW()";
		$this->db->query($sql);
		return $this->db->getLastId();
	}

	public function deleteNews($newid) {
		$sql = "DELETE FROM `news` WHERE news_id = '" . (int)$newid . "'";
		$this->db->query($sql);
	}
	
	public function updateNews($newid, $data = array()) {
		$sql = "UPDATE `news`";
		if(!empty($data)) {
			$count = count($data);
			$sql .= " SET";
			foreach($data as $key => $value) {
				$sql .= " $key = '" . $this->db->escape($value) . "'";
				
				$count--;
				if($count > 0) $sql .= ",";
			}
		}
		$sql .= " WHERE `news_id` = '" . (int)$newid . "'";
		$query = $this->db->query($sql);
		return true;
	}
	
	public function getNews($data = array(), $joins = array(), $sort = array(), $options = array()) {
		$sql = "SELECT * FROM `news`";
		foreach($joins as $join) {
			$sql .= " LEFT JOIN $join";
			switch($join) {
				case "users":
					$sql .= " ON news.user_id=users.user_id";
					break;
				case "news_category":
					$sql .= " ON news.category_id=news_category.category_id";
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
	public function getTotalNews($data = array()) {
		$sql = "SELECT COUNT(*) AS count FROM `news`";
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
	
	public function getNewsById($newid, $joins = array()) {
		$sql = "SELECT * FROM `news`";
		foreach($joins as $join) {
			$sql .= " LEFT JOIN $join";
			switch($join) {
				case "users":
					$sql .= " ON news.user_id=users.user_id";
					break;
			}
		}
		$sql .=  " WHERE `news_id` = '" . (int)$newid . "' LIMIT 1";
		$query = $this->db->query($sql);
		return $query->row;
	}
	/*
	public function getTotalTickets($data = array()) {
		$sql = "SELECT COUNT(*) AS count FROM `tickets`";
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
	}*/
}
?>
