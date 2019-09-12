<?php
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
class settingsController extends Controller {
	public function index() {	
		$this->document->setActiveSection('admin');
		$this->document->setActiveItem('index');
		
		if(!$this->user->isLogged()) {
			$this->session->data['error'] = "Вы не авторизированы!";
			$this->response->redirect($this->config->url . 'account/login');
		}
		if($this->user->getAccessLevel() < 3) {
			$this->session->data['error'] = "У вас нет доступа к данному разделу!";
			$this->response->redirect($this->config->url);
		}

		$userid = $this->user->getId();
		$this->load->model('users');	
		
		require(APPLICATION_DIR . 'config.php');
		$this->data['settings'] = $config;
		unset($config);

		$this->getChild(array('common/admheader', 'common/footer'));
		return $this->load->view('admin/settings', $this->data);
	}

	public function ajax() {
		if(!$this->user->isLogged()) {  
	  		$this->data['status'] = "error";
			$this->data['error'] = "Вы не авторизированы!";
			return json_encode($this->data);
		}
		if($this->user->getAccessLevel() < 3) {
	  		$this->data['status'] = "error";
			$this->data['error'] = "У вас нет доступа к данному разделу!";
			return json_encode($this->data);
		}

		$userid = $this->user->getId();
		$this->load->model('users');	
		
		if($this->request->server['REQUEST_METHOD'] == 'POST') {


		$file = file_get_contents(APPLICATION_DIR . 'config.php');
		$file = str_replace(",", "", $file);
		
		$file = str_replace("<?php", "", $file);	
		$file = str_replace('$config = array(', "", $file);			
		
		$file = str_replace(');', "", $file);	
		$file = str_replace('?>', "", $file);	
		
		$file = explode("\n",$file);

		$file2 = array();
		foreach($file as $line){
			if($line !== ''){
				$file2[] = $line;
			}
		}
		unset($line);
		$file = $file2;
		unset($file2);
			
			$post = array();
			foreach($this->request->post as $post_string => $post_value){
				$post[$post_string] = $post_value;
				if($post_string !== 'close'){
					$post['close'] = 'off';
				}
			}
			
				foreach($post as $string => $value) {
					for ($i = 0; $i < count($file); $i++) {
						if (strpos($file[$i], $string) !== FALSE) {
							$search_line = $file[$i];
							$file[$i] = "'".$string."' => '".$value."'";
							break;
						}
					} 
					if($search_line == null) {
						$file[] = "'".$string."' => '".$value."'";
					}	
					unset($search_line);
				}
				
				
				
				foreach($file as $line => $line2){
					if($line < count($file)-1 and $file[$line] != "\n"){
						$file[$line] = $line2.',';
					}
				}					
				
				$file = implode("\n", $file);
				$file = preg_replace('/([\r\n]){2,}/s', '\1', $file); 
			
			$file2 = '<?php';
			$file2 .= "\n".'$config = array('; 
			$file2 .= "\n".$file;
			$file2 .= "\n".');';
			$file2 .= "\n".'?>';
		
			file_put_contents(APPLICATION_DIR.'config.php', $file2);	
				
			$this->data['status'] = "success";
			$this->data['success'] = "Настройки сохранены!";
		}

		return json_encode($this->data);
	}

}
?>
