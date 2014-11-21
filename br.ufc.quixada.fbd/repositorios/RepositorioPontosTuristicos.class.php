<?php
	include_once __DIR__.'/../sgbd/Conexao.class.php';
	include_once 'FalhaPrepareStatement.class.php';
	include_once 'RepositorioTagsPontosTuristicos.class.php';
	include_once 'RepositorioEnderecoPontosTuristicos.class.php';
	include_once __DIR__.'/../sgbd/FalhaAoCriarConexao.class.php';
	include_once 'FalhaAoExecutarQuery.class.php';
	include_once __DIR__.'/../entidades/PontoTuristico.class.php';
	
	Class RepositorioPontosTuristicos{
		private $conexao;
		private $repositorioTagsPontosTuristicos;
		private $repositorioEnderecoPontosTuristicos;
		
		public function __construct(){
			$conexao = new Conexao();
			$this->conexao = $conexao->abrirConexao();
			$this->repositorioTagsPontosTuristicos = new RepositorioTagsPontosTuristicos();
			$this->repositorioEnderecoPontosTuristicos = new RepositorioEnderecoPontosTuristicos();
		}
		
		public function cadastrar(PontoTuristico $novoPontoTuristico, $emailLogado){
			
			
			$nome = $novoPontoTuristico->getNome();
			$latitude = $novoPontoTuristico->getLatitude();
			$longitude = $novoPontoTuristico->getLongitude();
			$horarioAbertura = $novoPontoTuristico->getHorarioAbertura();
			$horarioFechamento = $novoPontoTuristico->getHorarioFechamento();
			$precoEntrada = $novoPontoTuristico->getPrecoEntrada();
				
			$sqlQuery = "INSERT INTO 
							PontoTuristico (nome, latitude, longitude, precoDaEntrada, horarioAbertura, horarioFechamento) 
							VALUES (?, ?, ?, ?, ?, ?) RETURNING idPontoTuristico";
			
			
			
			if($stmt = $this->conexao->prepare($sqlQuery)){
				$stmt->bindParam(1, $nome);
				$stmt->bindParam(2, $latitude);
				$stmt->bindParam(3, $longitude);
				$stmt->bindParam(4, $precoEntrada);
				$stmt->bindParam(5, $horarioAbertura);
				$stmt->bindParam(6, $horarioFechamento);
				
				
				if($idPontoTuristico = $stmt->execute()){
					$idPontoTuristico = $stmt->fetch();
					$novoPontoTuristico->setId($idPontoTuristico[0]);
					
					
					try{
						$this->repositorioEnderecoPontosTuristicos->cadastrarEnderecoPontoTuristico($novoPontoTuristico);
						$this->repositorioTagsPontosTuristicos->cadastrarTagsPontoTuristico($novoPontoTuristico);
						$this->salvarCadastradoPor($idPontoTuristico[0], $emailLogado);
					}catch(Exception $e){
					}
						
				}else{
					throw new FalhaAoExecutarQuery();
				}
			}else{
				throw new FalhaPrepareStatement();
			}
		}
		
		public function remover($idPontoTuristico){
			
			
			$sqlQuery = 'DELETE FROM PontoTuristico WHERE idPontoTuristico = ?';
				
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
		
		public function atualizar(PontoTuristico $pontoTuristico){
			
			$nome = $pontoTuristico->getNome();
			$latitude = $pontoTuristico->getLatitude();
			$longitude = $pontoTuristico->getLongitude();
			$horarioAbertura = $pontoTuristico->getHorarioAbertura();
			$horarioFechamento = $pontoTuristico->getHorarioFechamento();
			$precoEntrada = $pontoTuristico->getPrecoEntrada();
			$idPontoTuristico = $pontoTuristico->getId();
		
			$sqlQuery = 'UPDATE PontoTuristico SET nome = ?, latitude = ?, 
					longitude = ?, precoDaEntrada = ?, horarioAbertura = ?, horarioFechamento = ?
					WHERE idPontoTuristico = ?';
				
			if($stmt = $this->conexao->prepare($sqlQuery)){
				$stmt->bindParam(1, $nome);
				$stmt->bindParam(2, $latitude);
				$stmt->bindParam(3, $longitude);
				$stmt->bindParam(4, $precoEntrada);
				$stmt->bindParam(5, $horarioAbertura);
				$stmt->bindParam(6, $horarioFechamento);
				$stmt->bindParam(7, $idPontoTuristico);
				
				if($stmt->execute()){
					try{
						$this->repositorioTagsPontosTuristicos->removerTagsPontoTuristico($idPontoTuristico);
						$this->repositorioTagsPontosTuristicos->cadastrarTagsPontoTuristico($turista);
						$this->repositorioEnderecoPontosTuristicos->atualizarEnderecoPontoTuristico($pontoTuristico);
					}catch (Exception $e){
						throw $e;
					}
				}else{
					throw new FalhaAoExecutarQuery();
				}
			}else{
				throw new FalhaPrepareStatement();
			}
		}
		
		
		public function pegarPontoTuristicoPorId($idPontoTuristico){
			
			$sqlQuery = 'SELECT * 
							FROM PontoTuristico PT, EnderecoPontoTuristico EPT 
							WHERE PT.idPontoTuristico = ? 
							AND PT.idPontoTuristico = EPT.idPontoTuristico LIMIT 1';
				
			if($stmt = $this->conexao->prepare($sqlQuery)){
				$stmt->bindParam(1, $idPontoTuristico);
				
				if($stmt->execute()){
					$resultado = $stmt->fetch();
					
					if($resultado){
						$nome = $resultado['nome'];
						$latitude = $resultado['latitude'];
						$longitude = $resultado['longitude'];
						$cidade = $resultado['cidade'];
						$estado = $resultado['estado'];
						$bairro = $resultado['bairro'];
						$pais = $resultado['pais'];
						$rua = $resultado['rua'];
						$numero = $resultado['numero'];
						$preco_entrada = $resultado['precodaentrada'];
						$horario_abertura = $resultado['horarioabertura'];
						$horario_fechamento = $resultado['horariofechamento'];
						$tags = $this->repositorioTagsPontosTuristicos->pegarTagsPontoTuristico($idPontoTuristico);
							
						$pontoTuristico = new PontoTuristico($nome, $latitude, $longitude, $cidade, $estado, $pais, $rua, $numero,$bairro, $preco_entrada, $horario_abertura, $horario_fechamento, $tags, $idPontoTuristico);
							
						return $pontoTuristico;
						
					}else return null;
				}else{
					throw new FalhaAoExecutarQuery();
				}
			}else{
				throw new FalhaPrepareStatement();
			}
		}
		
		public function pegarTodosOsPontosTuristicos(){
			
			$sqlQuery = 'SELECT *
							FROM PontoTuristico PT, EnderecoPontoTuristico EPT 
							WHERE EPT.idPontoTuristico = PT.idPontoTuristico';
				
			if($stmt = $this->conexao->prepare($sqlQuery)){
				if($stmt->execute()){
					
					
					$pontosTuristicos = Array();
					$resultados = $stmt->fetchAll();
					foreach ($resultados as $resultado){
						
						$idPontoTuristico = $resultado['idpontoturistico'];
						$nome = $resultado['nome'];
						$latitude = $resultado['latitude'];
						$longitude = $resultado['longitude'];
						$cidade = $resultado['cidade'];
						$estado = $resultado['estado'];
						$pais = $resultado['pais'];
						$rua = $resultado['rua'];
						$bairro = $resultado['bairro'];
						$numero = $resultado['numero'];
						$precoEntrada = $resultado['precodaentrada'];
						$horarioAbertura = $resultado['horarioabertura'];
						$horarioFechamento = $resultado['horariofechamento'];
						$tags = $this->repositorioTagsPontosTuristicos->pegarTagsPontoTuristico($idPontoTuristico);
						
						$pontoTuristico = new PontoTuristico($nome, $latitude, $longitude, $cidade, $estado, $pais, $rua, $numero, $bairro, $precoEntrada, $horarioAbertura, $horarioFechamento, $tags, $idPontoTuristico);
						
						array_push($pontosTuristicos, $pontoTuristico);
					}
						
					return $pontosTuristicos;
		
				}else{
					throw new FalhaAoExecutarQuery();
				}
			}else{
				throw new FalhaPrepareStatement();
			}
		}	
		
		public function pegarTodosOsPontosTuristicosVisitadosPorUmTurista($email){
			
			$sqlQuery = 'SELECT * 
							FROM PontoTuristico PT, EnderecoPontoTuristico EPT, Visitas V 
							WHERE EPT.idPontoTuristico = PT.idPontoTuristico 
							AND V.idPontoTuristico = PT.idPontoTuristico
							AND V.emailTurista = ?';
			
			if($stmt = $this->conexao->prepare($sqlQuery)){
				$stmt->bindParam(1, $email);
				if($stmt->execute()){
					$pontosTuristicos = Array();
			
					$resultados = $stmt->fetchAll();
					foreach($resultados as $resultado){
			
						$idPontoTuristico = $resultado['idpontoturistico'];
						$nome = $resultado['nome'];
						$latitude = $resultado['latitude'];
						$longitude = $resultado['longitude'];
						$cidade = $resultado['cidade'];
						$estado = $resultado['estado'];
						$pais = $resultado['pais'];
						$rua = $resultado['rua'];
						$bairro = $resultado['bairro'];
						$numero = $resultado['numero'];
						$precoEntrada = $resultado['precodaentrada'];
						$horarioAbertura = $resultado['horarioabertura'];
						$horarioFechamento = $resultado['horariofechamento'];
						$tags = $this->repositorioTagsPontosTuristicos->pegarTagsPontoTuristico($idPontoTuristico);
			
						$pontoTuristico = new PontoTuristico($nome, $latitude, $longitude, $cidade, $estado, $pais, $rua, $numero, $bairro, $precoEntrada, $horarioAbertura, $horarioFechamento, $tags, $idPontoTuristico);
			
						array_push($pontosTuristicos, $pontoTuristico);
					}
			
					return $pontosTuristicos;
			
				}else{
					throw new FalhaAoExecutarQuery();
				}
			}else{
				throw new FalhaPrepareStatement();
			}
		}
		
		public function pegarTodosOsPontosPorPreferencias($email){
				
			$sqlQuery = 'SELECT *
							FROM PontoTuristico PT, EnderecoPontoTuristico EPT
							WHERE EPT.idPontoTuristico = PT.idPontoTuristico
							AND EXISTS (SELECT * FROM TagDePontoTuristico TPT, PreferenciaDeTurista PDT 
										WHERE PDT.emailTurista = ?
										AND TPT.idPontoTuristico = PT.idPontoTuristico
										AND TPT.nome LIKE PDT.nome)';
				
			if($stmt = $this->conexao->prepare($sqlQuery)){
				$stmt->bindParam(1, $email);
				if($stmt->execute()){
					$pontosTuristicos = Array();
						
					$resultados = $stmt->fetchAll();
					foreach($resultados as $resultado){
							
						$idPontoTuristico = $resultado['idpontoturistico'];
						$nome = $resultado['nome'];
						$latitude = $resultado['latitude'];
						$longitude = $resultado['longitude'];
						$cidade = $resultado['cidade'];
						$estado = $resultado['estado'];
						$pais = $resultado['pais'];
						$rua = $resultado['rua'];
						$bairro = $resultado['bairro'];
						$numero = $resultado['numero'];
						$precoEntrada = $resultado['precodaentrada'];
						$horarioAbertura = $resultado['horarioabertura'];
						$horarioFechamento = $resultado['horariofechamento'];
						$tags = $this->repositorioTagsPontosTuristicos->pegarTagsPontoTuristico($idPontoTuristico);
							
						$pontoTuristico = new PontoTuristico($nome, $latitude, $longitude, $cidade, $estado, $pais, $rua, $numero, $bairro, $precoEntrada, $horarioAbertura, $horarioFechamento, $tags, $idPontoTuristico);
												
						array_push($pontosTuristicos, $pontoTuristico);
					}
						
					return $pontosTuristicos;
						
				}else{
					throw new FalhaAoExecutarQuery();
				}
			}else{
				throw new FalhaPrepareStatement();
			}
		}
		
		private function salvarCadastradoPor($idPontoTuristico, $emailLogado){
			$sqlQuery = 'INSERT INTO Cadastrou VALUES (?, ?)';
			
			
			if($stmt = $this->conexao->prepare($sqlQuery)){
				$stmt->bindParam(1, $idPontoTuristico);
				$stmt->bindParam(2, $emailLogado);
				if($stmt->execute()){
					
				}else{
					throw new FalhaAoExecutarQuery();
				}
			}else{
				throw new FalhaPrepareStatement();
			}
		}
		
		public function pegarTodosOsPontosTuristicosCadastradosPeloUsuario($email){
			$sqlQuery = 'SELECT *
							FROM PontoTuristico PT, EnderecoPontoTuristico EPT, Cadastrou C
							WHERE EPT.idPontoTuristico = PT.idPontoTuristico
							AND C.idPontoTuristico = PT.idPontoTuristico
							AND C.emailTurista = ?';
				
			if($stmt = $this->conexao->prepare($sqlQuery)){
				$stmt->bindParam(1, $email);
				if($stmt->execute()){
					$pontosTuristicos = Array();
						
					$resultados = $stmt->fetchAll();
					foreach($resultados as $resultado){
							
						$idPontoTuristico = $resultado['idpontoturistico'];
						$nome = $resultado['nome'];
						$latitude = $resultado['latitude'];
						$longitude = $resultado['longitude'];
						$cidade = $resultado['cidade'];
						$estado = $resultado['estado'];
						$pais = $resultado['pais'];
						$rua = $resultado['rua'];
						$bairro = $resultado['bairro'];
						$numero = $resultado['numero'];
						$precoEntrada = $resultado['precodaentrada'];
						$horarioAbertura = $resultado['horarioabertura'];
						$horarioFechamento = $resultado['horariofechamento'];
						$tags = $this->repositorioTagsPontosTuristicos->pegarTagsPontoTuristico($idPontoTuristico);
							
						$pontoTuristico = new PontoTuristico($nome, $latitude, $longitude, $cidade, $estado, $pais, $rua, $numero, $bairro, $precoEntrada, $horarioAbertura, $horarioFechamento, $tags, $idPontoTuristico);
							
						array_push($pontosTuristicos, $pontoTuristico);
					}
						
					return $pontosTuristicos;
						
				}else{
					throw new FalhaAoExecutarQuery();
				}
			}else{
				throw new FalhaPrepareStatement();
			}
		}
		
		public function pegarPontosTuristicosFavoritosTurista($email){
		
			$sqlQuery = 'SELECT * FROM PontoTuristicoFavoritoTurista as PTFT join PontoTuristico as PT on PTFT.idPontoTuristico = PT.idPontoTuristico WHERE PTFT.emailTurista = ?';
				
			if($stmt = $this->conexao->prepare($sqlQuery)){
				$stmt->bindParam(1, $email);
				$pontosTuristicosFavoritos = array();
				if($stmt->execute()){
						$resultados = $stmt->fetchAll();
						foreach ($resultados as $resultado){
							
							$idPontoTuristico = $resultado['idpontoturistico'];
							$nome = $resultado['nome'];
							$latitude = $resultado['latitude'];
							$longitude = $resultado['longitude'];
							$cidade = $resultado['cidade'];
							$estado = $resultado['estado'];
							$pais = $resultado['pais'];
							$rua = $resultado['rua'];
							$bairro = $resultado['bairro'];
							$numero = $resultado['numero'];
							$precoEntrada = $resultado['precodaentrada'];
							$horarioAbertura = $resultado['horarioabertura'];
							$horarioFechamento = $resultado['horariofechamento'];
							$tags = $this->repositorioTagsPontosTuristicos->pegarTagsPontoTuristico($idPontoTuristico);
								
							$pontoTuristico = new PontoTuristico($nome, $latitude, $longitude, $cidade, $estado, $pais, $rua, $numero, $bairro, $precoEntrada, $horarioAbertura, $horarioFechamento, $tags, $idPontoTuristico);
							
							array_push($pontosTuristicosFavoritos, $pontoTuristico);
						}
						return $pontosTuristicosFavoritos;
				}else{
					throw new FalhaAoExecutarQuery();
				}
			}else{
				throw new FalhaPrepareStatement();
			}
		}
		
		public function cadastrarPontoTuristicoFavorito($idPontoTuristico,$emailLogado){
			
			$sqlQuery = "INSERT INTO
							PontoTuristicoFavoritoTurista (emailTurista, idPontoDePartida)
							VALUES (?, ?)";
				
			if($stmt = $this->conexao->prepare($sqlQuery)){
				$stmt->bindParam(1, $emailLogado);
				$stmt->bindParam(2, $idPontoTuristico);
				
				if(!$stmt->execute())
					throw new FalhaAoExecutarQuery();
			}else{
				throw new FalhaPrepareStatement();
			}
		}
		
	}
?>
