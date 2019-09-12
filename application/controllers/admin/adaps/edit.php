<?php
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
class editController extends Controller {
	public function index($adapid = null) {
		$this->load->checkLicense();
		if(!$this->user->isLogged()) {
			$this->session->data['error'] = "Вы не авторизированы!";
			$this->response->redirect($this->config->url . 'account/login');
		}
		if($this->user->getAccessLevel() < 3) {
			$this->session->data['error'] = "У вас нет доступа к данному разделу!";
			$this->response->redirect($this->config->url);
		}
		
		$this->load->model('adaps');
		
		$error = $this->validate($adapid);
		if($error) {
			$this->session->data['error'] = $error;
			$this->response->redirect($this->config->url . 'admin/adaps/index');
		}
		
		$adap = $this->adapsModel->getAdapById($adapid);
		
		$this->data['adap'] = $adap;
		$this->load->model('games');
		$options = array(
			'start' => ($page - 1) * $this->limit,
			'limit' => $this->limit
		);
		$games = $this->gamesModel->getGames(array(), array(), $options);
		$this->data['games'] = $games;
		$this->getChild(array('common/admheader', 'common/footer'));
		return $this->load->view('admin/adaps/edit', $this->data);
	}
	
	public function ajax($adapid = null) {
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
		
		$this->load->model('adaps');
		
		$error = $this->validate($adapid);
		if($error) {
			$this->data['status'] = "error";
			$this->data['error'] = $error;
			return json_encode($this->data);
		}
		
		if($this->request->server['REQUEST_METHOD'] == 'POST') {
			$errorPOST = $this->validatePOST();
			if(!$errorPOST) {
				$name = @$this->request->post['name'];
				$textx = @$this->request->post['textx'];
				$img = @$this->request->post['img'];
				$gameid = @$this->request->post['gameid'];
				$arch = @$this->request->post['arch'];
				$patch = @$this->request->post['patch'];
				$act = @$this->request->post['act'];
				$category = @$this->request->post['category'];
				$price = @$this->request->post['price'];
				$status = @$this->request->post['status'];

			if($category) {

				$adapData = array(
					'game_id'           => $gameid,
                    'adap_name'         => $name,
                    'adap_url'          => $arch,
                    'adap_act'          => $act,
                    'adap_status'       => (int)$status,
                    'adap_textx'        => $textx,
                    'adap_img'          => $img,
                    'adap_patch'        => $patch,
                    'adap_price'        => $price,
                    'adap_category'     => 1
				);
				
				
				$this->adapsModel->updateAdap($adapid, $adapData);
				
				$this->data['status'] = "success";
				$this->data['success'] = "Вы успешно отредактировали дополнение!";
            } else {

                $adapData = array(
                    'game_id'           => $gameid,
                    'adap_name'         => $name,
                    'adap_url'          => $arch,
                    'adap_act'          => $act,
                    'adap_status'       => (int)$status,
                    'adap_textx'        => $textx,
                    'adap_img'          => $img,
                    'adap_patch'        => $patch,
                    'adap_price'        => 0,
                    'adap_category'     => 0
                );

                $this->adapsModel->updateAdap($adapid, $adapData);
                
                $this->data['status'] = "success";
                $this->data['success'] = "Вы успешно отредактировали дополнение!";
                
            }

			} else {
				$this->data['status'] = "error";
				$this->data['error'] = $errorPOST;
			}
		}

		return json_encode($this->data);
	}
	
	public function delete($adapid = null) {
		$this->load->checkLicense();
		$this->document->setActiveSection('admin');
		$this->document->setActiveItem('adaps');
		
		if(!$this->user->isLogged()) {
			$this->session->data['error'] = "Вы не авторизированы!";
			$this->response->redirect($this->config->url . 'account/login');
		}
		if($this->user->getAccessLevel() < 3) {
			$this->session->data['error'] = "У вас нет доступа к данному разделу!";
			$this->response->redirect($this->config->url);
		}
		
		$this->load->model('adaps');
		
		$error = $this->validate($adapid);
		if($error) {
			$this->session->data['error'] = $error;
			$this->response->redirect($this->config->url . 'admin/adaps/index');
		}
		
		$this->adapsModel->deleteAdap($adapid);
		
		$this->session->data['success'] = "Вы успешно удалили дополнение!";
		$this->response->redirect($this->config->url . 'admin/adaps/index');
		return null;
	}
	
	private function validate($adapid) {
		$result = null;
		
		if(!$this->adapsModel->getTotalAdaps(array('adap_id' => (int)$adapid))) {
			$result = "Запрашиваемое дополнение не существует!";
		}
		return $result;
	}
	
	private function validatePOST() {
		$this->load->library('validate');
		
		$validateLib = new validateLibrary();
		
		$result = null;
		
		$name = @$this->request->post['name'];
        $gameid = @$this->request->post['gameid'];
        $arch = @$this->request->post['arch'];
        $narch = @$this->request->post['narch'];
        $act = @$this->request->post['act'];
        $status = @$this->request->post['status'];
        $textx = @$this->request->post['textx'];
        $price = @$this->request->post['price'];
        $category = @$this->request->post['category'];
		
		if(mb_strlen($name) < 2 || mb_strlen($name) > 32) {
            $result = "Название дополнения должно содержать от 2 до 32 символов!";
        }
        elseif(mb_strlen($textx) < 2 || mb_strlen($textx) > 9900) {
            $result = "Описание должно содержать от 2 до 100 символов!";
        }
        elseif($status < 0 || $status > 1) {
            $result = "Укажите допустимый статус!";
        }
        elseif($category) {
            if(1 > $price || $price > 5000) {
                $result = "Укажите сумму от 1 до 5000 рублей!";
            }
        }

		return $result;
	}
}
?>
