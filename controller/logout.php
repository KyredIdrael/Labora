<?php
	session_start();
	unset($_SESSION['id']);
	unset($_SESSION['email']);
	unset($_SESSION['nivelAcesso']);
	unset($_SESSION);
	session_destroy();
	header("Location: ../view/public.php");
?>