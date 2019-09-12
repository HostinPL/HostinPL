<?php
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
class sendController extends Controller {
	public function index($id = null) {
		$this->load->checkLicense();
		$this->document->setActiveSection('admin');
		$this->document->setActiveItem('tickets');
		$this->data['url'] = $this->config->url;
		
		if(!$this->user->isLogged()) {
			$this->session->data['error'] = "Вы не авторизированы!";
			$this->response->redirect($this->config->url . 'account/login');
		}
		if($this->user->getAccessLevel() < 3) {
			$this->session->data['error'] = "У вас нет доступа к данному разделу!";
			$this->response->redirect($this->config->url);
		}
		
		$this->load->model('mail');
		$this->data['mail'] = $this->mailModel->getInboxById($id);
		
		$this->getChild(array('common/admheader', 'common/footer'));
		return $this->load->view('admin/infobox/send', $this->data);
	}
	
	public function sendMForm($id = null) {
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
		
        $this->load->model('mail');
		$this->load->library('mail');
		
		if($this->request->server['REQUEST_METHOD'] == 'POST') {
			if(@$this->request->post['msg'] == ""){
				$this->data['status'] = "error";
				$this->data['error'] = "Введите команду!";
			}elseif(@$this->request->post['msg'] != ""){
				$text = @$this->request->post['msg'];
				$dell = @$this->request->post['dell'];
				$data = $this->mailModel->getInboxById($id);
		
					
				$email = $data['user_email'];
				$firstname = $data['user_firstname'];
				$lastname = $data['user_lastname'];

				
				$mailLib = new mailLibrary();
				$mailLib->setFrom($this->config->mail_from);
				$mailLib->setSender($this->config->mail_sender);
				$mailLib->setTo($email);
				$mailLib->setSubject('Ответ на ваше сообщение IN$id');
				
				$mailData = array();
				$mailData['firstname'] = $firstname;
				$mailData['lastname'] = $lastname;
				$mailData['text'] = $text;
				
				$texts = $this->load->view('mail/infobox/user', $mailData);
			
				$mailLib->setText($texts);
				$mailLib->send();
				

				if($dell) {
					$this->mailModel->deleteInbox($id);
					$this->data['status'] = "success";
					$this->data['success'] = "Сообщение отправлено, и удалено!";
				} else {
					$this->mailModel->updateInbox($id, array('status' => 0));
					$this->data['status'] = "success";
					$this->data['success'] = "Сообщение отправлено!. ".$response."";
				}
			}
		} else {
			$this->data['status'] = "error";
			$this->data['error'] = "Не POST данные";
		}
		return json_encode($this->data);
	}

}

?>
