<?php
	date_default_timezone_set('America/Mexico_City');
	session_start();
	if (!isset($_SESSION['user_active_dif']) AND $_SESSION['user_active_dif'] != 1) {
		header("location: index-login.php");
		exit;
	}