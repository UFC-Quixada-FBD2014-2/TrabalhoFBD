<?php
	include_once __DIR__.'/../sgbd/Conexao.class.php';
	include_once 'FalhaPrepareStatement.class.php';
	include_once __DIR__.'/../sgbd/FalhaAoCriarConexao.class.php';
	include_once 'FalhaAoExecutarQuery.class.php';
	include_once __DIR__.'/../entidades/Visita.class.php';
	
	class RepositorioVisitas{
		private $conexao;
		
		public function __construct(){
			$conexao = new Conexao();
			$this->conexao = $conexao->abrirConexao();
		}
		
		public function cadastrar(Visita $visita){
			
			$idPontoTuristico = $visita->getIdPontoTuristico();
			$emailTurista = $visita->getEmailTurista();
			$data = $visita->getData();
			
			$sqlQuery = "INSERT INTO
							Visitas (idPontoTuristico, emailTurista, dataDaVisita)
							VALUES (?, ?, ?)";
			
			if($stmt = $this->conexao->prepare($sqlQuery)){
				$stmt->bindParam(1, $idPontoTuristico);
				$stmt->bindParam(2, $emailTurista);
				$stmt->bindParam(3, $data);
				if($stmt->execute()){
					
				}else{
					throw new FalhaAoExecutarQuery();
				}
			}else{
				throw new FalhaPrepareStatement();
			}
		}
		
		public function isMarcado($idPontoTuristico,$emailLogado){
			$sqlQuery = "SELECT count(*) as qtd FROM
							Visitas WHERE idPontoTuristico = ? AND emailTurista = ?";
			
			if($stmt = $this->conexao->prepare($sqlQuery)){
				$stmt->bindParam(1, $idPontoTuristico);
				$stmt->bindParam(2, $emailLogado);
				
				if($stmt->execute()){
					$resultado = $stmt->fetch();
					if($resultado['qtd'] == 1){
						return true;
					}else{
						return false;
					}
				}else{
					throw new FalhaAoExecutarQuery();
				}
			}else{
				throw new FalhaPrepareStatement();
			}
		}
		
		public function buscarTotalVisitasPelo($idPontoTuristico){
			
			$sqlQuery = "Select count(*) as qtd FROM
							Visitas WHERE idPontoTuristico = ?";
				
			if($stmt = $this->conexao->prepare($sqlQuery)){
				$stmt->bindParam(1, $idPontoTuristico);
				if($stmt->execute()){
						$resultado = $stmt->fetch();
						return $resultado['qtd'];
				}else{
					throw new FalhaAoExecutarQuery();
				}
			}else{
				throw new FalhaPrepareStatement();
			}
		}
	}