<?php
	include_once __DIR__.'/../controladores/ControladorLogin.class.php';
	
	$controladorLogin = new ControladorLogin();
	
	$controladorLogin->iniciarSessao();
	
	$success = null;
	if(isset($_GET['success'])){
		$success = $_GET['success'];
	}
	
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
		<div class="container">
		<?php
		
			if($success != null && $success == "false"){
				echo '
				<div class="alert alert-danger" role="alert" style="margin-top:30px;">
					<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
					<span class="sr-only">Error:</span>
					Email ou senha não correspondem.
					<button type="button" class="close" data-dismiss="alert">
					  <span aria-hidden="true">&times;</span>
					  <span class="sr-only">Close</span>
					</button>
				</div>';
			}else if($success != null && $success == "true"){
				echo '
				<div class="alert alert-success" role="alert" style="margin-top:30px;">
					<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
					<span class="sr-only">Error:</span>
					Cadastro realizado com sucesso.
					<button type="button" class="close" data-dismiss="alert">
					  <span aria-hidden="true">&times;</span>
					  <span class="sr-only">Close</span>
					</button>
				</div>';
			}
			require 'FormularioLogin.html';
		?>
		</div>
		
		<script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
		<script type="text/javascript" src="js/bootstrap/bootstrap.min.js"></script>
		<script type="text/javascript" src="js/checkbox.js"></script>
		
	</body>
</html>