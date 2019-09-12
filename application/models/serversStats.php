<?php
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
class serversStatsModel extends Model {
	public function createServerStats($data) {
		$sql = "INSERT INTO `servers_stats` SET ";
		$sql .= "server_id = '" . (int)$data['server_id'] . "', ";
		$sql .= "server_stats_date = NOW(), ";
		$sql .= "server_stats_cpu = '" . (int)$data['server_stats_cpu'] . "', ";	
		$sql .= "server_stats_ram = '" . (int)$data['server_stats_ram'] . "', ";		
		$sql .= "server_stats_hdd = '" . (int)$data['server_stats_hdd'] . "', ";				
		$sql .= "server_stats_players = '" . (int)$data['server_stats_players'] . "'";
		$this->db->query($sql);
		return $this->db->getLastId();
	}
	//Очистка устаревшей статистики 7 дней
	public function clearServersStats() {
		$sql = "DELETE FROM `servers_stats` WHERE server_stats_date < NOW() - INTERVAL 7 DAY";
		$this->db->query($sql);
	}
	
	public function deleteServerStats($serverid) {
		$sql = "DELETE FROM `servers_stats` WHERE server_id = '" . (int)$serverid . "'";
		$this->db->query($sql);
	}
	
	public function getServerStats($serverid, $start, $end) {
		$sql = "SELECT * FROM `servers_stats` WHERE server_id = '" . (int)$serverid . "' AND server_stats_date BETWEEN " . $start . " AND " . $end . " ORDER BY server_stats_date";
		$query = $this->db->query($sql);
		return $query->rows;
	}
	
	public function getTotalServerStats($data = array()) {
		$sql = "SELECT COUNT(*) AS count FROM `servers_stats`";
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
	
	public function getStatisticsPlayers() {
        $sql = "SELECT sum(`server_stats_players`) , DATE_FORMAT(`server_stats_date`, '%d.%m.%Y %H:%i') mydate FROM servers_stats GROUP BY mydate order by 'server_stats_date'";
        $query = $this->db->query($sql);
        return $query->rows;
    }
	
	public function getStatisticsLoad() {
        $sql = "SELECT sum(`server_stats_cpu`), sum(`server_stats_ram`), sum(`server_stats_hdd`), DATE_FORMAT(`server_stats_date`, '%d.%m.%Y %H:%i') mydate FROM servers_stats GROUP BY mydate order by 'server_stats_date'";
        $query = $this->db->query($sql);
        return $query->rows;
    }
}
?>
