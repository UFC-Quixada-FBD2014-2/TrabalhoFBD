<?php
	include_once 'FalhaAoExecutarQuery.class.php';
	include_once 'br.ufc.quixada.fbd.sgbd/Conexao.class.php';
	include_once 'FalhaPrepareStatement.class.php';
	include_once 'br.ufc.quixada.fbd.sgbd/FalhaAoCriarConexao.class.php';
	
	class RepositorioTagsPontosTuristicos{
		private $conexao;
		
		public function __construct(){
			$conexao = new Conexao();
			$this->conexao = $conexao->abrirConexao();
		}
		
		public function pegarTagsPontoTuristico($idPontoTuristico){
			
			$sqlQuery = 'SELECT * 
						 FROM TagsDePontoTuristico
					 	 WHERE idPontoTuristico = ?';
		
			if($stmt = $this->conexao->prepare($sqlQuery)){
				$stmt->bindParam(1, $idPontoTuristico);
				if($stmt->execute()){
					$tags = Array();
		
					while($resultado = $stmt->fetchAll()){
						$tag = $resultado['nome'];
							
						array_push($tags, $tag);
					}
		
					return $tags;
		
				}else{
					throw new FalhaAoExecutarQuery();
				}
			}else{
				throw new FalhaPrepareStatement();
			}
		}
		
		public function removerTagsPontoTuristico($idPontoTuristico){
			
			$sqlQuery = 'DELETE FROM TagsDePontoTuristico 
						 WHERE idPontoTuristico = ?';
		
			if($stmt = $this->conexao->prepare($sqlQuery)){
				$stmt->bindParam(1, $idPontoTuristico);
				if($stmt->execute()){
					
				}else{
					throw new FalhaAoExecutarQuery();
				}
			}else{
				throw new FalhaPrepareStatement();
			}
		}
		
		public function cadastrarTagsPontoTuristico(PontoTuristico $pontoTuristico){
		
			$tags = $pontoTuristico->getTags();
			$idPontoTuristico = $pontoTuristico->getId();
				
			$sqlQuery = 'INSERT INTO TagsDePontoTuristico 
						(idPontoTuristico, nome) VALUES (?, ?)';
		
			for($i=0; $i<count($tags); $i++){
				if($stmt = $this->conexao->prepare($sqlQuery)){
					$stmt->bindParam(1, $idPontoTuristico);
					$stmt->bindParam(2, $tags[$i]);
					
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