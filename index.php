<?php

	require_once 'core/init.php';
	Helper::getHeader('Algebra Contacts');
?>
<div class="row">
	<div class="col-md-8 col-md-offset-2">
		<div class="jumbotron">
			<div class="container">
				<h1>Algebra Contacts</h1>
				<a class="btn btn-primary btn-lg" href="login.php" role="button">Sign in</a>
				or
				<a class="btn btn-primary btn-lg" href="register.php" role="button">Create an Account</a>
			</div>
		</div>
	</div>
</div>
   
<?php
	Helper::getFooter();
?>