<?php
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
class captchaController extends Controller {
	public function index() {
		$this->load->checkLicense();
		$this->load->library('captcha');
		
		$captchaLib = new captchaLibrary();
		
		$this->session->data['captcha'] = $captchaLib->getCode();
		$captchaLib->showImage();
		return null;
	}
}
?>