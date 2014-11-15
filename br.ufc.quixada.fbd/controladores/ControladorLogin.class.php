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
						
			ini_sec('session.use_only_cookies', 1);
			$cookieParametros = session_get_cookie_params();
			session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly);
			session_name($session_name);
			session_regenerate_id(true);
		}
		
		function realizarLogin(){
			
			$email = $_POST['email'];
			$senha = $_POST['senha'];
			$senha = hash('sha512', $senha);
			
			try{
				$turista = $this->repositorioTuristas->pegarTuristaPorEmail($email);
			} catch (FalhaAoBuscarTurista $e){
				throw new FalhaAoRealizarLogin();
			}
				
			if($turista != null){
				if($senha == $turista->getSenha()){
					$ip = $_SERVER['REMOTE_ADDR'];
					$user_browser = $_SERVER['HTTP_USER_AGENT'];
					$_SESSION['user_id'] = $id_user;
					$email = preg_replace("/[^a-zA-Z@.0-9_\-]+/", "", $email);
					$_SESSION['email'] = $email;
					$_SESSION['login_string'] = hash('sha512', $senha.$ip.$user_browser);
				}else{
					throw new FalhaAoRealizarLogin();
				}
			}else{
				throw new FalhaAoRealizarLogin();
			}
		}
		
		function checarLogin(){
			
			if(isset($_SESSION['username'])){
				 
				$email = $_SESSION['username']; 
				$turista = $this->repositorioTuristas->pegarTuristaPorEmail($email);
			
				if($turista != null){ 
					if(isset($_SESSION['user_id'], $_SESSION['email'], $_SESSION['login_string'])){
					
						if($turista != null){
							$id_user = $_SESSION['user_id'];
							$login_string = $_SESSION['login_string'];
							$email = $_SESSION['email'];
							$ip_address = $_SERVER['REMOTE_ADDR'];
							$user_browser = $_SERVER['HTTP_USER_AGENT'];
								
							$senha = $turista->getSenha();
							$login_check = hash('sha512', $senha.$ip_address.$user_browser);
								
							if($login_check == $login_string){
								return true;
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
			}
			
			else
				return false;
		}
	}
?>