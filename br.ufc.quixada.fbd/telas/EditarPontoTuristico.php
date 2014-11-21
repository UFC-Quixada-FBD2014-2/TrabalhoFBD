<?php
	include_once __DIR__.'/../controladores/ControladorLogin.class.php';
	include_once __DIR__.'/../repositorios/RepositorioTuristas.class.php';
	
	$controladorLogin = new ControladorLogin();
	
	$success = null;
	if(isset($_GET['success'])){
		$success = $_GET['success'];
	}
	
	$controladorLogin->iniciarSessao();
	$turista = null;
	
	if(!$controladorLogin->checarLogin()){
		header("Location:TelaInicial.php");
	}else{
		$email = $_SESSION['email'];
		$repositorioTuristas = new RepositorioTuristas();
		$turista = $repositorioTuristas->pegarTuristaPorEmail($email);
	}
	
	$tags = "";
	foreach ($turista->getTags() as $tag){
		$tags = $tag.','.$tags; 
	} 
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="pt-br">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<head>
		<link rel="stylesheet" href="css/bootstrap/bootstrap.min.css">
		<link rel="stylesheet"
			href="css/bootstrap-tagsinput/bootstrap-tagsinput.css">
		<link rel="stylesheet" href="css/styleFormularios.css">
	</head>
	<div class="container">
	<?php
		if($success != null && $success == "false"){
		echo '
				<div class="alert alert-danger" role="alert" style="margin-top:30px;">
					<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
					<span class="sr-only">Error:</span>
					Falha na Edição.
					<button type="button" class="close" data-dismiss="alert">
					  <span aria-hidden="true">&times;</span>
					  <span class="sr-only">Close</span>
					</button>
				</div>';
		}
	
		echo '
			
			<div class="container">
			
				<div class="row">
				    <div class="col-xs-12 col-sm-8 col-md-8 col-sm-offset-3 col-md-offset-2">
				    	<form role="form" action="../controladores/ControladorPontosTuristicos.class.php" method="POST">
							<h2>Cadastrar ponto turístico</h2>
							<hr class="colorgraph">
							<div class="form-group">
								<input required type="text" name="nome" id="nome" class="form-control input-lg" placeholder="*Nome" tabindex="3">
							</div>
							<div class="row">
								<div class="col-xs-12 col-sm-6 col-md-6">
									<div class="form-group">
										<input type="time" name="horarioAbertura" id="horarioAbertura" class="form-control input-lg" tabindex="5">
				                        <p class="help-block">Horário de abertura</p>
									</div>
								</div>
								<div class="col-xs-12 col-sm-6 col-md-6">
				    				<div class="form-group">
										<input type="time" name="horarioFechamento" id="horarioFechamento" class="form-control input-lg" tabindex="5">
				                        <p class="help-block">Horário de fechamento </p>
									</div>
								</div>
							</div>
				            <div class="row">
				                <div class="col-xs-12 col-sm-6 col-md-6">
				        			<input type="number" name="precoEntrada" id="precoEntrada" class="form-control input-lg" placeholder="Pre&ccedil;o da entrada" tabindex="3">
				    			</div>
				            </div><br>
				            <hr class="colorgraph">
				            <div class="row">
				        		<div class="col-xs-6 col-sm-6 col-md-6">
				    				<input required type="text" name="rua" id="rua" class="endereco form-control input-lg" placeholder="*Rua" tabindex="3"><br>
				    				<input type="number" name="numero" id="numero" class="endereco form-control input-lg" placeholder="N&uacute;mero" tabindex="3"><br>
				    				<input required type="text" name="bairro" id="bairro" class="endereco form-control input-lg" placeholder="*Bairro" tabindex="3"><br>
				        			<input required type="text" name="cidade" id="cidade" class="endereco form-control input-lg" placeholder="*Cidade" tabindex="3"><br>
				    				<input required type="text" name="estado" id="estado" class="endereco form-control input-lg" placeholder="*Estado" tabindex="3"><br>
				    				<input required type="text" name="pais" id="pais" class="endereco form-control input-lg"  placeholder="*Pa&iacute;s" tabindex="3"><br>
				        		</div>
				        		<div class="col-xs-6 col-sm-6 col-md-6">
				        			<div id="mapa"></div>
				        		</div>
				    		</div>
							<hr class="colorgraph">
							<div class="row">
								<div class="cols-xs-12 col-sm-12 col-md-12">
									<p class="help-block">Adicione tags para esse lugar</p>
									<input type="text" id="tags" name="tags" class="form-control input-lg">
								</div>
							</div>
							<hr class="colorgraph">
							<div class="form-group">
								<p class="help-block">Campos com * são obrigatórios</p>
						        <div class="col-xs-12 col-md-6"><input type="submit" value="Cadastrar" class="btn btn-primary btn-block btn-lg" tabindex="7"></div>
						        <div class="col-xs-12 col-md-6"><a href="TelaInicial.php" type="button" class="btn btn-success btn-block btn-lg" tabindex="7">Voltar</a></div>
							</div>
							<input type="hidden" name="acao" value="cadastrar">
							<input type="hidden" id="latitude" name="latitude">
							<input type="hidden" id="longitude" name="longitude">
						</form>
					</div>
				</div>
			</div>
				
		';
	?>
	</div>
	<footer>
		<script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
		<script type="text/javascript" src="js/bootstrap/bootstrap.min.js"></script>
		<script type="text/javascript"
			src="js/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>
		<script type="text/javascript" src="js/tagsInputCadastro.js"></script>
	</footer>

</html>