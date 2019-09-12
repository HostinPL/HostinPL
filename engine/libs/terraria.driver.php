<?php
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
class terrariaQuery extends QueryBase {
	public function connect($ip, $port) {
		$this->ip = $ip;
		$this->port = $port;
	}
	public function disconnect() {
	}
	
	private function sendPacket() {
	}
	
	public function getInfo() {	
		require_once "GameQV1/GameQ.php";

		$gq = new GameQ();
		$gq->addServer(array(
			'id' => 'my_server',
			'type' => 'terraria',
			'host' => $this->ip .':'. $this->port,
		));

		$results = $gq->requestData();
		$data['hostname'] = $results['my_server']['hostname'];			
		$data['gamemode'] = $results['my_server']['gametype'];		
		$data['players'] = $results['my_server']['numplayers'];
		$data['maxplayers'] = $results['my_server']['maxplayers'];	
		$data['version'] = $results['my_server']['version'];	
		$data['plugins'] = $results['my_server']['plugins'];
		$data['players_list'] = $results['my_server']['players'];

		return $data;
    }
}
?>