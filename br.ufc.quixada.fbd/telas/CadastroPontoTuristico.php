<?php
	include_once __DIR__.'/../controladores/ControladorLogin.class.php';
	
	$controladorLogin = new ControladorLogin();
	
	$controladorLogin->iniciarSessao();

	if(!$controladorLogin->checarLogin()){
		header("Location:Login.php");
	}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="pt-br">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<head>
		<link rel="stylesheet" href="css/bootstrap/bootstrap.min.css">
		<link rel="stylesheet" href="css/bootstrap-tagsinput/bootstrap-tagsinput.css">
		<link rel="stylesheet" href="css/styleFormularios.css">
		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	    <!--[if lt IE 9]>
	      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	    <![endif]-->
	</head>
	<style type="text/css">
	    #mapa { height: 380px; width: 350px}
    </style>
  </head>
	<body style="margin-bottom:50px;">
		<div class="container">
			<?php
				include_once __DIR__.'/../controladores/ControladorLogin.class.php';
				
				
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
