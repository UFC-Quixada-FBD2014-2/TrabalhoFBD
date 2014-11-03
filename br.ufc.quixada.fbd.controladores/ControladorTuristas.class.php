<?php
	include_once 'br.ufc.quixada.fbd.repositorios/RepositorioTuristas.class.php';
	include_once 'br.ufc.quixada.fbd.excecoes/FalhaAoCriarConexao.class.php';
	include_once 'br.ufc.quixada.fbd.excecoes/FalhaAoExecutarQuery.class.php';
	include_once 'br.ufc.quixada.fbd.excecoes/PrepareStatementFalha.class.php';
	
	Class ControladorTuristas{
		
		private $repositorioTuristas;
		
		function __construct(){
			$this->repositorioTuristas = new RepositorioTuristas();
		}
		
		function cadastrarTurista(Turista $novoTurista){
			
			try {
				$this->repositorioTuristas->cadastrar($novoTurista);
			}catch (FalhaAoCriarConexao $e){
				throw $e;
			}catch (PrepareStatementFalha $e){
				throw $e;
			}catch (FalhaAoExecutarQuery $e){
				throw $e;
			}
		}
		
		function removerTurista(Turista $turista){
				
		}
		
		function removerTuristaPorId($id_turista){
			
		}
		
		function atualizarTurista(Turista $turista){
			
		}
		
		function pegarTuristaPorEmail($email){
			return new Turista($nome, $email, $senha, $idade);
		}
		
		function pegarTuristaPorId($id_turista){
			
		}
		
		function pegarTodosOsTuristas(){
			
		}
		
	}
?>