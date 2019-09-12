<?php
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
class l4d2Query extends QueryBase {
	public function connect($ip, $port) {
		$this->ip = $ip;
		$this->port = $port;
	}
	public function disconnect() {
	}
	
	private function sendPacket() {
	}
	
	public function getInfo() {	
	require_once('GameQV2/Autoloader.php');
		
	$servers = [
        [
		    'id' => 'my_server',
		    'type' => 'Source',
			'host' => $this->ip .':'. $this->port,
        ]
    ];

    $GameQ = new \GameQ\GameQ(); // or $GameQ = \GameQ\GameQ::factory();
    $GameQ->addServers($servers);
    $GameQ->setOption('timeout', 1); // seconds


    $results = $GameQ->process();
    // print_r($results);
		$data['hostname'] = $results['my_server']['hostname'];		
		$data['mapname'] = $results['my_server']['map'];		
		$data['gamemode'] = $results['my_server']['game_descr'];		
		$data['players'] = $results['my_server']['num_players'];
		$data['maxplayers'] = $results['my_server']['max_players'];		
        $data['version'] = $results['my_server']['version'];
		$data['players_list'] = $results['my_server']['players'];
		return $data;
    }
}
?>