<?php
	include_once 'br.ufc.quixada.fbd.sgbd/Conexao.class.php';
	include_once 'FalhaPrepareStatement.class.php';
	include_once 'br.ufc.quixada.fbd.sgbd/FalhaAoCriarConexao.class.php';
	include_once 'FalhaAoExecutarQuery.class.php';
	
	class RepositorioPreferenciasTurista{
		private $conexao;
		
		public function __construct(){
			$conexao = new Conexao();
			$this->conexao = $conexao->abrirConexao();
		}
		
		public function pegarPreferenciasTurista($email){
			
			
			$sqlQuery = 'SELECT * FROM PreferenciaDeTurista WHERE emailTurista = ?';
		
			if($stmt = $this->conexao->prepare($sqlQuery)){
				$stmt->bindParam(1, $email);
				if($stmt->execute()){
					$preferencias = Array();
					$resultados = $stmt->fetchAll();
					foreach ($resultados as $resultado){
						$preferencia = $resultado['nome'];
							
						array_push($preferencias, $preferencia);
					}
					
					return $preferencias;
						
				}else{
					throw new FalhaAoExecutarQuery();
				}
			}else{
				throw new FalhaPrepareStatement();
			}
		}
		
		public function removerPreferenciasTurista($email){
			
			$sqlQuery = 'DELETE FROM PreferenciaDeTurista WHERE emailTurista = ?';
		
			if($stmt = $this->conexao->prepare($sqlQuery)){
				$stmt->bindParam(1, $email);
				
				if($stmt->execute()){
				}else{
					throw new FalhaAoExecutarQuery();
				}
			}else{
				throw new FalhaPrepareStatement();
			}
		}
		
		public function cadastrarPreferenciasTurista(Turista $turista){
			
			$preferencias = $turista->getPreferencias();
			$email = $turista->getEmail();
				
			$sqlQuery = 'INSERT INTO PreferenciaDeTurista(emailTurista, nome) VALUES (?, ?)';
		
			for($i=0; $i<count($preferencias); $i++){
				
				if($stmt = $this->conexao->prepare($sqlQuery)){
					$stmt->bindParam(1, $email);
					$stmt->bindParam(2, $preferencias[$i]);
					
					if($stmt->execute()){
						
					}else{
						throw new FalhaAoExecutarQuery();
					}
				}else{
					throw new FalhaPrepareStatement();
				}
			}
		}
	}