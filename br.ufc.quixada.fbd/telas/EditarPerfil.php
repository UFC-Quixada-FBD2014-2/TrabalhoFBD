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
	
	$preferencias = "";
	foreach ($turista->getPreferencias() as $preferencia){
		$preferencias = $preferencia.','.$preferencias; 
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
			    <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
					<form role="form" method="POST" action="../controladores/ControladorTuristas.class.php">
						<h2>Cadastre-se <small>&Eacute; gratuito.</small></h2>
						<hr class="colorgraph">
						<div class="form-group">
							<input required type="text" value="'.$turista->getNome().'" name="nome" id="nome" class="form-control input-lg" placeholder="Nome" tabindex="3">
						</div>
						<div class="form-group">
							<input required type="email" value="'.$turista->getEmail().'" name="email" id="email" class="form-control input-lg" placeholder="Endere&ccedil;o de email" tabindex="4">
						</div>
						<div class="row">
							<div class="col-xs-12 col-sm-6 col-md-6">
								<div class="form-group">
									<input required type="password" name="senha" id="senha" class="form-control input-lg" placeholder="Senha" tabindex="5">
								</div>
							</div>
							<div class="col-xs-12 col-sm-6 col-md-6">
								<div class="form-group">
									<input required type="password" name="confirmacao_senha" id="confirmacao_senha" class="form-control input-lg" placeholder="Confirme a senha" tabindex="6">
								</div>
							</div>
						</div>
			            <div class="row">
			                <div class="col-xs-12 col-sm-6 col-md-6">
			                    <div class="form-group">
			                		<input required type="text" value="'.$turista->getDataDeNascimento().'" name="dataDeNascimento" id="dataDeNascimento" class="form-control input-lg" placeholder="Data de Nascimento" tabindex="6">
			                        <p class="help-block">Data de Nascimento</p>
			        			</div>
			                </div>
			            </div>
			            
						<hr class="colorgraph">
			            <div class="row">
							<div class="cols-xs-12 col-sm-12 col-md-12">
								<p class="help-block">Adicione tags para suas prefer&ecirc;ncias</p>
								<input required type="text"  value="'.$preferencias.'" name="preferencias" id="tags" class="form-control input-lg">
							</div>
						</div>
						
						<hr class="colorgraph">
						<div class="row">
							<div class="col-xs-12 col-md-6"><input type="submit" value="Salvar" class="btn btn-primary btn-block btn-lg" tabindex="7"></div>
							<div class="col-xs-12 col-md-6"><a href="TelaInicial.php" class="btn btn-success btn-block btn-lg">Voltar</a></div>
						</div>
						<input type="hidden" name="acao" value="atualizar">
					</form>
				</div>
			</div>
		</div>';
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