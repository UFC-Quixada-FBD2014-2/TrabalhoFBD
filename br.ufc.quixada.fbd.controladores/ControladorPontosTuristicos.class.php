<?php
	include_once 'br.ufc.quixada.fbd.repositorios/RepositorioPontosTuristicos.class.php';
	include_once 'br.ufc.quixada.fbd.sgbd/FalhaAoCriarConexao.class.php';
	include_once 'br.ufc.quixada.fbd.repositorios/FalhaAoExecutarQuery.class.php';
	include_once 'br.ufc.quixada.fbd.repositorios/FalhaPrepareStatement.class.php';
	include_once 'FalhaAoRemoverPontoTuristico.class.php';
	include_once 'FalhaAoCadastrarPontoTuristico.class.php';
	include_once 'br.ufc.quixada.fbd.repositorios/FalhaPontoTuristicoNaoCadastrado.class.php';

	Class ControladorPontosTuristicos{
		
		private $repositorioPontosTuristicos;
			
		function __construct(){
			$this->repositorioPontosTuristicos = new RepositorioPontosTuristicos();
		}
		
		function cadastrarPontoTuristico(PontoTuristico $novoPontoTuristico){
			try {
				$this->repositorioPontosTuristicos->cadastrar($novoPontoTuristico);
			} catch (Exception $e){
				throw new FalhaAoCadastrarPontoTuristico($e);
			}
		}
				
		function removerPontoTuristicoPorId(PontoTuristico $pontoTuristico){
			try {
				$this->repositorioPontosTuristicos->removerPontoTuristico($pontoTuristico);
			} catch (Exception $e){
				throw new FalhaAoRemoverPontoTuristico($e);
			}
		}
		
		function atualizarPontoTuristico(PontoTuristico $pontoTuristico){
			try {
				$this->repositorioPontosTuristicos->atualizarPontoTuristico($pontoTuristico);
			} catch (Exception $e){
				throw new FalhaAoAtualizarPontoTuristico($e);
			}
		}
		
		function pegarPontoTuristicoPorId($idPontoTuristico){
			try {
				$this->repositorioPontosTuristicos->pegarPontoTuristicoPorId($idPontoTuristico);
			} catch (Exception $e){
				throw new FalhaAoBuscarPontoTuristico($e);
			}
		}
		
		function pegarTodosOsPontosTuristicosVisitadosPorUmTurista($idTurista){
			try {
				$this->repositorioPontosTuristicos->pegarTodosOsPontosTuristicosVisitadosPorUmTurista($idTurista);
			} catch (Exception $e){
				throw new FalhaAoBuscarPontoTuristico($e);
			}
		}
		
		function pegarTodosOsPontosTuristicos(){
			try {
				$this->repositorioPontosTuristicos->pegarTodosOsTuristas();
			} catch (Exception $e){
				throw new FalhaAoBuscarPontoTuristico($e);
			}
		}
		
		
	}
?>