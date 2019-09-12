<?php
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
class mcpeQuery extends QueryBase {
	public function connect($ip, $port) {
		$this->ip = $ip;
		$this->port = $port;
	}
	public function disconnect() {
	}
	
	private function sendPacket() {
	}
	
	public function getInfo() {	
		require_once('gameq/Autoloader.php');
		
		$GameQ = new \GameQ\GameQ();
			$GameQ->addServer([
				'id' => 'my_server',
				'type' => 'minecraftpe',
				'host' => $this->ip .':'. $this->port,
			]);
			
		$GameQ->addFilter('normalise');
		
		$GameQ->setOption('timeout', 3);
		$GameQ->setOption('stream_timeout', 500000);
		$GameQ->setOption('write_wait', 0);
		
		$results = $GameQ->process();
		if ($results['my_server']["gq_online"] == true) {	
			$data['hostname'] = $results['my_server']['hostname'];		
			$data['mapname'] = $results['my_server']['map'];		
			$data['gamemode'] = $results['my_server']['gametype'];		
			$data['players'] = $results['my_server']['numplayers'];
			$data['maxplayers'] = $results['my_server']['maxplayers'];		
			$data['version'] = $results['my_server']['version'];
			
			if (empty($results['my_server']['players'])) {
				$data['players_list'];
			} else {
				$data['players_list'] = $results['my_server']['players'];
			}
		} else {
			$data['hostname'] = "Нет данных";		
			$data['mapname'] = "Нет данных";		
			$data['gamemode'] = "Нет данных";		
			$data['players'] = "0";
			$data['maxplayers'] = "0";	
			$data['version'] = "Нет данных";			
			$data['players_list'] = "null";
        }
		$data['online'] = $results['my_server']["gq_online"];
		return $data;
    }

}
?>