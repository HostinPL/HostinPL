<?php
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
class newsCategoryModel extends Model {

	public function createNewsCategory($data) {
		$sql = "INSERT INTO `news_category` SET ";
		$sql .= "category_name = '" . $this->db->escape($data['category_name']) . "', ";
		$sql .= "category_status = '" . (int)$data['category_status'] . "' ";
		$this->db->query($sql);
		return $this->db->getLastId();
	}
	
	public function deleteNewsCategory($categoryid) {
		$sql = "DELETE FROM `news_category` WHERE category_id = '" . (int)$categoryid . "'";
		$this->db->query($sql);
	}
	
	public function updateNewsCategory($categoryid, $data = array()) {
		$sql = "UPDATE `news_category`";
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
	
	public function getNewsCategory($data = array(), $joins = array(), $sort = array(), $options = array()) {
		$sql = "SELECT * FROM `news_category`";
		foreach($joins as $join) {
			$sql .= " LEFT JOIN $join";
			switch($join) {
				case "news":
					$sql .= " ON news_category.category_id=news.category_id";
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
	
		public function getNewsCategoryById($categoryid, $joins = array()) {
		$sql = "SELECT * FROM `news_category`";
		foreach($joins as $join) {
			$sql .= " LEFT JOIN $join";
			switch($join) {
				case "news":
					$sql .= " ON news_category.user_id=news.user_id";
					break;
			}
		}
		$sql .=  " WHERE `category_id` = '" . (int)$categoryid . "' LIMIT 1";
		$query = $this->db->query($sql);
		return $query->row;
	}
	public function getTotalnewsCategory($data = array()) {
		$sql = "SELECT COUNT(*) AS count FROM `news_category`";
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
