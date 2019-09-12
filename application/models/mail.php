<?php
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
class mailModel extends Model {	
	public function createInbox($data) {
		$sql = "INSERT INTO `inbox` SET ";
		$sql .= "user_id = '" . (int)$data['user_id'] . "', ";
		$sql .= "user_firstname = '" . $this->db->escape($data['user_firstname']) . "', ";
		$sql .= "user_lastname = '" . $this->db->escape($data['user_lastname']) . "', ";
		$sql .= "user_email = '" . $this->db->escape($data['user_email']) . "', ";
		$sql .= "category = '" . $this->db->escape($data['category']) . "', ";
		// $sql .= "text = '" . (float)$data['text'] . "', ";
		$sql .= "text = '" . strip_tags(htmlspecialchars_decode($this->db->escape($data['text'])), '<iframe><img><span><cool><ul><ol><pre><li><div><em><strong><sup><code>') . "', ";
		$sql .= "status = '" . (int)$data['status'] . "', ";
		$sql .= "inbox_date_add = NOW()";
		$this->db->query($sql);
		return $this->db->getLastId();
	}
	
	public function deleteInbox($id) {
		$sql = "DELETE FROM `inbox` WHERE id = '" . (int)$id . "'";
		$this->db->query($sql);
	}
	
	public function clearInboxsLog() {
		$sql = "DELETE FROM `inbox` WHERE inboxs_date_add < NOW() - INTERVAL 0 DAY";
		$this->db->query($sql);
	}
	
	public function updateInbox($Inboxid, $data = array()) {
		$sql = "UPDATE `inbox`";
		if(!empty($data)) {
			$count = count($data);
			$sql .= " SET";
			foreach($data as $key => $value) {
				$sql .= " $key = '" . $this->db->escape($value) . "'";
				
				$count--;
				if($count > 0) $sql .= ",";
			}
		}
		$sql .= " WHERE `id` = '" . (int)$Inboxid . "'";
		$query = $this->db->query($sql);
		return true;
	}
	
	public function getInboxs($data = array(), $sort = array(), $options = array()) {
		$sql = "SELECT * FROM `inbox`";
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

	public function getInboxById($Inboxid) {
		$sql = "SELECT * FROM `inbox` WHERE `id` = '" . (int)$Inboxid . "' LIMIT 1";
		$query = $this->db->query($sql);
		return $query->row;
	}
	
	public function getTotalInbox($data = array()) {
		$sql = "SELECT COUNT(*) AS count FROM `inbox`";
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
