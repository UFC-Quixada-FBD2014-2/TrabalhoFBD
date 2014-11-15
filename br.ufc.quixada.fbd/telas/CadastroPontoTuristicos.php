<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="css/bootstrap/bootstrap.min.css">
		<link rel="stylesheet" href="css/bootstrap-tagsinput/bootstrap-tagsinput.css">
		<link rel="stylesheet" href="css/styleFormularios.css">
	</head>
	<div class="container">
<?php
	include_once __DIR__.'/../controladores/ControladorLogin.class.php';
	
	
	$controleLogin = new ControladorLogin();
	if($controleLogin->checarLogin() == true){
		require 'FormularioCadastroPontoTuristico.html';
	}
	require 'FormularioCadastroPontoTuristico.html';
?>
	</div>
	<footer>
		<script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
		<script type="text/javascript" src="js/bootstrap/bootstrap.min.js"></script>
		<script type="text/javascript" src="js/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>
		<script type="text/javascript" src="js/tagsInputCadastro.js"></script>
	</footer>
	
</html>
