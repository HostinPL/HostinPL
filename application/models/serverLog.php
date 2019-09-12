<?php
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
class serverLogModel extends Model {
	public function createLog($data) {
		
		$sql = "INSERT INTO `serverlog` SET ";
		$sql .= "`reason` = '" . $data['reason'] . "', ";
		$sql .= "`status` = '" . (int)$data['status'] . "', ";
		$sql .= "`server_id` = '" . (int)$data['server_id'] . "', ";
		$sql .= "`date` = NOW()";
		$this->db->query($sql);
		$return=$this->db->getLastId();		
		return $return;
	}

	public function deleteLog($logid) {
		$sql = "DELETE FROM `serverlog` WHERE log_id = '" . (int)$logid . "'";
		$this->db->query($sql);
	}
 	
	public function getLogs($data = array(), $joins = array(), $sort = array(), $options = array()) {
		$sql = "SELECT * FROM `serverlog`";
		foreach($joins as $join) {
			$sql .= " LEFT JOIN $join";
			switch($join) {
				case "servers":
					$sql .= " ON serverlog.server_id=servers.server_id";
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
	
	public function getServerLogById($logid, $joins = array()) {
		$sql = "SELECT * FROM `serverlog`";
		foreach($joins as $join) {
			$sql .= " LEFT JOIN $join";
			switch($join) {
				case "servers":
					$sql .= " ON serverlog.server_id=servers.server_id";
					break;
			}
		}
		$sql .=  " WHERE `log_id` = '" . (int)$logid . "' LIMIT 1";
		$query = $this->db->query($sql);
		return $query->row;
	}
	
	public function getTotalLogs($data = array()) {
		$sql = "SELECT COUNT(*) AS count FROM `serverlog`";
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
