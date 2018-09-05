<?php
namespace App\Controller;

use Cake\Event\Event;

class AdminController extends AppController {

	public function beforeFilter(Event $event)
	{
		//Deny if not logged in
		parent::beforeFilter($event);
		$this->Auth->deny();
	}

	public function index() {

	}
}