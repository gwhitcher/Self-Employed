<h1>Add Mileage</h1>

<?php echo $this->Form->create($mileage, array('enctype'=>'multipart/form-data'));

echo '<div class="form-group">';
echo $this->Form->input('date', array('type' => 'date', 'class' => 'form-control', 'required' => true));
echo '</div>';

echo '<div class="form-group">';
echo $this->Form->input('distance', array('type' => 'text', 'class' => 'form-control', 'required' => true));
echo '</div>';

echo '<div class="form-group">';
echo $this->Form->input('notes', array('class' => 'form-control'));
echo '</div>';

echo '<div class="form-group">';
echo $this->Form->submit('Submit', array('class' => 'btn btn-primary', 'title' => 'Submit'));
echo '</div>';

echo $this->Form->end();
?>