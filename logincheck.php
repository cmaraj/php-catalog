<?php
session_start();
if(!isset($_SESSION['cameracatalog123!'])) {
	$thisRef = basename($_SERVER['PHP_SELF']);
	$_SESSION['ref'] = $thisRef;
	header("Location:login.php");
}
?>