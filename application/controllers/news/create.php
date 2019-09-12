<?php
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
class createController extends Controller {

	public function index($ticketid = null) {
		$this->load->checkLicense();
		$this->document->setActiveSection('admin');
		$this->document->setActiveItem('create');
		
		if(!$this->user->isLogged()) {
			$this->session->data['error'] = "Вы не авторизированы!";
			$this->response->redirect($this->config->url . 'account/login');
		}
		if($this->user->getAccessLevel() < 0) {
			$this->session->data['error'] = "У вас нет доступа к данному разделу!";
			$this->response->redirect($this->config->url);
		}
				$this->load->model('newsCategory');
		$category = @$this->request->post['category'];
		$category = $this->newsCategoryModel->getNewsCategory(array('category_status' => 1));
		$this->data['category'] = $category;
		$this->getChild(array('common/admheader', 'common/footer'));
		return $this->load->view('news/create', $this->data);
	}
	
	public function ajax($ticketid = null) {
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
		
		$this->load->model('news');
		
		if($this->request->server['REQUEST_METHOD'] == 'POST') {
			$errorPOST = $this->validatePOST();
			if(!$errorPOST) {
				$name = @$this->request->post['name'];
				$text = @$this->request->post['text'];
				$category = @$this->request->post['category'];
				$place = @$this->request->post['place'];
				$userid = $this->user->getId();
				
				$newsData = array(
					'user_id'			=> $userid,
					'news_title'		=> $name,
					'news_text'			=> $text,
					'category_id'		=> $category,
					'place'		        => $place
				);
				$newsid = $this->newsModel->createNews($newsData);

				
				$this->data['status'] = "success";
				$this->data['success'] = "Вы успешно создали новость!";
				$this->data['id'] = $newsid;
			} else {
				$this->data['status'] = "error";
				$this->data['error'] = $errorPOST;
			}
		}

		return json_encode($this->data);
	}
	
	private function validatePOST() {
		$this->load->checkLicense();
		$result = null;
		
		$name = @$this->request->post['name'];
		$text = @$this->request->post['text'];
		
		if(mb_strlen($name) < 6 || mb_strlen($name) > 300) {
			$result = "Название новости должно содержать от 6 до 300 символов!";
		}
		elseif(mb_strlen($text) < 10 || mb_strlen($text) > 500) {
			$result = "Текст новости должен содержать от 10 до 350 символов!";
		}
		return $result;
	}
}
