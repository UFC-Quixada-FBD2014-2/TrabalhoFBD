<?php
	include_once 'br.ufc.quixada.fbd.repositorios/RepositorioTuristas.class.php';
	include_once 'br.ufc.quixada.fbd.sgbd/FalhaAoCriarConexao.class.php';
	include_once 'br.ufc.quixada.fbd.repositorios/FalhaAoExecutarQuery.class.php';
	include_once 'br.ufc.quixada.fbd.repositorios/FalhaPrepareStatement.class.php';
	include_once 'FalhaAoRemoverTurista.class.php';
	include_once 'FalhaAoCadastrarTurista.class.php';
	include_once 'br.ufc.quixada.fbd.repositorios/FalhaTuristaNaoCadastrado.class.php';
	
	Class ControladorTuristas{
		
		private $repositorioTuristas;
		
		function __construct(){
			$this->repositorioTuristas = new RepositorioTuristas();
		}
		
		function cadastrarTurista(Turista $novoTurista){
			try {
				$this->repositorioTuristas->cadastrar($novoTurista);
			} catch (Exception $e){
				throw new FalhaAoCadastrarTurista($e);
			} 
		}
		
		function removerTurista(Turista $turista){
			try {
				$this->repositorioTuristas->removerTurista($turista);
			} catch (Exception $e){
				throw new FalhaAoRemoverTurista($e);
			}
		}
		
		function removerTuristaPorId($id_turista){
			try {
				$this->repositorioTuristas->removerPorId($id_turista);
			} catch (Exception $e){
				throw new FalhaAoRemoverTurista($e);
			}
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