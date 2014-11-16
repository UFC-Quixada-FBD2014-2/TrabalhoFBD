<?php

	include_once __DIR__.'/../controladores/ControladorLogin.class.php';
	
	$controladorLogin = new ControladorLogin();
	$controladorLogin->iniciarSessao();
	
	$_SESSION = array();
	$params = session_get_cookie_params();
	setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
	session_destroy();
	setcookie('rememberme', false, time() - (3600 * 3650), '/', COOKIE_DOMAIN);	 
	header('Location: TelaInicial.php');

?>