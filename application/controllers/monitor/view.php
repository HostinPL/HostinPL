<?php
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
class viewController extends Controller {
	public function index($serverid = null) {
		$this->load->checkLicense();
		$this->data['url'] = $this->config->url;
		
		$this->load->library('query');
		$this->load->model('servers');
		$this->load->model('serversStats');
		$error = $this->validate($serverid);
		if($error) {
			$this->session->data['error'] = $error;
			$this->response->redirect($this->config->url . 'servers/index');
		}
		
		$userid = $this->user->getId();
		
		$this->data['server'] = $server = $this->serversModel->getServerById($serverid, array('games', 'locations'));

		if($server['server_status'] == 2) {
			$queryLib = new queryLibrary($server['game_query']);
			$queryLib->connect($server['location_ip'], $server['server_port']);
			$query = $queryLib->getInfo();
			$queryLib->disconnect();
			
			$this->data['query'] = $query;
		}
		
		$this->data['stats'] = $stats = $this->serversStatsModel->getServerStats($serverid, "NOW() - INTERVAL 1 DAY", "NOW()");

		$this->getChild(array('common/header', 'common/footer'));
		return $this->load->view('monitor/view', $this->data);
	}
	
	
	private function validate($serverid) {
		$this->load->checkLicense();
		$result = null;
		
		$userid = $this->user->getId();
		

		return $result;
	}

