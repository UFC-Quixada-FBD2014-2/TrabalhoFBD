<?php
	include_once __DIR__.'/../controladores/ControladorLogin.class.php';
	
	$controladorLogin = new ControladorLogin();
	
	$controladorLogin->iniciarSessao();

	if($controladorLogin->checarLogin()){
		header("Location:TelaInicial.php");
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Login - Tourista</title>
		<link type="text/css" rel="stylesheet" href="css/styleFormularios.css">
		<link type="text/css" rel="stylesheet" href="css/bootstrap/bootstrap.min.css">
		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	    <!--[if lt IE 9]>
	      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	    <![endif]-->
	</head>
	<body>
		<?php
			require 'FormularioLogin.html';
		?>
		<script type="text/javascript" src="js/bootstrap/bootstrap.min.js"></script>
		<script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
		<script type="text/javascript" src="js/checkbox.js"></script>
	</body>
</html>