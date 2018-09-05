<?php
namespace App\Controller;

use Cake\Event\Event;
use Cake\Network\Exception\NotFoundException;
use Cake\Validation\Validator;

class ExpensesController extends AppController {

	public function beforeFilter(Event $event)
	{
		//Deny if not logged in
		parent::beforeFilter($event);
		$this->Auth->deny();

		$this->loadModel('Expenses');
	}

	public function index() {
		$expenses = $this->Expenses->find('all', array('order'=>'id DESC'));
		$this->set('expenses', $expenses);
	}

	public function add() {
		$expenses = $this->Expenses->newEntity($this->request->getData());
		if ($this->request->is('post')) {
			//Validation
			$validator = new Validator();
			$validator
				->requirePresence('title')
				->notEmpty('title', 'A title is required.')
				->requirePresence('cost')
				->notEmpty('cost', 'A cost is required.');
			$errors_array = $validator->errors($this->request->getData());
			$error_msg = [];
			foreach($errors_array as $errors) {
				if(is_array($errors)) {
					foreach($errors as $error) {
						$error_msg[] = $error;
					}
				} else {
					$error_msg[] = $errors;
				}
			}
			if(!empty($error_msg)) {
				$this->Flash->set('Please fix the following error(s): '.implode('\n \r', $error_msg),
					['element' => 'alert-box',
					 'params' => [
						 'class' => 'danger'
					 ]]
				);
				return $this->redirect(['action' => 'add']);
			}

			//Save
			if ($this->Expenses->save($expenses)) {
				$this->Flash->set('The expenses item has been saved.',
					['element' => 'alert-box',
					 'params' => [
						 'class' => 'success'
					 ]]
				);
				$this->redirect(['action' => 'index']);
			} else {
				$this->Flash->set('Unable to add expenses item.',
					['element' => 'alert-box',
					 'params' => [
						 'class' => 'danger'
					 ]]
				);
			}
		}
		$this->set('expense', $expenses);
	}

	public function edit($id = NULL) {
		$expenses = $this->Expenses->get($id);
		if(empty($expenses)) {
			throw new NotFoundException('Could not find that article.');
		}
		else {
			$this->set('expense', $expenses);
		}

		if ($this->request->is(['post', 'put'])) {
			//Validation
			$validator = new Validator();
			$validator
				->requirePresence('title')
				->notEmpty('title', 'A title is required.')
				->requirePresence('cost')
				->notEmpty('cost', 'A cost is required.');
			$errors_array = $validator->errors( $this->request->getData() );
			$error_msg    = [];
			foreach ( $errors_array as $errors ) {
				if ( is_array( $errors ) ) {
					foreach ( $errors as $error ) {
						$error_msg[] = $error;
					}
				} else {
					$error_msg[] = $errors;
				}
			}
			if ( ! empty( $error_msg ) ) {
				$this->Flash->set( 'Please fix the following error(s): ' . implode( '\n \r', $error_msg ),
					[
						'element' => 'alert-box',
						'params'  => [
							'class' => 'danger'
						]
					]
				);

				return $this->redirect( [ 'action' => 'edit', $id ] );
			}

			//Save
			$data = $this->request->getData();
			$this->Expenses->patchEntity( $expenses, $data );
			if ( $this->Expenses->save( $expenses ) ) {
				$this->Flash->set( 'The expenses item has been updated.',
					[
						'element' => 'alert-box',
						'params'  => [
							'class' => 'success'
						]
					]
				);
				$this->redirect( [ 'action' => 'index' ] );
			} else {
				$this->Flash->set( 'Unable to update expenses item.',
					[
						'element' => 'alert-box',
						'params'  => [
							'class' => 'danger'
						]
					]
				);
			}
		}
	}

	public function delete($id = NULL) {
		$expenses = $this->Expenses->get($id);
		if ($this->Expenses->delete($expenses)) {
			$this->Flash->set('The expenses item '.$expenses->title.' has been deleted.',
				['element' => 'alert-box',
				 'params' => [
					 'class' => 'success'
				 ]]
			);
			$this->redirect(['action' => 'index']);
		}
	}

	public function export() {
		$this->viewBuilder()->setLayout('ajax');
		// filename for download
		$filename = "expenses_data_" . date('Ymd') . ".xls";

		header("Content-Disposition: attachment; filename=\"$filename\"");
		header("Content-Type: application/vnd.ms-excel");

		$result = $this->Expenses->find('all', array('order'=>'id DESC'));
		$separator = ",";

		echo "ID";
		echo $separator;

		echo "TITLE";
		echo $separator;

		echo "CATEGORY";
		echo $separator;

		echo "DESCRIPTION";
		echo $separator;

		echo "COST";
		echo $separator;

		echo "\r\n";

		foreach($result as $row) {
			echo $row->id;
			echo $separator;

			echo $row->title;
			echo $separator;

			echo $row->category;
			echo $separator;

			echo $row->description;
			echo $separator;

			echo $row->cost;
			echo $separator;

			echo "\r\n";
		}
	}
}