<?php
namespace App\Controller;

use Cake\Event\Event;

class PagesController extends AppController
{
	public function beforeFilter(Event $event)
	{
		//Deny if not logged in
		parent::beforeFilter($event);
		$this->Auth->allow();
	}

    public function home() {
    }
}
