<?php

	require_once 'core/init.php';
	Helper::getHeader('registratiorn | Algebra Contacts');
	DB::getInstance()->update('users',3, array (
	'username' 	=> 'pero',
	'name'		=> 'Pero'
	));
	

	echo '<pre>';
	var_dump(DB::getInstance());
	echo '</pre>';
?>

<?php
Helper::getFooter();
?>