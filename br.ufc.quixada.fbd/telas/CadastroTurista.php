<?php
	include_once __DIR__.'/../controladores/ControladorLogin.class.php';
	
	$controladorLogin = new ControladorLogin();
	
	$success = null;
	if(isset($_GET['success'])){
		$success = $_GET['success'];
	}
	
	$controladorLogin->iniciarSessao();

	if($controladorLogin->checarLogin()){
		header("Location:TelaInicial.php");
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
					Falha no cadastro.
					<button type="button" class="close" data-dismiss="alert">
					  <span aria-hidden="true">&times;</span>
					  <span class="sr-only">Close</span>
					</button>
				</div>';
		}
		require 'FormularioCadastroTurista.html';
	?>
	</div>
	<footer>
		<script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
		<script type="text/javascript" src="js/bootstrap/bootstrap.min.js"></script>
		<script type="text/javascript"
			src="js/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>
		<script type="text/javascript" src="js/tagsInputCadastro.js"></script>
		<script type="text/javascript">
			$('#form-cadastro').submit(function(){
				var senha = $("#senha").val();
				var confirmacao = $("#confirmacao").val();

				if(senha != confirmacao){
					$("#mensagem-senha-erro").show();
					return false;
				}
			});
		</script>
	</footer>

</html>