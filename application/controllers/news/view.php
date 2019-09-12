<?php
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
class viewController extends Controller {
	public function index($newid = null) {
		$this->load->checkLicense();
		$this->data['url'] = $this->config->url;
 
		$this->load->model('news');
		$this->load->model('newsMessages');
 
  		$error = $this->validate($newid);
		if($error) {
			$this->session->data['error'] = $error;
			$this->response->redirect($this->config->url . 'news/index');
		}
		
		$userid = $this->user->getId();
		
		$new = $this->newsModel->getNewsById($newid, array('users'));
		$messages = $this->newsMessagesModel->getNewsMessages(array('news_id' => $newid), array('users'));
		$this->data['new'] = $new;
        $this->data['messages'] = $messages;
        $this->data['user_img'] = $this->user->getUser_img();
 
		$nq = $new['look']+1;
		$this->newsModel->updateNews($newid, array('look' => $nq));
		$nolog = $this->user->isLogged();
		$this->data['nolog'] = $nolog;
		if(!$this->user->isLogged()) {
        $this->getChild(array('common/loginheader', 'common/loginfooter'));
		} else $this->getChild(array('common/header', 'common/footer'));
		return $this->load->view('news/view', $this->data);
	}
 
	public function ajax($newid = null) {
		$this->load->checkLicense();
 
		$this->load->model('news');
		$this->load->model('newsMessages');
		
		$error = $this->validate($newid);
		if($error) {
	  		$this->data['status'] = "error";
			$this->data['error'] = $error;
			return json_encode($this->data);
		}
		
		if($this->request->server['REQUEST_METHOD'] == 'POST') {
			$errorPOST = $this->validatePOST($newid);
			if(!$errorPOST) {
				$text = @$this->request->post['text'];
				
				$userid = $this->user->getId();
			
					$messageData = array(
						'news_id'			=> $newid,
						'user_id'			=> $userid,
						'news_message'	=> $text
					);
					$this->newsMessagesModel->createNewsMessage($messageData);
					
					$this->data['status'] = "success";
					$this->data['success'] = "Вы успешно отправили сообщение!";
			} else {
				$this->data['status'] = "error";
				$this->data['error'] = $errorPOST;
			}
		}

		return json_encode($this->data);
	}
	private function validate($newid) {
		$this->load->checkLicense();
		$result = null;
 		if(!$this->newsModel->getTotalNews(array('news_id' => (int)$newid))) {
			$result = "Запрашиваемая новость не существует!";
		}
		return $result;
	}
		private function validatePOST($newid) {
		$this->load->checkLicense();
		$result = null;
		
		$text = @$this->request->post['text'];
			if(mb_strlen($text) < 10 || mb_strlen($text) > 10000) {
				$result = "Текст сообщения должен содержать от 10 до 350 символов.";
			}
		return $result;
	}
 
}
?>
