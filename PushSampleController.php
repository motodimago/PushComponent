<?php

class PushSampleController extends AppController {

	public $components = array('Push');

	public function beforeFilter() {
		$this->autoRender = false;
	}

	public function index() {

		$this->Push->setMessage('Dog!! Cat!! Giraffe!!');
		
		$this->Push->setBadge(2);
		
		// if you want to set defalut, you don't need set sound;
		$this->Push->setSound('xxxx');
		
		// You can set extra value;
		$this->Push->setExtra('user_id', 1);
		/*
		EX.
			aps:{
				alert:xxx,
				sound:xxx	
			},
			user_id:1
		*/

		$ex = array('name' => 'Mr.dog');
		$this->Push->setExtra('user', $ex);
		/*
		EX.
			aps:{
				alert:xxx,
				sound:xxx	
			},
			user:{
				name:Mr.dog	
			}
		*/		

		$token = 'SET Device Token!';
		
		$this->Push->push($token);
	}
}