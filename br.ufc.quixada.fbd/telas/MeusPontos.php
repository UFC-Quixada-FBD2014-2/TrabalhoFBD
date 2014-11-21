<?php
	include_once __DIR__.'/../controladores/ControladorLogin.class.php';
	include_once __DIR__.'/../repositorios/RepositorioPontosTuristicos.class.php';
	
	$controladorLogin = new ControladorLogin();
	
	$controladorLogin->iniciarSessao();

	$repositorioPontosTuristicos = new RepositorioPontosTuristicos();
	$login = $controladorLogin->checarLogin();
	
	$email = null;
	if($login){
		$email = $_SESSION['email'];
	}
		
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Turista</title>
<link href="http://fonts.googleapis.com/css?family=Open+Sans:600"
	type="text/css" rel="stylesheet" />
<link type="text/css" rel="stylesheet"
	href="css/bootstrap/bootstrap.min.css" />
<link rel="stylesheet"
	href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.1.0/css/font-awesome.min.css" />
<link type="text/css" rel="stylesheet"
	href="css/bootstrap-vertical-tabs/bootstrap-vertical-tabs.min.css" />
<link href="css/styleTelaInicial.css" type="text/css" rel="stylesheet" />
<link href="css/styleFormularios.css" type="text/css" rel="stylesheet" />
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
	      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	    <![endif]-->
</head>

<body>
	 
	 <div class="container">
	 	<a href="TelaInicial.php" class="btn btn-success pull-right" style="margin-top: 20px">Voltar ao início</a>
	 	 <h3>Gerenciamento de Pontos Turisticos</h3>
	 	 
	 	 <div class="clearfix"></div>
		 <hr class="colorgraph"/>
		 <ul class="list-group">
			 <?php 
			 	$pontosTuristicos = $repositorioPontosTuristicos->pegarTodosOsPontosTuristicosCadastradosPeloUsuario($email);
			 	foreach($pontosTuristicos as $pontoTuristico){
				 	echo'
				    	<li class="list-group-item">
							<p><a href="TelaPontoTuristico.php?idPontoTuristico='.$pontoTuristico->getId().'">'.$pontoTuristico->getNome().'<a></p>
							<form action="../controladores/ControladorPontosTuristicos.class.php" method="post">
								<button type="submit" class="btn btn-danger pull-right" title="Excluir"><span class="glyphicon glyphicon-remove"></span></button>
								<input type="hidden" name="acao" value="remover"/>
							<form>
							<a href="" class="btn btn-default pull-right" title="Editar"><span class="glyphicon glyphicon-edit"></span></a>							
							<div class="clearfix"></div>
						</li>
					';
			 	}
			 	if(count($pontosTuristicos) == 0){
			 		echo '
						<h5>Você não possui pontos turísticos cadastrados</h5>
						<a href="CadastroPontoTuristico.php" class="btn btn-success btn-lg">Cadastre um agora</a>
					';
			 	}
			 ?>
		 </ul>
	</div>
	<script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
	<script type="text/javascript" src="js/bootstrap/bootstrap.min.js"></script>
</body>
</html>
