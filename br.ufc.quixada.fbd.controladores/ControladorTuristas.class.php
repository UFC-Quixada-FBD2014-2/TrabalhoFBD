<?php
	include_once 'br.ufc.quixada.fbd.repositorios/RepositorioTuristas.class.php';
	include_once 'br.ufc.quixada.fbd.sgbd/FalhaAoCriarConexao.class.php';
	include_once 'br.ufc.quixada.fbd.repositorios/FalhaAoExecutarQuery.class.php';
	include_once 'br.ufc.quixada.fbd.repositorios/FalhaPrepareStatement.class.php';
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
				echo $e->getMessage();
			} 
		}
		
		function removerTurista(Turista $turista){
			try {
				$this->repositorioTuristas->removerTurista($turista);
			} catch (Exception $e){
				echo $e->getMessage();
			}
		}
		
		
		function atualizarTurista(Turista $turista){
			try {
				$this->repositorioTuristas->removerPorId($id_turista);
			} catch (Exception $e){
				echo $e->getMessage();
			}
		}
		
		function pegarTuristaPorEmail($email){
			try {
				return $this->repositorioTuristas->pegarTuristaPorEmail($email);
			} catch (Exception $e){
				echo $e->getMessage();
			}
		}
		
		
		function pegarTodosOsTuristas(){
			try {
				return $this->repositorioTuristas->pegarTodosOsTuristas();
			} catch (Exception $e){
				echo $e->getMessage();
			}
		}
		
	}
?>