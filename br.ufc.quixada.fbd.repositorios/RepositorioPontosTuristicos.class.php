<?php
	include_once 'br.ufc.quixada.fbd.sgbd/Conexao.class.php';
	include_once 'FalhaPrepareStatement.class.php';
	include_once 'RepositorioTagsPontosTuristicos.class.php';
	include_once 'RepositorioEnderecoPontosTuristicos.class.php';
	include_once 'br.ufc.quixada.fbd.sgbd/FalhaAoCriarConexao.class.php';
	include_once 'FalhaAoExecutarQuery.class.php';
	
	Class RepositorioPontosTuristicos{
		private $conexao;
		private $repositorioTagsPontosTuristicos;
		private $repositorioEnderecoPontosTuristicos;
		
		public function __construct(){
			$this->conexao = new Conexao();
			$this->repositorioTagsPontosTuristicos = new RepositorioTagsPontosTuristicos();
			$this->repositorioEnderecoPontosTuristicos = new RepositorioEnderecoPontosTuristicos();
		}
		
		public function cadastrar(PontoTuristico $novoPontoTuristico){
			$conexao = $this->conexao->abrirConexao();
			
			
			$nome = $novoPontoTuristico->getNome();
			$latitude = $$novoPontoTuristico->getLatitude();
			$longitude = $novoPontoTuristico->getLongitude();
			$horarioAbertura = $novoPontoTuristico->getHorarioAbertura();
			$horarioFechamento = $novoPontoTuristico->getHorarioFechamento();
			$precoEntrada = $novoPontoTuristico->getPrecoEntrada();
			
				
			$queryName = 'query_cadastrar_ponto_turistico';
			$sqlQuery = "INSERT INTO 
							PontoTuristico (nome, latitude, longitude, precoDaEntrada, horarioAbertura, horarioFechamento) 
							VALUES ($1, $2, $3, $4, $5, $6) RETURNING idPontoTuristico";
			
			if(pg_prepare($conexao, $queryName, $sqlQuery)){
				if($idPontoTuristico = pg_execute($conexao, $queryName, array($nome, $latitude, $longitude, $precoEntrada, $horarioAbertura, $horarioFechamento))){
					pg_close($conexao);
					$this->repositorioEnderecoPontosTuristicos->cadastrarEnderecoPontoTuristico($novoPontoTuristico);
					$this->repositorioTagsPontosTuristicos->cadastrarTagsPontoTuristico($novoPontoTuristico);
					$novoPontoTuristico->setId($idPontoTuristico);
				}else{
					throw new FalhaAoExecutarQuery();
				}
			}else{
				throw new FalhaPrepareStatement();
			}
		}
		
		public function remover(PontoTuristico $pontoTuristico){
			$conexao = $this->conexao->abrirConexao();
			
			$idPontoTuristico = $$pontoTuristico->getId();
			if($idPontoTuristico == null){
				throw new FalhaPontoTuristicoNaoCadastrado();
			}
				
			$queryName = 'query_remover_ponto_turistico';
			$sqlQuery = 'DELETE FROM PontoTuristico WHERE idPontoTuristico = $1';
				
			if(pg_prepare($conexao, $queryName, $sqlQuery)){
				if(pg_execute($conexao, $queryName, array($idPontoTuristico))){
					pg_close($conexao);
					$this->repositorioTagsPontosTuristicos->removerTagsPontoTuristico($idPontoTuristico);
					$this->repositorioEnderecoPontosTuristicos->removerEnderecoPontoTuristico($idPontoTuristico);
				}else{
					throw new FalhaAoExecutarQuery();
				}
			}else{
				throw new FalhaPrepareStatement();
			}
		}
		
		public function atualizar(PontoTuristico $pontoTuristico){
			$conexao = $this->conexao->abrirConexao();
			
			$nome = $pontoTuristico->getNome();
			$latitude = $pontoTuristico->getLatitude();
			$longitude = $pontoTuristico->getLongitude();
			$horarioAbertura = $pontoTuristico->getHorarioAbertura();
			$horarioFechamento = $pontoTuristico->getHorarioFechamento();
			$precoEntrada = $pontoTuristico->getPrecoEntrada();
			$idPontoTuristico = $pontoTuristico->getId();
		
			$queryName = 'query_atualizar_ponto_turistico';
			$sqlQuery = 'UPDATE PontoTuristico SET nome = $1, latitude = $2, 
					longitude = $3, precoDaEntrada = $4, horarioAbertura = $5, horarioFechamento = $6
					WHERE idPontoTuristico = $7';
				
			if(pg_prepare($conexao, $queryName, $sqlQuery)){
				if(pg_execute($conexao, $queryName, array($nome, $latitude, $longitude, $precoEntrada, $horarioAbertura, $horarioFechamento, $idPontoTuristico))){
					
					pg_close($conexao);
					$this->repositorioTagsPontosTuristicos->removerTagsPontoTuristico($idPontoTuristico);
					$this->repositorioTagsPontosTuristicos->cadastrarTagsPontoTuristico($turista);
					$this->repositorioEnderecoPontosTuristicos->atualizarEnderecoPontoTuristico($pontoTuristico);
					
				}else{
					throw new FalhaAoExecutarQuery();
				}
			}else{
				throw new FalhaPrepareStatement();
			}
		}
		
		
		public function pegarPontoTuristicoPorId($idPontoTuristico){
			$conexao = $this->conexao->abrirConexao();
			
			$queryName = 'query_pegar_ponto_turistico_por_id';
			$sqlQuery = 'SELECT * 
							FROM PontoTuristico PT, EnderecoPontoTuristico EPT 
							WHERE idPontoTuristico = $1 
							AND PT.idPontoTuristico = EPT = idPontoTuristico LIMIT 1';
				
			if(pg_prepare($conexao, $queryName, $sqlQuery)){
				$result = @pg_execute($conexao, $queryName, array($idPontoTuristico));
				if($result){
					$resultado = pg_fetch_array($result);
					
					$nome = $resultado['nome'];
					$latitude = $resultado['latutude'];
					$longitude = $resultado['longitude'];
					$cidade = $resultado['cidade'];
					$estado = $resultado['estado'];
					$pais = $resultado['pais'];
					$rua = $resultado['rua'];
					$numero = $resultado['numero'];
					$preco_entrada = $resultado['precoEntrada'];
					$horario_abertura = $resultado['horarioAbertura'];
					$horario_fechamento = $resultado['horarioFechamento'];
					$tags = $this->repositorioTagsPontosTuristicos->pegarTagsPontoTuristico($idPontoTuristico);
						
					$pontoTuristico = new PontoTuristico($nome, $latitude, $longitude, $cidade, $estado, $pais, $rua, $numero, $preco_entrada, $horario_abertura, $horario_fechamento, $tags, $idPontoTuristico);
						
					pg_close($conexao);
					return $turista;
				}else{
					throw new FalhaAoExecutarQuery();
				}
			}else{
				throw new FalhaPrepareStatement();
			}
		}
		
		public function pegarTodosOsPontosTuristicos(){
			$conexao = $this->conexao->abrirConexao();
			
			$queryName = 'query_pegar_todos_os_pontos_turisticos';
			$sqlQuery = 'SELECT * 
							FROM PontoTuristico PT, EnderecoPontoTuristico EPT 
							WHERE EPT.idPontoTuristico = PT.idPontoTuristico';
				
			if(pg_prepare($conexao, $queryName, $sqlQuery)){
				$result = @pg_execute($conexao, $queryName, array());
				if($result){
					$pontosTuristicos = Array();
						
					while($resultado = pg_fetch_array($result)){
						
						$idPontoTuristico = $resultado['idPontoTuristico'];
						$nome = $resultado['nome'];
						$latitude = $resultado['latutude'];
						$longitude = $resultado['longitude'];
						$cidade = $resultado['cidade'];
						$estado = $resultado['estado'];
						$pais = $resultado['pais'];
						$rua = $resultado['rua'];
						$numero = $resultado['numero'];
						$preco_entrada = $resultado['precoEntrada'];
						$horario_abertura = $resultado['horarioAbertura'];
						$horario_fechamento = $resultado['horarioFechamento'];
						$tags = $this->repositorioTagsPontosTuristicos->pegarTagsPontoTuristico($idPontoTuristico);
						
						$pontoTuristico = new PontoTuristico($nome, $latitude, $longitude, $cidade, $estado, $pais, $rua, $numero, $preco_entrada, $horario_abertura, $horario_fechamento, $tags, $idPontoTuristico);
						
						array_push($pontosTuristicos, $pontoTuristico);
					}
						
					pg_close($conexao);
					return $pontosTuristicos;
		
				}else{
					throw new FalhaAoExecutarQuery();
				}
			}else{
				throw new FalhaPrepareStatement();
			}
		}	
		
		public function pegarTodosOsPontosTuristicosVisitadosPorUmTurista($email){
			$conexao = $this->conexao->abrirConexao();
			
			$queryName = 'query_pegar_todos_os_pontos_turisticos_visitados_por_um_turista';
			$sqlQuery = 'SELECT * 
							FROM PontoTuristico PT, EnderecoPontoTuristico EPT, Visitas V 
							WHERE EPT.idPontoTuristico = PT.idPontoTuristico 
							AND V.idPontoTuristico = PT.idPontoTuristo
							AND V.emailTurista = $1';
			
			if(pg_prepare($conexao, $queryName, $sqlQuery)){
				$result = @pg_execute($conexao, $queryName, array($email));
				if($result){
					$pontosTuristicos = Array();
			
					while($resultado = pg_fetch_array($result)){
			
						$idPontoTuristico = $resultado['idPontoTuristico'];
						$nome = $resultado['nome'];
						$latitude = $resultado['latutude'];
						$longitude = $resultado['longitude'];
						$cidade = $resultado['cidade'];
						$estado = $resultado['estado'];
						$pais = $resultado['pais'];
						$rua = $resultado['rua'];
						$numero = $resultado['numero'];
						$preco_entrada = $resultado['precoEntrada'];
						$horario_abertura = $resultado['horarioAbertura'];
						$horario_fechamento = $resultado['horarioFechamento'];
						$tags = $this->repositorioTagsPontosTuristicos->pegarTagsPontoTuristico($idPontoTuristico);
			
						$pontoTuristico = new PontoTuristico($nome, $latitude, $longitude, $cidade, $estado, $pais, $rua, $numero, $preco_entrada, $horario_abertura, $horario_fechamento, $tags, $idPontoTuristico);
			
						array_push($pontosTuristicos, $pontoTuristico);
					}
			
					pg_close($conexao);
					return $pontosTuristicos;
			
				}else{
					throw new FalhaAoExecutarQuery();
				}
			}else{
				throw new FalhaPrepareStatement();
			}
		}
		
	}
?>