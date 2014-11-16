<?php
	include_once __DIR__.'/../controladores/ControladorLogin.class.php';
	
	$controladorLogin = new ControladorLogin();
	
	$controladorLogin->iniciarSessao();
	
	$login = $controladorLogin->checarLogin();
		
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Tourista</title>
		<link href="http://fonts.googleapis.com/css?family=Open+Sans:600"
			type="text/css" rel="stylesheet" />
		<link type="text/css" rel="stylesheet" href="css/bootstrap/bootstrap.min.css"/>
		<link type="text/css" rel="stylesheet" href="css/bootstrap-vertical-tabs/bootstrap-vertical-tabs.min.css"/>
		<link href="css/styleTelaInicial.css" type="text/css" rel="stylesheet" />
		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	    <!--[if lt IE 9]>
	      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	    <![endif]-->
	</head>

	<body>

		<div id="apresentacao">
	
			<fieldset>
				<div class="campos">
					<?php 
						if(!$login){
							echo '
				                <label for="txtEnderecoTodos">Endereço:</label>
				                <input type="text" id="txtEnderecoTodos" name="txtEndereco" class="input-lg"/>
				                <input type="button" id="btnEnderecoTodos" name="btnEndereco" value="Mostrar no mapa" class="input-lg"/>';
		                }
	                ?>
	                <div class="pull-right">
	                	<?php 
	                		if($login){
	                			$email = $_SESSION['email'];
	                			$repositorioTuristas = new RepositorioTuristas();
	                			$turista = $repositorioTuristas->pegarTuristaPorEmail($email);
	                			echo '
			                		<div class="dropdown">
				                		<button id="dLabel" class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" role="button" aria-expanded="false">
											<span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
					                		<span class="caret"></span>
				                		</button>
				                		<ul class="dropdown-menu pull-right" role="menu" aria-labelledby="dLabel">
					                		<li role="presentation"><a role="menuitem" tabindex="-1" href="EditarPerfil.php"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Editar Perfil</a></li>
					                		<li role="presentation"><a role="menuitem" tabindex="-1" href="CadastroPontoTuristico.php"><span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span> Adicionar Ponto Turistico</a></li>
					                		<li role="presentation" class="divider"></li>
					                		<li role="presentation"><a role="menuitem" tabindex="-1" href="Logout.php"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> Sair</a></li>
				                		</ul>
			                		</div>';
							}else{
								echo '
	                				<a href="CadastroTurista.php" class="btn btn-link btn-primary" id="cadastrar" name="cadastrar">Cadastrar-se</a> 
									<a href="Login.php" class="btn btn-primary" id="login" name="login">Login</a>';
	                		}
						?>
					</div>
				</div>
				<?php 
					if($login){
						echo '
							<div class="col-xs-2" style="margin-top:100px;">							    
								<ul class="nav nav-tabs tabs-left">
							      	<li class="active"><a href="#todos" data-toggle="tab">Todos os Pontos</a></li>
							      	<li><a href="#preferencias" data-toggle="tab">Por Preferencias</a></li>
							      	<li><a href="#visitados" data-toggle="tab">Pontos Visitados</a></li>
							    </ul>
							</div>
							
							<div class="col-xs-10">
							    <div class="tab-content">
							      	<div class="tab-pane active" id="todos">
										<div class="campos" style="margin-top:0;margin-left:0;">
											<label for="txtEnderecoTodos">Endereço:</label>
					                		<input type="text" id="txtEnderecoTodos" name="txtEndereco" class="input-lg"/>
					                		<input type="button" id="btnEnderecoTodos" name="btnEndereco" value="Mostrar no mapa" class="input-lg"/>
										</div>
										<div id="mapaTodos"></div>
								  	</div>
							      	<div class="tab-pane" id="preferencias">
										<div class="campos" style="margin-top:0;margin-left:0;">
											<label for="txtEnderecoPreferencias">Endereço:</label>
					                		<input type="text" id="txtEnderecoPreferencias" name="txtEndereco" class="input-lg"/>
					                		<input type="button" id="btnEnderecoPreferencias" name="btnEndereco" value="Mostrar no mapa" class="input-lg"/>
										</div>
										<div id="mapaPreferencias"></div>
									</div>
							      	<div class="tab-pane" id="visitados">
										<div class="campos" style="margin-top:0;margin-left:0;">
											<label for="txtEnderecoVisitados">Endereço:</label>
					                		<input type="text" id="txtEnderecoVisitados" name="txtEndereco" class="input-lg"/>
					                		<input type="button" id="btnEnderecoVisitados" name="btnEndereco" value="Mostrar no mapa" class="input-lg"/>
										</div>
										<div id="mapaVisitados"></div>
									</div>
							    </div>
							</div>';
					}else{
						echo '<div id="mapaTodos"></div>';
					}
	
				?>
			</fieldset>	
	
		</div>
	
		<script
			src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBHju8OGAGzK6TSjG1DI8H8MNqiuFykD00&sensor=false"></script>
		<script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
		<script type="text/javascript" src="js/google-maps/markerclusterer.js"></script>
		<script type="text/javascript" src="js/google-maps/infoBox.js"></script>
		<script type="text/javascript" src="js/jquery-autocomplete.js"></script>
		<script type="text/javascript" src="js/mapaTelaInicialTodos.js"></script>
		<script type="text/javascript" src="js/mapaTelaInicialPreferencias.js"></script>
		<script type="text/javascript" src="js/mapaTelaInicialVisitados.js"></script>
		<script type="text/javascript" src="js/bootstrap/bootstrap.min.js"></script>
	
	</body>
</html>