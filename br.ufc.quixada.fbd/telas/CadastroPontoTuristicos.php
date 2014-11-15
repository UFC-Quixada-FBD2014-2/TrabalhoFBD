<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="pt-br" xml:lang="pt-br">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<head>
		<link rel="stylesheet" href="css/bootstrap/bootstrap.min.css">
		<link rel="stylesheet" href="css/bootstrap-tagsinput/bootstrap-tagsinput.css">
		<link rel="stylesheet" href="css/styleFormularios.css">
	</head>
	<style type="text/css">
	    #mapa { height: 380px; width: 350px}
    </style>
  </head>
	<body style="margin-bottom:50px;">
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
			<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBHju8OGAGzK6TSjG1DI8H8MNqiuFykD00&sensor=false"></script>
			<script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
			<script type="text/javascript" src="js/bootstrap/bootstrap.min.js"></script>
			<script type="text/javascript" src="js/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>
			<script type="text/javascript" src="js/tagsInputCadastro.js"></script>
			<script type="text/javascript" src="js/mapa.js"></script>
		</footer>
	</body>
</html>
