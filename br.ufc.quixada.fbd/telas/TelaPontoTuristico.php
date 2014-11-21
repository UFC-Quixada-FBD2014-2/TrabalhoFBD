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
	include_once __DIR__.'/../repositorios/RepositorioVisitas.class.php';
	$repositorioPontosTuristicos = new RepositorioPontosTuristicos();
	$repositorioVisitas = new RepositorioVisitas();
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
										    <div class="row lead">
										        
										        <?php 
										        	$valorAvaliado = 0;
										        	if($login){
										        		$valorAvaliado = $repositorioPontosTuristicos->pegarValorPontoTuristicoJaAvaliadoPelo($email, $idPontoTuristico);
										        		if($valorAvaliado == -1){
										        			$valorAvaliado = 0;
										        		}
										        	}
										        	else
										        		$valorAvaliado = 0;
										        ?>
										        <div id="stars" class="starrr" data-rating='<?php echo $valorAvaliado?>'></div>
										        Sua Avaliação <span id="count"><?php echo round($valorAvaliado)?></span> estrela(s)
											</div>
										    
										    <div class="row lead">
										    	<?php 
										    		$valor = $repositorioPontosTuristicos->pegarAvaliacaoMediaPontoTuristico($idPontoTuristico);
										    	?>
										        <div id="stars-existing" class="starrr" data-rating='<?php echo round($valor)?>'></div>
										        Avaliação Média <span id="count-existing"><?php echo round($valor)?></span> estrelas(s)
										    </div>
				                        </figcaption>
				                    </figure>
				                </div>
				            </div>            
				            <div class="col-xs-12 divider text-center">
				                <div class="col-xs-12 col-sm-4 emphasis">
				                    <h2><strong id="qtd-estive"> <?php echo $repositorioVisitas->buscarTotalVisitasPelo($idPontoTuristico) ?> </strong></h2>                    
				                    <p><small>Estiveram aqui</small></p>
				                    <?php 
				                    	if($login){
				                    		if($repositorioVisitas->isMarcado($idPontoTuristico, $email)){
				                    			echo '
												<button class="btn btn-success btn-block" id="botao-estive-aqui-add" style="display:none;" ><span class="fa fa-plus-circle"></span> Estive aqui - add </button>
				                  				<button class="btn btn-success btn-block" id="botao-estive-aqui"><span class="fa fa-plus-circle"></span> Estive aqui </button>
											';
				                    		}else {
				                    			echo '
												<button class="btn btn-success btn-block" id="botao-estive-aqui-add" ><span class="fa fa-plus-circle"></span> Estive aqui - add </button>
				                  				<button class="btn btn-success btn-block" id="botao-estive-aqui" style="display:none;"><span class="fa fa-plus-circle"></span> Estive aqui </button>
											';
				                    		}
				                    	}else{
				                    		echo '
												<button class="btn btn-success btn-block" id="botao-estive-aqui-add" ><span class="fa fa-plus-circle"></span> Estive aqui - add </button>
				                  				<button class="btn btn-success btn-block" id="botao-estive-aqui" style="display:none;"><span class="fa fa-plus-circle"></span> Estive aqui </button>
											';
				                    	}
				                    ?>
				                    
				                </div>
				                <div class="col-xs-12 col-sm-4 emphasis">
				                    <h2><strong id="qtd-favoritos"><?php echo $repositorioPontosTuristicos->pegarQuantidadeDeFavoritados($idPontoTuristico);?></strong></h2>                    
				                    <p><small>Marcaram como favorito</small></p>
				                    <?php 
				                    	if($login){
				                    		$isFavorito = $repositorioPontosTuristicos->isPontoTuristicoFavorito($idPontoTuristico, $email);
				                    		if($isFavorito){
				                    			echo '<button class="btn btn-info btn-block" title="Clique aqui para desfavoritar" id="botao-favorito-favoritado"><span class="fa fa-star"></span> Favoritado <span class="fa fa-check"></span></button>';
				                    			echo '<button class="btn btn-info btn-block" id="botao-favorito-nao-favoritado" style="display:none;"><span class="fa fa-star"></span> Adicionar aos Favoritos </button>';
				                    		}else{
				                    			echo '<button class="btn btn-info btn-block" id="botao-favorito-nao-favoritado"><span class="fa fa-star"></span> Adicionar aos Favoritos </button>';
				                    			echo '<button class="btn btn-info btn-block" title="Clique aqui para desfavoritar" id="botao-favorito-favoritado" style="display:none;"><span class="fa fa-star"></span> Favoritado <span class="fa fa-check"></span></button>';
				                    		}
				                    	}else{
				                    		echo '<a href="Login.php"><button class="btn btn-info btn-block"><span class="fa fa-star"></span> Adicionar aos Favoritos </button></a>';
				                    		echo '<button class="btn btn-info btn-block" title="Clique aqui para desfavoritar" id="botao-favorito-favoritado" style="display:none;"><span class="fa fa-star"></span> Favoritado <span class="fa fa-check"></span></button>';
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
		<script>
				// Starrr plugin (https://github.com/dobtco/starrr)
				var __slice = [].slice;
		
				(function($, window) {
				  var Starrr;
		
				  Starrr = (function() {
				    Starrr.prototype.defaults = {
				      rating: void 0,
				      numStars: 5,
				      change: function(e, value) {}
				    };
		
				    function Starrr($el, options) {
				      var i, _, _ref,
				        _this = this;
		
				      this.options = $.extend({}, this.defaults, options);
				      this.$el = $el;
				      _ref = this.defaults;
				      for (i in _ref) {
				        _ = _ref[i];
				        if (this.$el.data(i) != null) {
				          this.options[i] = this.$el.data(i);
				        }
				      }
				      this.createStars();
				      this.syncRating();
				      this.$el.on('mouseover.starrr', 'span', function(e) {
				        return _this.syncRating(_this.$el.find('span').index(e.currentTarget) + 1);
				      });
				      this.$el.on('mouseout.starrr', function() {
				        return _this.syncRating();
				      });
				      this.$el.on('click.starrr', 'span', function(e) {
				        return _this.setRating(_this.$el.find('span').index(e.currentTarget) + 1);
				      });
				      this.$el.on('starrr:change', this.options.change);
				    }
		
				    Starrr.prototype.createStars = function() {
				      var _i, _ref, _results;
		
				      _results = [];
				      for (_i = 1, _ref = this.options.numStars; 1 <= _ref ? _i <= _ref : _i >= _ref; 1 <= _ref ? _i++ : _i--) {
				        _results.push(this.$el.append("<span class='glyphicon .glyphicon-star-empty'></span>"));
				      }
				      return _results;
				    };
		
				    Starrr.prototype.setRating = function(rating) {
				      if (this.options.rating === rating) {
				        rating = void 0;
				      }
				      this.options.rating = rating;
				      this.syncRating();
				      return this.$el.trigger('starrr:change', rating);
				    };
		
				    Starrr.prototype.syncRating = function(rating) {
				      var i, _i, _j, _ref;
		
				      rating || (rating = this.options.rating);
				      if (rating) {
				        for (i = _i = 0, _ref = rating - 1; 0 <= _ref ? _i <= _ref : _i >= _ref; i = 0 <= _ref ? ++_i : --_i) {
				          this.$el.find('span').eq(i).removeClass('glyphicon-star-empty').addClass('glyphicon-star');
				        }
				      }
				      if (rating && rating < 5) {
				        for (i = _j = rating; rating <= 4 ? _j <= 4 : _j >= 4; i = rating <= 4 ? ++_j : --_j) {
				          this.$el.find('span').eq(i).removeClass('glyphicon-star').addClass('glyphicon-star-empty');
				        }
				      }
				      if (!rating) {
				        return this.$el.find('span').removeClass('glyphicon-star').addClass('glyphicon-star-empty');
				      }
				    };
		
				    return Starrr;
		
				  })();
				  return $.fn.extend({
				    starrr: function() {
				      var args, option;
		
				      option = arguments[0], args = 2 <= arguments.length ? __slice.call(arguments, 1) : [];
				      return this.each(function() {
				        var data;
		
				        data = $(this).data('star-rating');
				        if (!data) {
				          $(this).data('star-rating', (data = new Starrr($(this), option)));
				        }
				        if (typeof option === 'string') {
				          return data[option].apply(data, args);
				        }
				      });
				    }
				  });
				})(window.jQuery, window);
		
				$(function() {
				  return $(".starrr").starrr();
				});
			$(document).ready(function(){

				$("#botao-estive-aqui-add").click(function(){
					

					$.ajax({
						url: "../controladores/ControladorPontosTuristicos.class.php",
						type:"POST",
						data:{acao: "add-visita", idPontoTuristico: <?php echo $idPontoTuristico?>},
						success:function(data){
							$("#botao-estive-aqui-add").css('display', 'none');
							$("#botao-estive-aqui").css('display', 'block');
							var qtd = $("#qtd-estive").text();	
							$("#qtd-estive").text(parseInt(qtd)+1);	
						}
					  });

									
				});

				
				$("#botao-favorito-nao-favoritado").click(function(){

					
					$.ajax({
						url: "../controladores/ControladorPontosTuristicos.class.php",
						type:"POST",
						data:{acao: "cadastrar_ponto_turistico_favorito", idPontoTuristico: <?php echo $idPontoTuristico?>},
						success:function(data){
							$("#botao-favorito-nao-favoritado").css('display', 'none');
							$("#botao-favorito-favoritado").css('display', 'block');
							var qtd = $("#qtd-favoritos").html();
							$("#qtd-favoritos").text(parseInt(qtd)+1);
						}
					  });
					  
				});

				$("#botao-favorito-favoritado").click(function(){
					$.ajax({
						url: "../controladores/ControladorPontosTuristicos.class.php",
						type:"POST",
						data:{acao: "remover-ponto-turistico-dos-favoritos", idPontoTuristico: <?php echo $idPontoTuristico?>},
						success:function(data){
							$("#botao-favorito-favoritado").css('display', 'none');
							$("#botao-favorito-nao-favoritado").css('display', 'block');
							var qtd = $("#qtd-favoritos").html();
							$("#qtd-favoritos").text(parseInt(qtd)-1);
						}
					  });
				});

				$('#stars').on('starrr:change', function(e, value){
				    $('#count').html(value);
				    $.ajax({
						url: "../controladores/ControladorPontosTuristicos.class.php",
						type:"POST",
						data:{acao: "cadastrar_avaliacao_ponto_turistico", valorAvaliado: value, idPontoTuristico: <?php echo $idPontoTuristico?>},
						success:function(data){

						}
					  });
				  });
				  
				 $('#stars-existing').on('starrr:change', function(e, value){
				    $('#count-existing').html(value);
				 });
			  
			});
		</script>
	</body>
</html>