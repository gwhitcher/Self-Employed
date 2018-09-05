<?php
namespace App\Controller;

use Cake\Event\Event;
use Cake\Network\Exception\NotFoundException;
use Cake\Validation\Validator;

class MileageController extends AppController {

	public function beforeFilter(Event $event)
	{
		//Deny if not logged in
		parent::beforeFilter($event);
		$this->Auth->deny();

		$this->loadModel('Mileage');
	}

	public function index() {
		$mileage = $this->Mileage->find('all', array('order'=>'id DESC'));
		$this->set('mileage', $mileage);
	}

	public function add() {
		$mileage = $this->Mileage->newEntity($this->request->getData());
		if ($this->request->is('post')) {
			//Validation
			$validator = new Validator();
			$validator
				->requirePresence('date')
				->notEmpty('date', 'A date is required.')
				->requirePresence('distance')
				->notEmpty('distance', 'A distance is required.');
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
			if ($this->Mileage->save($mileage)) {
				$this->Flash->set('The mileage has been saved.',
					['element' => 'alert-box',
					 'params' => [
						 'class' => 'success'
					 ]]
				);
				$this->redirect(['action' => 'index']);
			} else {
				$this->Flash->set('Unable to add mileage.',
					['element' => 'alert-box',
					 'params' => [
						 'class' => 'danger'
					 ]]
				);
			}
		}
		$this->set('mileage', $mileage);
	}

	public function edit($id = NULL) {
		$mileage = $this->Mileage->get($id);
		if(empty($mileage)) {
			throw new NotFoundException('Could not find that article.');
		}
		else {
			$this->set('mileage', $mileage);
		}

		if ($this->request->is(['post', 'put'])) {
			//Validation
			$validator = new Validator();
			$validator
				->requirePresence('date')
				->notEmpty('date', 'A date is required.')
				->requirePresence('distance')
				->notEmpty('distance', 'A distance is required.');
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
			$this->Mileage->patchEntity( $mileage, $data );
			if ( $this->Mileage->save( $mileage ) ) {
				$this->Flash->set( 'The mileage has been updated.',
					[
						'element' => 'alert-box',
						'params'  => [
							'class' => 'success'
						]
					]
				);
				$this->redirect( [ 'action' => 'index' ] );
			} else {
				$this->Flash->set( 'Unable to update mileage.',
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
		$mileage = $this->Mileage->get($id);
		if ($this->Mileage->delete($mileage)) {
			$this->Flash->set('The mileage for '.$mileage->date.' has been deleted.',
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
		$filename = "mileage_data_" . date('Ymd') . ".xls";

		header("Content-Disposition: attachment; filename=\"$filename\"");
		header("Content-Type: application/vnd.ms-excel");

		$result = $this->Mileage->find('all', array('order'=>'id DESC'));
		$separator = ",";

		echo "ID";
		echo $separator;

		echo "DATE";
		echo $separator;

		echo "DISTANCE";
		echo $separator;

		echo "NOTES";
		echo $separator;

		echo "\r\n";

		foreach($result as $row) {
			echo $row->id;
			echo $separator;

			echo $row->date;
			echo $separator;

			echo $row->distance;
			echo $separator;

			echo $row->notes;
			echo $separator;

			echo "\r\n";
		}
	}
}