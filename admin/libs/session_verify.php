<?php 
session_start();
if(!isset($_SESSION['adminid'])) {
	session_write_close();
	header('Location: login.php');
}
session_write_close();
?>
