<?php
	session_start();
	//check if product is already in the favorites
	if(!in_array($_GET['id'], $_SESSION['favs'])){
		array_push($_SESSION['favs'], $_GET['id']);
		$_SESSION['message'] = 'Product added to favorites';
	}
	else{
		$_SESSION['message'] = 'Product already in favorites';
	}
	header('location: favorites.php');
?>