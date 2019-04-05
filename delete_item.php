<?php
	session_start();
 
	//remove the id from our cart array
	$key = array_search($_GET['id'], $_SESSION['favs']);
	array_splice($_SESSION['favs'],$key,1);
	$_SESSION['message'] = "Product deleted from favorites";
	header('location: favorites.php');
?>