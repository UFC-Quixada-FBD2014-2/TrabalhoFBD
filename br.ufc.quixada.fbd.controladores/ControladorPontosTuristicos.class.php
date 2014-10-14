<?php
	
	Class ControladorPontosTuristicos{
		
		private $repositorioPontosTuristicos;
			
		function __construct(){
			$this->repositorioPontosTuristicos = new RepositorioPontosTuristicos();
		}
		
		function cadastrarPontoTuristico(PontoTuristico $novoPontoTuristico){
			
		}
		
		function removerPontoTuristico(PontoTuristico $pontoTuristico){
			
		}
		
		function removerPontoTuristicoPorId($id_ponto_turistico){
				
		}
		
		function atualizarPontoTuristico(PontoTuristico $pontoTuristico){
			
		}
		
		function pegarPontoTuristicoPorId($id_ponto_turistico){
			
		}
		
		function pegarTodosOsPontosTuristicosVisitadosPorUmTurista($id_turista){
			
		}
		
		function pegarTodosOsPontosTuristicos(){
			
		}
		
		
	}
?>