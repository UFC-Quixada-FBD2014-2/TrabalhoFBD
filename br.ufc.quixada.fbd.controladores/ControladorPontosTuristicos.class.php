<?php
	include_once 'br.ufc.quixada.fbd.repositorios/RepositorioPontosTuristicos.class.php';
	include_once 'br.ufc.quixada.fbd.sgbd/FalhaAoCriarConexao.class.php';
	include_once 'br.ufc.quixada.fbd.repositorios/FalhaAoExecutarQuery.class.php';
	include_once 'br.ufc.quixada.fbd.repositorios/FalhaPrepareStatement.class.php';
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
				
			}
		}
				
		function removerPontoTuristicoPorId(PontoTuristico $pontoTuristico){
			try {
				$this->repositorioPontosTuristicos->remover($pontoTuristico);
			} catch (Exception $e){
				
			}
		}
		
		function atualizarPontoTuristico(PontoTuristico $pontoTuristico){
			try {
				$this->repositorioPontosTuristicos->atualizar($pontoTuristico);
			} catch (Exception $e){
				throw new FalhaAoAtualizarPontoTuristico($e);
			}
		}
		
		function pegarPontoTuristicoPorId($idPontoTuristico){
			try {
				return $this->repositorioPontosTuristicos->pegarPontoTuristicoPorId($idPontoTuristico);
			} catch (Exception $e){
				
			}
		}
		
		function pegarTodosOsPontosTuristicosVisitadosPorUmTurista($idTurista){
			try {
				return $this->repositorioPontosTuristicos->pegarTodosOsPontosTuristicosVisitadosPorUmTurista($idTurista);
			} catch (Exception $e){
				
			}
		}
		
		function pegarTodosOsPontosTuristicos(){
			try {
				return $this->repositorioPontosTuristicos->pegarTodosOsTuristas();
			} catch (Exception $e){
			
			}
		}
		
		
	}
?>