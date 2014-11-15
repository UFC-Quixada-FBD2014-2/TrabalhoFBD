<?php
	include_once __DIR__.'/../repositorios/RepositorioTuristas.class.php';
	include_once __DIR__.'/../sgbd/FalhaAoCriarConexao.class.php';
	include_once __DIR__.'/../repositorios/FalhaAoExecutarQuery.class.php';
	include_once __DIR__.'/../repositorios/FalhaPrepareStatement.class.php';
	include_once __DIR__.'/../repositorios/FalhaTuristaNaoCadastrado.class.php';
	
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
				$preferencias = $_POST['preferencias'];
				$email = $_POST['email'];
				
				$novoTurista = new Turista($nome, $email, $senha, $data_de_nascimento, $preferencias);
				
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
				$dataDeNascimento = $_POST['dataDeNascimento'];
				$preferencias = $_POST['preferencias'];
				$email = $_POST['email'];
			
				$novoTurista = new Turista($nome, $email, $senha, $data_de_nascimento, $preferencias);
				try {
					$this->repositorioTuristas->removerPorId($id_turista);
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
				//TODO: modificar tela
			}
		}else if($acao == "remover"){
			$controlador->removerTurista();
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