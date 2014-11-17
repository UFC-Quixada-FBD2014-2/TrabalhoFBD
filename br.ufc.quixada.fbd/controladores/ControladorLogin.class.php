<?php
	include_once 'FalhaAoRealizarLogin.class.php';
	include_once __DIR__.'/../repositorios/RepositorioTuristas.class.php';
	include_once __DIR__.'/../enumeration/ConstantesMensagensFeedback.class.php';
	
	Class ControladorLogin{
		private $repositorioTuristas;
		
		function __construct(){
			$this->repositorioTuristas = new RepositorioTuristas();
		}
		
		function iniciarSessao(){
			$nomeDaSessao = 'sec_session_id';
			$secure = false;
			$httponly = true;
						
			ini_set('session.use_only_cookies', 1);
			$cookieParams = session_get_cookie_params();
			session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly);
			session_name($nomeDaSessao);
			session_regenerate_id(true);
			session_start();
		}
		
		function realizarLogin(){
			
			if(isset($_POST['email'], $_POST['senha'])){
				$email = $_POST['email'];
				$senha = $_POST['senha'];
				$senha = hash('sha512', $senha);
				
				try{
					$turista = $this->repositorioTuristas->pegarTuristaPorEmail($email);
				} catch (Exception $e){
					return ConstantesMensagensFeedback::FALHA_NO_BANCO;
				}
					
				if($turista != null){
					if($senha == $turista->getSenha()){

						$this->iniciarSessao();
						
						$ip = $_SERVER['REMOTE_ADDR'];
						$user_browser = $_SERVER['HTTP_USER_AGENT'];
						$email = preg_replace("/[^a-zA-Z@.0-9_\-]+/", "", $email);
						$_SESSION['email'] = $email;
						$_SESSION['login_string'] = hash('sha512', $senha.$ip.$user_browser);
						
						return ConstantesMensagensFeedback::SUCESSO;
					}else{
						return ConstantesMensagensFeedback::FALHA_LOGIN;
					}
				}else{
					return ConstantesMensagensFeedback::FALHA_LOGIN;
				}
			}else{
				return ConstantesMensagensFeedback::FALHA_NOS_PARAMETROS;
			}
		}
		
		function checarLogin(){
			if(isset($_SESSION['email'])){
				 
				$email = $_SESSION['email']; 
				$turista = $this->repositorioTuristas->pegarTuristaPorEmail($email);
			
				if($turista != null){ 
					if(isset($_SESSION['email'], $_SESSION['login_string'])){
					
						if($turista != null){
							$login_string = $_SESSION['login_string'];
							$email = $_SESSION['email'];
							$ip_address = $_SERVER['REMOTE_ADDR'];
							$user_browser = $_SERVER['HTTP_USER_AGENT'];
								
							$senha = $turista->getSenha();
							$login_check = hash('sha512', $senha.$ip_address.$user_browser);
								
							if($login_check == $login_string){
								return true;
							}else{
								return false;
							}
						}else{
							return false;
						}
					}else{
						return false;
					}
				}
				 
				else{   
					return false;
				}
			}else{
				return false;
			}
		}
	}
	
	if(isset($_POST['acao'])){
		$acao = $_POST['acao'];
		$controladorLogin = new ControladorLogin();
		
		if($acao == 'login'){
			$resultado = $controladorLogin->realizarLogin();
			
			if($resultado == ConstantesMensagensFeedback::SUCESSO){
				header("Location:../telas/TelaInicial.php");
			}else{
				header("Location: ../telas/Login.php?success=false");
			}
		}
	}
?>

	
