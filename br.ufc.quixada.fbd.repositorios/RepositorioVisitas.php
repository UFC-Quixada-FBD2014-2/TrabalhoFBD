<?php
	include_once 'br.ufc.quixada.fbd.sgbd/Conexao.class.php';
	include_once 'FalhaPrepareStatement.class.php';
	include_once 'br.ufc.quixada.fbd.sgbd/FalhaAoCriarConexao.class.php';
	include_once 'FalhaAoExecutarQuery.class.php';
	
	class RepositorioVisitas{
		private $conexao;
		
		public function __construct(Conexao $conexao){
			$this->conexao = $conexao;
		}
		
		public function cadastrar(Visita $visita){
			$conexao = $this->conexao->abrirConexao();
			
			$idPontoTuristico = $visita->getIdPontoTuristico();
			$emailTurista = $visita->getEmailTurista();
			$data = $visita->getData();
			
			$queryName = 'query_cadastrar_visita';
			$sqlQuery = "INSERT INTO
							Visitas (idPontoTuristico, emailTurista, data)
							VALUES ($1, $2, $3)";
				
			if(pg_prepare($conexao, $queryName, $sqlQuery)){
				if(pg_execute($conexao, $queryName, array($idPontoTuristico, $emailTurista, $data))){
					pg_close($conexao);
				}else{
					throw new FalhaAoExecutarQuery();
				}
			}else{
				throw new FalhaPrepareStatement();
			}
		}
	}