<?php
	include_once 'FalhaAoExecutarQuery.class.php';
	include_once 'br.ufc.quixada.fbd.sgbd/Conexao.class.php';
	include_once 'FalhaPrepareStatement.class.php';
	include_once 'br.ufc.quixada.fbd.sgbd/FalhaAoCriarConexao.class.php';
	
	class RepositorioTagsPontosTuristicos{
		private $conexao;
		
		public function __construct(Conexao $conexao){
			$this->conexao = $conexao;
		}
		
		public function pegarTagsPontoTuristico($idPontoTuristico){
			$conexao = $this->conexao->abrirConexao();
		
			$queryName = 'query_pegar_todas_as_tags';
			$sqlQuery = 'SELECT * FROM TagsDePontoTuristico WHERE idPontoTuristico = $1';
		
			if(pg_prepare($conexao, $queryName, $sqlQuery)){
				$result = @pg_execute($conexao, $queryName, array($idPontoTuristico));
				if($result){
					$tags = Array();
		
					while($resultado = pg_fetch_array($result)){
						$tag = $resultado['nome'];
							
						array_push($tags, $tag);
					}
		
					$this->conexao->fecharConexao();
					return $tags;
		
				}else{
					throw new FalhaAoExecutarQuery();
				}
			}else{
				throw new FalhaPrepareStatement();
			}
		}
		
		public function removerTagsPontoTuristico($idPontoTuristico){
			$conexao = $this->conexao->abrirConexao();
		
			$queryName = 'query_remover_tags';
			$sqlQuery = 'DELETE FROM TagsDePontoTuristico WHERE idPontoTuristico = $1';
		
			if(pg_prepare($conexao, $queryName, $sqlQuery)){
				if(pg_execute($conexao, $queryName, array($idPontoTuristico))){
					$this->conexao->fecharConexao();
				}else{
					throw new FalhaAoExecutarQuery();
				}
			}else{
				throw new FalhaPrepareStatement();
			}
		}
		
		public function cadastrarTagsPontoTuristico(PontoTuristico $pontoTuristico){
		
			$conexao = $this->conexao->abrirConexao();
		
			$tags = $pontoTuristico->getTags();
			$idPontoTuristico = $pontoTuristico->getId();
				
			$queryName = 'query_cadastrar_preferencias';
			$sqlQuery = 'INSERT INTO TagsDePontoTuristico (idPontoTuristico, nome) VALUES ($1, $2)';
		
			for($i=0; $i<count($tags); $i++){
				if(pg_prepare($conexao, $queryName, $sqlQuery)){
					if(pg_execute($conexao, $queryName, array($idPontoTuristico, $tags[i]))){
		
						$this->conexao->fecharConexao();
					}else{
						throw new FalhaAoExecutarQuery();
					}
				}else{
					throw new FalhaPrepareStatement();
				}
			}
				
		}
	}