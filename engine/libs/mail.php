<?php
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
class mailLibrary {
	protected $to;
	protected $from;
	protected $sender;
	protected $subject;
	protected $text;
	
	public function setTo($to) {
		$this->to = $to;
	}
	
	public function setFrom($from) {
		$this->from = $from;
	}
	
	public function setSender($sender) {
		$this->sender = $sender;
	}
	
	public function setSubject($subject) {
		$this->subject = $subject;
	}
	
	public function setText($text) {
		$this->text = $text;
	}
	
	public function send() {
		if (!$this->to) {
			exit("Ошибка: Не указан E-Mail получателя!");
		}
		
		if (!$this->from) {
			exit("Ошибка: Не указан E-Mail отправителя!");
		}
		
		if (!$this->sender) {
			exit("Ошибка: Не указано имя отправителя!");
		}
		
		if (!$this->subject) {
			exit("Ошибка: Не указана тема сообщения!");
		}
		
		if (!$this->text) {
			exit("Ошибка: Не указан текст сообщения!");
		}
		
		if (is_array($this->to)) {
			$this->to = implode(',', $this->to);
		}
		
		$header = "";
		
		$header .= "MIME-Version: 1.0\n";
		
		$header .= "From: " . $this->sender . "<" . $this->from . ">\n";
		$header .= "Reply-To: " . $this->sender . "\n";
		$header .= "X-Mailer: SMRPanel Mailer\n";
		$header .= "Return-Path: " . $this->sender . "\n";
		$header .= "Content-Type: text/html; charset=\"utf-8\"\n";

		return mail($this->to, $this->subject, $this->text, $header);
	}
}
?>
