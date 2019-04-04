<?php
	session_start();
	unset($_SESSION['favs']);
	$_SESSION['message'] = 'Cart cleared successfully';
	header('location: index.php');
	//Remove all favorites from the table and redirect to home page
	//Completed by Yichen Li
?>