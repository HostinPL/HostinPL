<?php
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
class indexController extends Controller {
	public function index($userid = null) {
		$this->load->checkLicense();
		$this->document->setActiveSection('admin');
		$this->document->setActiveItem('spam');
		
		if(!$this->user->isLogged()) {
			$this->session->data['error'] = "Вы не авторизированы!";
			$this->response->redirect($this->config->url . 'account/login');
		}
		if($this->user->getAccessLevel() < 3) {
			$this->session->data['error'] = "У вас нет доступа к данному разделу!";
			$this->response->redirect($this->config->url);
		}
		
		$this->getChild(array('common/admheader', 'common/footer'));
		return $this->load->view('admin/smsinfo/index', $this->data);
	}
	
	public function sms_check_balance_ajax() {
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
		
		if($this->request->server['REQUEST_METHOD'] == 'POST') {
			
	    $url = "https://gate.smsaero.ru/balance/"; 
        $user = $this->config->email_smsaero;
        $password = $this->config->secret_smsaero;  
	    $answer = 'json';

        $data = array(
            "user" => $user,
            "password" => $password,
            "answer" => $json
        );

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);     
        $output = curl_exec($curl);
        curl_close($curl);
	    //$output = $output;
	    //print_r($output);
		
		$output = preg_replace('~[^0-9/.]+~','',$output); 	
			$this->data['status'] = "success";
			$this->data['success'] = "Баланс счёта ".$output."";
			$this->data['sum'] = "".$output." р";
		}

		return json_encode($this->data);
	}
	
	public function ajax($userid = null) {
		$this->load->checkLicense();
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
		
		$this->load->model('users');
		$this->load->library('mail');
		
		
		if($this->request->server['REQUEST_METHOD'] == 'POST') {
		$to = @$this->request->post['to'];
			$text = @$this->request->post['text'];
				$from = @$this->request->post['from'];
				     $password = @$this->request->post['password'];

        $url = "https://gate.smsaero.ru/testsend/"; 
        $user = $this->config->email_smsaero;
        //$password = $this->config->secret_smsaero; 
		
        $to = $to;		
		$text = $text;
        $from = $from;		
		 
        $data = array(
            "user" => $user,
            "password" => $password,
			
			"to" => $to,
			"text" => $text,
			"from" => $from
        );

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);     
        $output = curl_exec($curl);
        curl_close($curl);
	    //$output = $output;
	    //print_r($output);
				$this->data['status'] = "success";
				$this->data['success'] = "Рассылка успешно завершенна. ".$output."";
			} else {
				$this->data['status'] = "error";
				$this->data['error'] = "Не POST данные";
			}
		return json_encode($this->data);
	}
}

?>