	public function baner($serverid = null) {
		$this->load->checkLicense();

		
		$this->load->library('query');
		$this->load->model('servers');
		$error = $this->validate($serverid);
		if($error) {
			$this->session->data['error'] = $error;
			$this->response->redirect($this->config->url . 'servers/index');
		}
		
		$userid = $this->user->getId();
		
		$server = $this->serversModel->getServerById($serverid, array('games', 'locations'));
		$this->data['server'] = $server;

		if($server['server_status'] == 2) {
			
			$queryLib = new queryLibrary($server['game_query']);
			$queryLib->connect($server['location_ip'], $server['server_port']);
			$query = $queryLib->getInfo();
			$queryLib->disconnect();
			
			$im = imagecreatetruecolor(400, 72);
			$tb = imagecolorallocate($im, 0, 0, 0); // Черный цвет фона
			$tc  = imagecolorallocate($im, 255, 255, 255); // Белый цвет текста
			switch($server['game_code']) {
				case 'cs': {
						$image_map = imagecreatefromjpeg('application/public/baners/cs/maps/'.$query['mapname'].'.jpg'); // Картинка карты
						//Вывод null картинки если нет по названию карты
						if(!$image_map){
							$image_map = imagecreatefromjpeg('application/public/baners/map_no_image.jpg'); // Картинка карты
						}
						$image_icon = imagecreatefromgif('application/public/baners/cs/cs_i.gif');
					break;
				}
				case 'csgo': {
						$image_map = imagecreatefromjpeg('application/public/baners/csgo/maps/'.$query['mapname'].'.jpg'); // Картинка карты
						//Вывод null картинки если нет по названию карты
						if(!$image_map){
							$image_map = imagecreatefromjpeg('application/public/baners/map_no_image.jpg'); // Картинка карты
						}
						$image_icon = imagecreatefromgif('application/public/baners/csgo/csgo_i.gif');
					break;
				}
				case 'Insurgen': {
						$image_map = imagecreatefromjpeg('application/public/baners/insurgen/maps/'.$query['mapname'].'.jpg'); // Картинка карты
						//Вывод null картинки если нет по названию карты
						if(!$image_map){
							$image_map = imagecreatefromjpeg('application/public/baners/map_no_image.jpg'); // Картинка карты
						}
						$image_icon = imagecreatefromgif('application/public/baners/insurgen/insurgency_i.gif');
					break;
				}
				case 'gm': {
						$image_map = imagecreatefromjpeg('application/public/baners/gmod/maps/'.$query['mapname'].'.jpg'); // Картинка карты
						//Вывод null картинки если нет по названию карты
						if(!$image_map){
							$image_map = imagecreatefromjpeg('application/public/baners/map_no_image.jpg'); // Картинка карты
						}
						$image_icon = imagecreatefromgif('application/public/baners/gmod/garrysmod_i.gif');
					break;
				}
				case 'l4d2': {
						$image_map = imagecreatefromjpeg('application/public/baners/l4d2/maps/'.$query['mapname'].'.jpg'); // Картинка карты
						//Вывод null картинки если нет по названию карты
						if(!$image_map){
							$image_map = imagecreatefromjpeg('application/public/baners/map_no_image.jpg'); // Картинка карты
						}
						$image_icon = imagecreatefromgif('application/public/baners/l4d2/left4dead2_i.gif');
					break;
				}
				case 'tf2': {
						$image_map = imagecreatefromjpeg('application/public/baners/tf2/maps/'.$query['mapname'].'.jpg'); // Картинка карты
						//Вывод null картинки если нет по названию карты
						if(!$image_map){
							$image_map = imagecreatefromjpeg('application/public/baners/map_no_image.jpg'); // Картинка карты
						}
						$image_icon = imagecreatefromgif('application/public/baners/tf2/tf_i.gif');
					break;
				}
				case 'samp': {
						$image_map = imagecreatefromjpeg('application/public/baners/samp/maps/samp.jpg'); // Картинка карты
						$image_icon = imagecreatefromgif('application/public/baners/samp/samp_i.gif');
					break;
				}
				case 'crmp': {
						$image_map = imagecreatefromjpeg('application/public/baners/samp/maps/samp.jpg'); // Картинка карты
						$image_icon = imagecreatefromgif('application/public/baners/samp/samp_i.gif');
					break;
				}
				case 'mine': {
						$image_map = imagecreatefromjpeg('application/public/baners/minecraft/maps/world.jpg'); // Картинка карты
						$image_icon = imagecreatefromgif('application/public/baners/minecraft/samp_i1.gif');
					break;
				}
				case 'mcpe': {
						$image_map = imagecreatefromjpeg('application/public/baners/minecraft/maps/world.jpg'); // Картинка карты
						$image_icon = imagecreatefromgif('application/public/baners/minecraft/samp_i1.gif');
					break;
				}
				default: {
					$this->data['status'] = "error";
					$this->data['error'] = "Вы выбрали несуществующее действие!";
					break;
				}
			}

			imagesavealpha($im, true);
			imagesavealpha($image_icon, true);

			imagecopyresampled($im, $image_map, 4, 4, 0, 0, 120, 64, 160, 90);
			imagecopyresampled($im, $image_icon, 380, 4, 0, 0, 16, 16, 16, 16);
			imagettftext($im,8,0, 128, 16,$tc,'application/public/baners/fonts/arialbd.ttf','Сервер '.$query['hostname'].'');
			imagettftext($im,8,0, 128, 32,$tc,'application/public/baners/fonts/arialbd.ttf','Карта: '.$query['mapname'].'');
			imagettftext($im,8,0, 128, 48,$tc,'application/public/baners/fonts/arialbd.ttf','Игроки: '.$query['players'].'/'.$query['maxplayers'].'');
			imagettftext($im,8,0, 128, 64,$tc,'application/public/baners/fonts/arialbd.ttf','IP: '.$server['location_ip'].':'.$server['server_port']);
			header("Content-type: image/png");
			imagePNG($im);
		}
		
		if($server['server_status'] == 1) {
			
			$im = imagecreatetruecolor(400, 72);
			$tb = imagecolorallocate($im, 0, 0, 0); // Черный цвет фона
			$tc  = imagecolorallocate($im, 255, 255, 255); // Белый цвет текста
			$image_map = imagecreatefromjpeg('application/public/baners/map_no_image.jpg'); // Картинка карты
			$image_icon = imagecreatefromgif('icons/'.$game.'/'.$game.'.gif');
			imagesavealpha($im, true);
			imagesavealpha($image_icon, true);

			imagecopyresampled($im, $image_map, 4, 4, 0, 0, 120, 64, 160, 90);
			imagecopyresampled($im, $image_icon, 380, 4, 0, 0, 16, 16, 16, 16);
			imagettftext($im,8,0, 128, 16,$tc,'application/public/baners/fonts/arialbd.ttf','Сервер выключен');
			imagettftext($im,8,0, 128, 32,$tc,'application/public/baners/fonts/arialbd.ttf','Карта: неизвестно');
			imagettftext($im,8,0, 128, 48,$tc,'application/public/baners/fonts/arialbd.ttf','Игроки: 0/0');
			imagettftext($im,8,0, 128, 64,$tc,'application/public/baners/fonts/arialbd.ttf','IP: '.$server['location_ip'].':'.$server['server_port']);
			header("Content-type: image/png");
			imagePNG($im);
		}
		return $$im;
	}
	
}
?>
