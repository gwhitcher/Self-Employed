<!DOCTYPE html>
<html>
<head>
	<?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
		<?= $this->fetch('title') ?>
    </title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo BASE_URL; ?>/assets/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!--FontAwesome-->
    <link href="<?php echo BASE_URL; ?>/assets/font-awesome/css/fontawesome-all.css" rel="stylesheet">

    <!-- Custom styles for this template -->
	<?= $this->Html->css('style.css') ?>

    <!-- Favicon -->
    <link rel="icon" href="<?php echo BASE_URL; ?>/favicon.ico" type="image/x-icon"/>

    <!--reCAPTCHA-->
    <script src="https://www.google.com/recaptcha/api.js"></script>
</head>
<body>
<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="<?php echo BASE_URL; ?>"><?php echo SITE_TITLE; ?></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo BASE_URL; ?>">Home</a>
                    </li>
                    <?php if(empty($current_user)) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo BASE_URL; ?>/login">Login</a>
                        </li>
                    <?php } else { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo BASE_URL; ?>/mileage">Mileage</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo BASE_URL; ?>/expenses">Expenses</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo BASE_URL; ?>/users">Users</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo BASE_URL; ?>/logout">Logout</a>
                    </li>
                    <?php } ?>
                </ul>
                <span class="navbar-text">
                    <?php echo SITE_DESCRIPTION; ?>
                </span>
            </div>
        </div>
    </nav>
</header>

<?= $this->Flash->render() ?>

<div class="container">
	<?= $this->fetch('content') ?>
</div>

<div class="advertisement" align="center">
    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <!-- Responsive -->
    <ins class="adsbygoogle"
         style="display:block"
         data-ad-client="ca-pub-1862231357641748"
         data-ad-slot="1935611714"
         data-ad-format="auto"
         data-full-width-responsive="true"></ins>
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
</div>

<footer>
    <p align="center">This software was developed by <a href="http://georgewhitcher.com" target="_blank">George Whitcher</a>.</p>
</footer>

<script src="<?php echo BASE_URL; ?>/assets/jquery/jquery.js"></script>
<script src="<?php echo BASE_URL; ?>/assets/popper/popper.min.js"></script>
<script src="<?php echo BASE_URL; ?>/assets/bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo BASE_URL; ?>/js/default.js"></script>
</body>
</html>