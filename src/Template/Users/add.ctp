<h1>Add User</h1>

<?php echo $this->Form->create($user, array('enctype'=>'multipart/form-data'));

echo '<div class="form-group">';
echo $this->Form->input('name', array('type' => 'text', 'class' => 'form-control', 'required' => true));
echo '</div>';

echo '<div class="form-group">';
echo $this->Form->input('username', array('type' => 'text', 'class' => 'form-control', 'required' => true));
echo '</div>';

echo '<div class="form-group">';
echo $this->Form->input('email', array('type' => 'email', 'class' => 'form-control', 'required' => true));
echo '</div>';

echo '<div class="form-group">';
echo $this->Form->input('password', array('type' => 'password', 'class' => 'form-control', 'required' => true));
echo '</div>';

echo '<div class="form-group">';
$options = [
	'admin' => 'admin',
	'other' => 'other',
];
echo $this->Form->input('role', array('class' => 'form-control', 'required' => true, 'type' => 'select', 'options' => $options));
echo '</div>';

echo '<div class="form-group">';
echo $this->Form->submit('Submit', array('class' => 'btn btn-primary', 'title' => 'Submit'));
echo '</div>';

echo $this->Form->end();
?>