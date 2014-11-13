<?php
	include_once 'FalhaAoExecutarQuery.class.php';
	include_once 'FalhaPrepareStatement.class.php';
	include_once 'br.ufc.quixada.fbd.sgbd/FalhaAoCriarConexao.class.php';
	include_once 'br.ufc.quixada.fbd.sgbd/Conexao.class.php';
	
	
	class RepositorioEnderecoPontosTuristicos{
		private $conexao;
		
		public function __construct(){
			$conexao = new Conexao();
			$this->conexao = $conexao->abrirConexao();
		}
		
		public function cadastrarEnderecoPontoTuristico(PontoTuristico $pontoTuristico){
			
			$rua = $pontoTuristico->getRua();
			$cidade = $pontoTuristico->getCidade();
			$estado = $pontoTuristico->getEstado();
			$pais = $pontoTuristico->getPais();
			$numero = $pontoTuristico->getNumero();
			$bairro = $pontoTuristico->getBairro();
			$idPontoTuristico = $pontoTuristico->getId();
			
			$sqlQuery = "INSERT INTO EnderecoPontoTuristico 
						(idPontoTuristico, rua, cidade, estado, pais, numero, bairro) 
						VALUES (?, ?, ?, ?, ?, ?, ?)";
				
			if($stmt = $this->conexao->prepare($sqlQuery)){
				$stmt->bindParam(1, $idPontoTuristico);
				$stmt->bindParam(2, $rua);
				$stmt->bindParam(3, $cidade);
				$stmt->bindParam(4, $estado);
				$stmt->bindParam(5, $pais);
				$stmt->bindParam(6, $numero);
				$stmt->bindParam(7, $bairro);
				
				if($stmt->execute()){

				}else{
					throw new FalhaAoExecutarQuery();
				}
			}else{
				throw new FalhaPrepareStatement();
			}
		}
		
		public function removerEnderecoPontoTuristico($idPontoTuristico){
			
			$sqlQuery = 'DELETE FROM EnderecoPontoTuristico WHERE idPontoTuristico = ?';
			
			if($stmt = $this->conexao->prepare($sqlQuery)){
				$stmt->bindParam(1, $sqlQuery);
				
				if($stmt->execute()){
					
				}else{
					throw new FalhaAoExecutarQuery();
				}
			}else{
				throw new FalhaPrepareStatement();
			}
		}
		
		public function atualizarEnderecoPontoTuristico(PontoTuristico $pontoTuristico){
			
			$cidade = $pontoTuristico->getCidade();
			$estado = $pontoTuristico->getEstado();
			$pais = $pontoTuristico->getPais();
			$numero = $pontoTuristico->getNumero();
			$rua = $pontoTuristico->getRua();
			$idPontoTuristico = $pontoTuristico->getId();
			$bairro =  $pontoTuristico->getBairro();
		
			$sqlQuery = 'UPDATE EnderecoPontoTuristico SET rua = ?, cidade = ?, estado = ?,
						 pais = ?, numero = ?, bairro = ?
						 WHERE idPontoTuristico = ?';
		
			if($stmt = $this->conexao->prepare($sqlQuery)){
				
				$stmt->bindParam(1, $rua);
				$stmt->bindParam(2, $cidade);
				$stmt->bindParam(3, $estado);
				$stmt->bindParam(4, $pais);
				$stmt->bindParam(5, $numero);
				$stmt->bindParam(6, $bairro);
				$stmt->bindParam(7, $idPontoTuristico);
				
				if($stmt->execute()){
				}else{
					throw new FalhaAoExecutarQuery();
				}
			}else{
				throw new FalhaPrepareStatement();
			}
		}
		
		
	}