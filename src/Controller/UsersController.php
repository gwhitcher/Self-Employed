<?php
namespace App\Controller;

use Cake\Event\Event;
use Cake\Network\Exception\NotFoundException;
use Cake\Validation\Validator;
use Cake\Auth\DefaultPasswordHasher;

class UsersController extends AppController {

    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
    }

    public function login() {
        $this->set('title_for_layout', 'Login');

        //Ban Check
        //$this->ban_check($this->get_ip());

        if ($this->request->is('post')) {

            //Login security
            if(empty($_SESSION['login_count'])) {
                $_SESSION['login_count'] = 0;
            } elseif($_SESSION['login_count'] >= 3) {
                $this->loadModel('Users_Banned');
                $query = $this->Users_Banned->query();
                $query->insert(['ip_address'])
                    ->values([
                        'ip_address' => $this->get_ip()
                    ])
                    ->execute();
            }

            if(RECAPTCHA_SWITCH == 1) {
	            //Captcha
	            if(isset($_POST['g-recaptcha-response']))
		            $captcha = $_POST['g-recaptcha-response'];
	                $response = json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".RECAPTCHA_SECRET_KEY."&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']), true);

	            if($response['success'] == false) {
		            $_SESSION['login_count']++;
		            $this->Flash->set('Captcha incorrect!',
			            ['element' => 'alert-box',
			             'params' => [
				             'class' => 'danger'
			             ]]
		            );
		            return $this->redirect(['action' => 'login']);
	            }
            }

            $user = $this->Auth->identify();
            if ($user) {
                unset($_SESSION['login_count']);
                $this->Auth->setUser($user);
                $this->Flash->set('Logged in!',
                    ['element' => 'alert-box',
                        'params' => [
                            'class' => 'success'
                        ]]
                );
                return $this->redirect($this->Auth->redirectUrl());
            } else {
                $_SESSION['login_count']++;

                $this->Flash->set('Invalid username or password, try again',
                    ['element' => 'alert-box',
                        'params' => [
                            'class' => 'danger'
                        ]]
                );
            }
        }
    }

    public function logout() {
        $this->Flash->set('Successfully logged out.',
            ['element' => 'alert-box',
                'params' => [
                    'class' => 'success'
                ]]
        );
        return $this->redirect($this->Auth->logout());
    }

    public function get_ip() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    public function ban_check($ip = NULL) {
        $this->loadModel('Users_Banned');
        $ip_address = $this->Users_Banned->find('all')->where(['ip_address' => $ip])->first();
        $ip_address_count = count($ip_address);
        if($ip_address_count >= 1) {
            return $this->redirect('http://google.com');
        }
    }

	public function index() {
		$this->set('title_for_layout', 'Users');
		$this->loadModel('Users');
		$this->paginate = [
			'limit' => 10,
			'order' => [
				'Users.id' => 'desc'
			]
		];
		$users = $this->paginate($this->Users);
		$this->set('users', $users);
	}

	public function add() {
		$this->loadModel('Users');
		$user = $this->Users->newEntity($this->request->getData());
		if ($this->request->is('post')) {
			//Validation
			$validator = new Validator();
			$validator
				->requirePresence('username')
				->notEmpty('username', 'A username is required.');
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

			//Password hash
			$password_hash = new DefaultPasswordHasher;
			$password = $password_hash->hash($this->request->getData['password']);
			$user->password = $password;

			//Save
			if ($this->Users->save($user)) {
				$this->Flash->set('The user has been saved.',
					['element' => 'alert-box',
					 'params' => [
						 'class' => 'success'
					 ]]
				);
				$this->redirect(['action' => 'index']);
			} else {
				$this->Flash->set('Unable to add user.',
					['element' => 'alert-box',
					 'params' => [
						 'class' => 'danger'
					 ]]
				);
			}
		}
		$this->set('user', $user);
	}

	public function edit($id = NULL) {
		$this->loadModel('Users');
		$user = $this->Users->get($id);
		$this->set('title_for_layout', 'User : '.$user['name']);
		if (empty($user)) {
			throw new NotFoundException('Could not find that user.');
		} else {
			$this->set('user', $user);
		}

		if ($this->request->is(['post', 'put'])) {
			//Validation
			$validator = new Validator();
			$validator
				->requirePresence('username')
				->notEmpty('username', 'A username is required.');
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
				return $this->redirect(['action' => 'edit', $id]);
			}


			//Save
			$data = $this->request->getData();

			//Password hash
			$password_hash = new DefaultPasswordHasher;
			$password = $password_hash->hash($this->request->getData['password']);
			$data['password'] = $password;

			$this->Users->patchEntity($user, $data);
			if ($this->Users->save($user)) {
				$this->Flash->set('The user has been updated.',
					['element' => 'alert-box',
					 'params' => [
						 'class' => 'success'
					 ]]
				);
				$this->redirect(['action' => 'edit', $id]);
			} else {
				$this->Flash->set('Unable to update user.',
					['element' => 'alert-box',
					 'params' => [
						 'class' => 'danger'
					 ]]
				);
			}
		}
	}

	public function delete($id = NULL) {
		$this->loadModel('Users');
		$user = $this->Users->get($id);
		if ($this->Users->delete($user)) {
			$this->Flash->set('The user '.$user->name.' has been deleted.',
				['element' => 'alert-box',
				 'params' => [
					 'class' => 'success'
				 ]]
			);
			$this->redirect(['action' => 'index']);
		}
	}
}