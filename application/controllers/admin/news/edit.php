<?php
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
class editController extends Controller {
	public function index($newid = null) {
		$this->load->checkLicense();
		$this->document->setActiveSection('admin');
		$this->document->setActiveItem('locations');
		
		if(!$this->user->isLogged()) {
			$this->session->data['error'] = "Вы не авторизированы!";
			$this->response->redirect($this->config->url . 'account/login');
		}
		if($this->user->getAccessLevel() < 3) {
			$this->session->data['error'] = "У вас нет доступа к данному разделу!";
			$this->response->redirect($this->config->url);
		}
		
		$this->load->model('news');
		
		$error = $this->validate($newid);
		if($error) {
			$this->session->data['error'] = $error;
			$this->response->redirect($this->config->url . 'admin/news/index');
		}
		
		$new = $this->newsModel->getNewsById($newid);
		
		$this->data['new'] = $new;
		$this->load->model('newsCategory');
		$category = @$this->request->post['category'];
		$category = $this->newsCategoryModel->getNewsCategory(array('category_status' => 1));
		$this->data['category'] = $category;
		$this->getChild(array('common/admheader', 'common/footer'));
		return $this->load->view('admin/news/edit', $this->data);
	}
	
	public function ajax($newid = null) {
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
		
		$error = $this->validate($newid);
		if($error) {
			$this->data['status'] = "error";
			$this->data['error'] = $error;
			return json_encode($this->data);
		}
		
		if($this->request->server['REQUEST_METHOD'] == 'POST') {
			$errorPOST = $this->validatePOST();
			if(!$errorPOST) {
				$name = @$this->request->post['name'];
				$text = @$this->request->post['text'];
				$category = @$this->request->post['category'];
				$place = @$this->request->post['place'];
				$locationData = array(
					'news_title'			=> $name,
					'news_text'			=> $text,
				    'category_id'		=> $category,
					'place'		        => $place
				);
 
				
				$this->newsModel->updateNews($newid, $locationData);
				
				$this->data['status'] = "success";
				$this->data['success'] = "Вы успешно отредактировали новость!";
			} else {
				$this->data['status'] = "error";
				$this->data['error'] = $errorPOST;
			}
		}

		return json_encode($this->data);
	}
	
	public function delete($newid = null) {
		$this->load->checkLicense();
		$this->document->setActiveSection('admin');
		$this->document->setActiveItem('locations');
		
		if(!$this->user->isLogged()) {
			$this->session->data['error'] = "Вы не авторизированы!";
			$this->response->redirect($this->config->url . 'account/login');
		}
		if($this->user->getAccessLevel() < 3) {
			$this->session->data['error'] = "У вас нет доступа к данному разделу!";
			$this->response->redirect($this->config->url);
		}
		
		$this->load->model('news');
		
		$error = $this->validate($newid);
		if($error) {
			$this->session->data['error'] = $error;
			$this->response->redirect($this->config->url . 'admin/news/index');
		}
		
		$this->newsModel->deleteNews($newid);
		
		$this->session->data['success'] = "Вы успешно удалили новость!";
		$this->response->redirect($this->config->url . 'admin/news/index');
		return null;
	}
	
	private function validate($newid) {
		$result = null;
		
		if(!$this->newsModel->getTotalNews(array('news_id' => (int)$newid))) {
			$result = "Запрашиваемая новость не существует!";
		}
		return $result;
	}
	
	private function validatePOST() {
		$this->load->library('validate');
		
		$validateLib = new validateLibrary();
		
		$result = null;
		
				$name = @$this->request->post['name'];
				$text = @$this->request->post['text'];
		
		if(mb_strlen($text) < 2 || mb_strlen($text) > 1000) {
			$result = "Текст должен содержать от 2 до 1000 символов!";
		}
		return $result;
	}
}
?>
