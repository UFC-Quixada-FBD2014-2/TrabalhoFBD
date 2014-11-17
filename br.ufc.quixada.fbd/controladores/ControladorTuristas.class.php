<?php
	include_once __DIR__.'/../repositorios/RepositorioTuristas.class.php';
	include_once __DIR__.'/../sgbd/FalhaAoCriarConexao.class.php';
	include_once __DIR__.'/../repositorios/FalhaAoExecutarQuery.class.php';
	include_once __DIR__.'/../repositorios/FalhaPrepareStatement.class.php';
	include_once __DIR__.'/../repositorios/FalhaTuristaNaoCadastrado.class.php';
	include_once __DIR__.'/../enumeration/ConstantesMensagensFeedback.class.php';
	include_once __DIR__.'/../entidades/Turista.class.php';
	include_once __DIR__.'/../controladores/ControladorLogin.class.php';
	
	Class ControladorTuristas{
		
		private $repositorioTuristas;
		
		function __construct(){
			$this->repositorioTuristas = new RepositorioTuristas();
		}
		
		function cadastrarTurista(){
			if(isset($_POST['nome'], $_POST['senha'], $_POST['dataDeNascimento'], $_POST['preferencias'], $_POST['email'])){
				
			
				$nome = $_POST['nome'];
				$senha = $_POST['senha'];
				$senha = hash('sha512', $senha);
				$dataDeNascimento = $_POST['dataDeNascimento'];
				$preferencias = split( "," , $_POST['preferencias']);
				$email = $_POST['email'];
				
				$novoTurista = new Turista($nome, $email, $senha, $dataDeNascimento, $preferencias);
				
				try {
					$this->repositorioTuristas->cadastrar($novoTurista);
					return ConstantesMensagensFeedback::SUCESSO;
				} catch (Exception $e){
					return ConstantesMensagensFeedback::FALHA_NO_BANCO;
				} 
			}else{
				return ConstantesMensagensFeedback::FALHA_NOS_PARAMETROS;
			}
		}
		
		function removerTurista(){
			if(isset($_POST['email'])){
				try {
					
					$email = $_POST['email'];
					
					$this->repositorioTuristas->removerTurista($email);
					return ConstantesMensagensFeedback::SUCESSO;
				} catch (Exception $e){
					return ConstantesMensagensFeedback::FALHA_NO_BANCO;
				}
			}else{
				return ConstantesMensagensFeedback::FALHA_NOS_PARAMETROS;
			}
		}
		
		
		function atualizarTurista(){
			if(isset($_POST['nome'], $_POST['senha'], $_POST['dataDeNascimento'], $_POST['preferencias'], $_POST['email'])){
				$nome = $_POST['nome'];
				$senha = $_POST['senha'];
				$senha = hash('sha512', $senha);
				$dataDeNascimento = $_POST['dataDeNascimento'];
				$preferencias = $_POST['preferencias'];
				$email = $_POST['email'];
			
				$turista = new Turista($nome, $email, $senha, $dataDeNascimento, $preferencias);
				try {
					$this->repositorioTuristas->atualizarTurista($turista);
					return ConstantesMensagensFeedback::SUCESSO;
				} catch (Exception $e){
					return ConstantesMensagensFeedback::FALHA_NO_BANCO;
				}
			}else{
				return ConstantesMensagensFeedback::FALHA_NOS_PARAMETROS;
			}
		}
		
		function pegarTuristaPorEmail(){
			if(isset($_POST['email'])){
				$email = $_POST['email'];
				
				try {
					return $this->repositorioTuristas->pegarTuristaPorEmail($email);
				} catch (Exception $e){
					return ConstantesMensagensFeedback::FALHA_NO_BANCO;
				}
			}else{
				return ConstantesMensagensFeedback::FALHA_NOS_PARAMETROS;
			}
		}
		
		
		function pegarTodosOsTuristas(){
			try {
				return $this->repositorioTuristas->pegarTodosOsTuristas();
			} catch (Exception $e){
				return ConstantesMensagensFeedback::FALHA_NO_BANCO;
			}
		}
		
	}
	
	if(isset($_POST['acao'])){
		$acao = $_POST['acao'];
		$controlador = new ControladorTuristas();
		if($acao == "cadastrar"){
			$retorno = $controlador->cadastrarTurista();
			if($retorno == ConstantesMensagensFeedback::SUCESSO){
				header("Location: ../telas/Login.php?success=true");
			}else{
				header("Location: ../telas/CadastroTurista.php?success=false");
			}
		}else if($acao == "remover"){
			$retorno = $controlador->removerTurista();
			echo $retorno;
		}else if($acao == "atualizar"){
			$controlador->atualizarTurista();
		}else if($acao == "pegar_turista_email"){
			$controlador->pegarTuristaPorEmail();
		}else if($acao == "pegar_todos_turistas"){
			$controlador->pegarTodosOsTuristas();
		}else{
		
		}
	}
?>