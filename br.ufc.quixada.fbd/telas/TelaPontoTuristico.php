<?php
	include_once __DIR__.'/../controladores/ControladorLogin.class.php';
	
	$controladorLogin = new ControladorLogin();
	
	$controladorLogin->iniciarSessao();
	
	$login = $controladorLogin->checarLogin();
	
	$turista;
	if($login){
		$email = $_SESSION['email'];
		$repositorioTuristas = new RepositorioTuristas();
		$turista = $repositorioTuristas->pegarTuristaPorEmail($email);
	}
		
?>

<?php 

	if(!isset($_GET['idPontoTuristico'])){
		header("location:TelaInicial.php");
	}else{
		$idPontoTuristico = $_GET['idPontoTuristico'];
	}
	
	include_once __DIR__.'/../repositorios/RepositorioPontosTuristicos.class.php';
	$repositorioPontosTuristicos = new RepositorioPontosTuristicos();
	$pontoTuristico = $repositorioPontosTuristicos->pegarPontoTuristicoPorId($idPontoTuristico);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Tourista</title>
		<link href="http://fonts.googleapis.com/css?family=Open+Sans:600"
			type="text/css" rel="stylesheet" />
		<link type="text/css"  rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" />
		<link type="text/css" rel="stylesheet" href="css/bootstrap/bootstrap.min.css"/>
		<link type="text/css" rel="stylesheet" href="css/bootstrap-vertical-tabs/bootstrap-vertical-tabs.min.css"/>
		<link href="css/styleTelaInicial.css" type="text/css" rel="stylesheet" />
		<link href="css/styleTelaPontoTuristico.css" type="text/css" rel="stylesheet" />
		
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
						/*if(!$login){
							echo '
				                <label for="txtEndereco">Endereço:</label>
				                <input type="text" id="txtEndereco" name="txtEndereco" class="input-lg"/>
				                <input type="button" id="btnEndereco" name="btnEndereco" value="Mostrar no mapa" class="input-lg"/>';
		                }*/
	                ?>
	                <div class="pull-right">
	                	<?php 
	                		if($login){
	                			
	                			/*echo '
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
			                		</div>';*/
							}else{
								echo '
	                				<a href="CadastroTurista.php" class="btn btn-link btn-primary" id="cadastrar" name="cadastrar">Cadastrar-se</a> 
									<a href="Login.php" class="btn btn-primary" id="login" name="login">Login</a>';
	                		}
						?>
					</div>
				</div>
				
				<?php for($i=0;$i<5;$i++) echo "<br/>"?>
				
				<div class="container" style="magin-top:2000px !important;">
					<div class="row">
						<div class="container">
				    	 <div class="well profile">
				            <div class="col-sm-12">
				            
				            	<?php 
				            		$nome = $pontoTuristico->getNome();
				            		$tags = $tags = $pontoTuristico->getTags();
				            		$rua = $pontoTuristico->getRua();
				            		$numero = $pontoTuristico->getNumero();
				            		$bairro = $pontoTuristico->getBairro();
				            		$cidade = $pontoTuristico->getCidade();
				            		$estado = $pontoTuristico->getEstado();
				            		$horarioAbertura = $pontoTuristico->getHorarioAbertura();
				            		$horarioFechamento = $pontoTuristico->getHorarioFechamento();
				            		$precoEntrada = $pontoTuristico->getPrecoEntrada();
				            	?>
				                <div class="col-xs-12 col-sm-8">
				                  <?php echo " <h2>".$nome."</h2>" ?>
				                    <p><strong>Sobre: </strong> Web Designer / UI. </p>
				                    <p><strong>Descrição: </strong> Read, out with friends, listen to music, draw and learn new things. 
				                        Lorem Ipsum, Lorem Ipsum Lorem IpsumLorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum
				                    </p>
				                   <?php  
				                   		echo '<p>
												<strong> Endereco: </strong> 
													'.$rua.', '.$numero.' - '.
													$bairro.' - '.$cidade.' - '.
													$estado.'
											</p>';
				                   		
				                   		echo '
											<p>
												<strong> Horário de Abertura: '.$horarioAbertura.' </strong> 
											</p>
										';
				                   		
				                   		echo '
											<p>
												<strong> Horário de Fechamento: '.$horarioFechamento.' </strong>
											</p>
										';
				                   		
				                   		echo '
											<p>
												<strong> Preço de Entrada: R$'.$precoEntrada.' </strong>
											</p>
										';
				                   
				                   ?>
				                   
				                   <br />
				                    <p><strong>Tags: </strong>
				                    	<?php 
					                    	for($i = 0; $i < count($tags); $i++){
					                    		echo '<span class="tags">'.$tags[$i].'</span> ';
					                    	}
				                    	?>
				                    </p>
				                    
				                </div>             
				                <div class="col-xs-12 col-sm-4 text-center">
				                    <figure>
				                        <img src="http://www.localcrimenews.com/wp-content/uploads/2013/07/default-user-icon-profile.png" alt="" class="img-circle img-responsive">
				                        <figcaption class="ratings">
				                            <p>Avaliação
				                            <a href="#">
				                                <span class="fa fa-star"></span>
				                            </a>
				                            <a href="#">
				                                <span class="fa fa-star"></span>
				                            </a>
				                            <a href="#">
				                                <span class="fa fa-star"></span>
				                            </a>
				                            <a href="#">
				                                <span class="fa fa-star"></span>
				                            </a>
				                            <a href="#">
				                                 <span class="fa fa-star-o"></span>
				                            </a> 
				                            </p>
				                        </figcaption>
				                    </figure>
				                </div>
				            </div>            
				            <div class="col-xs-12 divider text-center">
				                <div class="col-xs-12 col-sm-4 emphasis">
				                    <h2><strong> 20,7K </strong></h2>                    
				                    <p><small>Estiveram aqui</small></p>
				                    <button class="btn btn-success btn-block"><span class="fa fa-plus-circle"></span> Estive aqui </button>
				                </div>
				                <div class="col-xs-12 col-sm-4 emphasis">
				                    <h2><strong>245</strong></h2>                    
				                    <p><small>Marcaram como favorito</small></p>
				                    <?php 
				                    	if($login){
				                    		$isFavorito = $repositorioPontosTuristicos->isPontoTuristicoFavorito($idPontoTuristico, $email);
				                    		if($isFavorito){
				                    			echo '<button class="btn btn-info btn-block"><span class="fa fa-star"></span> Favorito Ja</button>';
				                    		}else{
				                    			echo '<button class="btn btn-info btn-block"><span class="fa fa-star"></span> Adicionar aos Favoritos </button>';
				                    		}
				                    	}else{
				                    		echo '<button class="btn btn-info btn-block"><span class="fa fa-star"></span> NNAdicionar aos Favoritos </button>';
				                    	}
				                    ?>
				                    
				                </div>
				                
				                <div class="col-xs-12 col-sm-4 emphasis">
				                    <h2><strong>245</strong></h2>                    
				                    <p><small>Compartilhamentos</small></p>
				                    <button class="btn btn-primary btn-block"><span class="fa fa-facebook"></span>  Compartilhar Local </button>
				                </div>
				                
				            </div>
				    	 </div>                 
						</div>
					</div>
				</div>
				<?php 
					if($login){
						/*echo '
							<div class="col-xs-2" style="margin-top:100px;">
								<h3>Exbir no mapa</h3>							    
								<ul class="nav nav-tabs tabs-left">
							      	<li class="active"><a>Todos os Pontos</a></li>
							      	<li><a href="Preferencias.php">Por Preferencias</a></li>
							      	<li><a href="Visitados.php">Pontos Visitados</a></li>
							    </ul>
							</div>
							
							<div class="col-xs-10">
							    <div class="tab-content">
							      	<div class="tab-pane active" id="todos">
										<div class="campos" style="margin-top:0;margin-left:0;">
											<label for="txtEndereco">Endereço:</label>
					                		<input type="text" id="txtEndereco" name="txtEndereco" class="input-lg"/>
					                		<input type="button" id="btnEndereco" name="btnEndereco" value="Mostrar no mapa" class="input-lg"/>
										</div>
										
								  	</div>
							    </div>
							</div>';*/ //TODO
					}else{
						
					}
	
				?>
			</fieldset>	
	
		</div>
	
		<script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
		<script type="text/javascript" src="js/bootstrap/bootstrap.min.js"></script>
	
	</body>
</html>