<?php
	include_once 'br.ufc.quixada.fbd.sgbd/Conexao.class.php';
	include_once 'FalhaPrepareStatement.class.php';
	include_once 'br.ufc.quixada.fbd.sgbd/FalhaAoCriarConexao.class.php';
	include_once 'FalhaAoExecutarQuery.class.php';
	
	class RepositorioPreferenciasTurista{
		private $conexao;
		
		public function __construct(){
			$this->conexao = new Conexao();
		}
		
		public function pegarPreferenciasTurista($email){
			$conexao = $this->conexao->abrirConexao();
			
			
			$queryName = 'query_pegar_preferencias';
			$sqlQuery = 'SELECT * FROM PreferenciaDeTurista WHERE emailTurista = $1';
		
			if($stmt = pg_prepare($conexao, $queryName, $sqlQuery)){
				$result = @pg_execute($conexao, $queryName, array($email));
				if($result){
					$preferencias = Array();
					
					while($resultado = pg_fetch_array($result)){
						$preferencia = $resultado['nome'];
							
						array_push($preferencias, $preferencia);
					}
					
					pg_close($conexao);
					$this->conexao->fecharConexao();
					return $preferencias;
						
				}else{
					throw new FalhaAoExecutarQuery();
				}
			}else{
				throw new FalhaPrepareStatement();
			}
		}
		
		public function removerPreferenciasTurista($email){
			$conexao = $this->conexao->abrirConexao();
			
			$queryName = 'query_remover_preferencias';
			$sqlQuery = 'DELETE FROM PreferenciaDeTurista WHERE emailTurista = $1';
		
			if(pg_prepare($conexao, $queryName, $sqlQuery)){
				if(pg_execute($conexao, $queryName, array($email))){
					pg_close($conexao);
				}else{
					throw new FalhaAoExecutarQuery();
				}
			}else{
				throw new FalhaPrepareStatement();
			}
		}
		
		public function cadastrarPreferenciasTurista(Turista $turista){
			$conexao = $this->conexao->abrirConexao();
			
			$preferencias = $turista->getPreferencias();
			$email = $turista->getEmail();
				
			$queryName = 'query_cadastrar_preferencias';
			$sqlQuery = 'INSERT INTO PreferenciaDeTurista(emailTurista, nome) VALUES ($1, $2)';
		
			for($i=0; $i<count($preferencias); $i++){
				if(pg_prepare($conexao, $queryName, $sqlQuery)){
					if(pg_execute($conexao, $queryName, array($email, $preferencias[$i]))){
						pg_close($conexao);
					}else{
						throw new FalhaAoExecutarQuery();
					}
				}else{
					throw new FalhaPrepareStatement();
				}
			}
		}
	}