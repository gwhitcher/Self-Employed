<h1 class="page-header">Login</h1>
<?php
echo $this->Form->create('', array('enctype'=>'multipart/form-data'));

echo '<div class="form-group">';
echo $this->Form->input('username', array('class' => 'form-control', 'required' => true));
echo '</div>';

echo '<div class="form-group">';
echo $this->Form->input('password', array('class' => 'form-control', 'required' => true));
echo '</div>';

if(RECAPTCHA_SWITCH == 1) {
	echo '<label>Captcha</label>';
	echo '<div class="g-recaptcha" data-sitekey="'.RECAPTCHA_SITE_KEY.'"></div>';
}

echo $this->Form->submit('Send', array('class' => 'btn btn-primary', 'title' => 'Login'));

echo $this->Form->end();