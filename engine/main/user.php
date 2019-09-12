<?php
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
class User {
	private $registry;

	private $user_id;
	private $email;
	private $firstname;
	private $lastname;
	private $balance;
	private $access_level;
    private $user_img;
	private $test_server;
	private $user_vk_id;
	
  	public function __construct($registry) {
		$this->registry = $registry;
		if (isset($this->registry->session->data['user_id'])) {
			$query = $this->registry->db->query("SELECT * FROM users WHERE user_id = '" . (int)$this->registry->session->data['user_id'] . "' AND user_status = '1'");
			
			if ($query->num_rows) {
				$this->user_id = $query->row['user_id'];
				$this->email = $query->row['user_email'];
				$this->firstname = $query->row['user_firstname'];
				$this->lastname = $query->row['user_lastname'];
				$this->balance = $query->row['user_balance'];
				$this->access_level = $query->row['user_access_level'];
				$this->user_img = $query->row['user_img'];
				$this->test_server = $query->row['test_server'];
				$this->user_vk_id = $query->row['user_vk_id'];
			} else {
				$this->logout();
			}
		}
  	}
		
  	public function login($email, $password) {
		$query = $this->registry->db->query("SELECT * FROM users WHERE user_email = '" . $this->registry->db->escape($email) . "' AND user_password = '" . $this->registry->db->escape($password) . "' AND user_status = '1'");

		if($query->num_rows) {
			$this->registry->session->data['user_id'] = $query->row['user_id'];
			
			$this->user_id = $query->row['user_id'];
			$this->email = $query->row['user_email'];
			$this->firstname = $query->row['user_firstname'];
			$this->lastname = $query->row['user_lastname'];
			$this->balance = $query->row['user_balance'];
			$this->access_level = $query->row['user_access_level'];
			$this->user_img = $query->row['user_img'];	
            $this->test_server = $query->row['test_server'];			
	  		return true;
		} else {
	  		return false;
		}
  	}

  	public function logout() {
		unset($this->registry->session->data['user_id']);
	
		$this->user_id = null;
		$this->email = null;
		$this->firstname = null;		
		$this->lastname = null;
		$this->balance = null;
		$this->access_level = 0;
		$this->user_vk_id = null;
  	}
  
  	public function isLogged() {
		return $this->user_id;
  	}
  
  	public function getId() {
		return $this->user_id;
  	}
	
  	public function getEmail() {
		return $this->email;
  	}
	
  	public function getFirstname() {
		return $this->firstname;
  	}
  	public function getLastname() {
		return $this->lastname;
  	}
	public function getUser_img() {
		return $this->user_img;
  	}
  	public function getBalance() {
		return $this->balance;
  	}
	public function getUser_vk_id() {
		return $this->user_vk_id;
  	}
	
  	public function getAccessLevel() {
		return $this->access_level;
  	}

  	public function getTest_server() {
		return $this->test_server;
	}
}
?>
