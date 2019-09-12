<?php
include "application/config.php";
$db = new mysqli($config['db_hostname'], $config['db_username'], $config['db_password'], $config['db_database']); 
$db->set_charset("utf8");
if($_GET['action'] == 'getconsole'){
	if(!empty($_GET['serverid'])):
		$sql = "SELECT * FROM `servers` WHERE `server_id` = '{$_GET['serverid']}' LIMIT 1";		
		$result = $db->query($sql);
		$sql1 = "SELECT * FROM `locations` WHERE `location_id` = '{$_GET['locationid']}' LIMIT 1";
		$result1 = $db->query($sql1);
		if ($result->num_rows == 1) {
			$server = $result->fetch_assoc();
			$loca = $result1->fetch_assoc();
			$str2 = iconv ('windows-1251', 'utf-8', 'ftp://gs'.$_GET['serverid'].':'.$server['server_password'].'@'.$loca['location_ip'].':21/server_log.txt'); 
			$page = file_get_contents($str2);
			echo iconv('windows-1251', 'utf-8', $page);
		}
	endif;
}
elseif($_GET['action'] == 'getconsoles'){
	if(!empty($_GET['serverid'])):
		$sql = "SELECT * FROM `servers` WHERE `server_id` = '{$_GET['serverid']}' LIMIT 1";		
		$result = $db->query($sql);
		$sql1 = "SELECT * FROM `locations` WHERE `location_id` = '{$_GET['locationid']}' LIMIT 1";
		$result1 = $db->query($sql1);
		if ($result->num_rows == 1) {
			$server = $result->fetch_assoc();
			$loca = $result1->fetch_assoc();
			$str2 = iconv ('windows-1251', 'utf-8', 'ftp://gs'.$_GET['serverid'].':'.$server['server_password'].'@'.$loca['location_ip'].':21/screenlog.0'); 
			$page = file_get_contents($str2);
			echo iconv('windows-1251', 'utf-8', $page);
		}
	endif;
}
?>
