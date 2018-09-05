<h1>Add Expense</h1>

<?php echo $this->Form->create($expense, array('enctype'=>'multipart/form-data'));

echo '<div class="form-group">';
echo $this->Form->input('title', array('type' => 'text', 'class' => 'form-control', 'required' => true));
echo '</div>';

echo '<div class="form-group">';
$options = [
	'Food' => 'Food',
	'Auto' => 'Auto',
	'Travel' => 'Travel',
	'Entertainment' => 'Entertainment',
	'Office' => 'Office',
	'Education' => 'Education',
	'Other' => 'Other',
];
echo $this->Form->input('category', array('class' => 'form-control', 'required' => true, 'type' => 'select', 'options' => $options));
echo '</div>';

echo '<div class="form-group">';
echo $this->Form->input('description', array('class' => 'form-control'));
echo '</div>';

echo '<div class="form-group">';
echo $this->Form->input('cost', array('type' => 'number', 'step' => 'any', 'class' => 'form-control'));
echo '</div>';

echo '<div class="form-group">';
echo $this->Form->submit('Submit', array('class' => 'btn btn-primary', 'title' => 'Submit'));
echo '</div>';

echo $this->Form->end();
?>
