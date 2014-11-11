<?php
	include_once 'br.ufc.quixada.fbd.sgbd/Conexao.class.php';
	include_once 'FalhaPrepareStatement.class.php';
	include_once 'br.ufc.quixada.fbd.sgbd/FalhaAoCriarConexao.class.php';
	include_once 'FalhaAoExecutarQuery.class.php';
	
	Class RepositorioPontosTuristicos{
		private $conexao;
		
		public function __construct(){
			$this->conexao = new Conexao();
		}
		
		public function cadastrar(PontoTuristico $novoPontoTuristico){
			$conexao = $this->conexao->abrirConexao();
				
			$nome = $novoPontoTuristico->getNome();
			$cidade = $novoPontoTuristico->getCidade();
			$estado = $novoPontoTuristico->getEstado();
			$pais = $novoPontoTuristico->getPais();
			$latitude = $$novoPontoTuristico->getLatitude();
			$longitude = $novoPontoTuristico->getLongitude();
			$horarioAbertura = $novoPontoTuristico->getHorarioAbertura();
			$horarioFechamento = $novoPontoTuristico->getHorarioFechamento();
			$numero = $novoPontoTuristico->getNumero();
			$precoEntrada = $novoPontoTuristico->getPrecoEntrada();
			$rua = $novoPontoTuristico->getRua();
				
			$queryName = 'query_cadastrar_ponto_turistico';
			$sqlQuery = 'INSERT INTO PontoTuristico (nome, latitude, longitude, cidade, estado, pais, rua, numero, precoDaEntrada, horarioAbertura, horarioFechamento) VALUES ($1, $2, $3, $4, $5, $6, $7, $8, $9, $10, $11)';
				
			if(pg_prepare($conexao, $queryName, $sqlQuery)){
				if(pg_execute($conexao, $queryName, array($nome, $latitude, $longitude, $cidade, $estado, $pais, $rua, $numero, $precoEntrada, $horarioAbertura, $horarioFechamento))){
					$this->cadastrarTagsPontoTuristico($novoPontoTuristico);
					$this->conexao->fecharConexao();
				}else{
					throw new FalhaAoExecutarQuery();
				}
			}else{
				throw new FalhaPrepareStatement();
			}
		}
		
		public function removerPontoTuristico(PontoTuristico $pontoTuristico){
			$conexao = $this->conexao->abrirConexao();
		
			$idPontoTuristico = $$pontoTuristico->getId();
			if($idPontoTuristico == null){
				throw new FalhaPontoTuristicoNaoCadastrado();
			}
				
			$queryName = 'query_remover_ponto_turistico';
			$sqlQuery = 'DELETE FROM PontoTuristico WHERE idPontoTuristico = $1';
				
			if(pg_prepare($conexao, $queryName, $sqlQuery)){
				if(pg_execute($conexao, $queryName, array($idPontoTuristico))){
					$this->removerTagsPontoTuristico($idPontoTuristico);
					$this->conexao->fecharConexao();
				}else{
					throw new FalhaAoExecutarQuery();
				}
			}else{
				throw new FalhaPrepareStatement();
			}
		}
		
		public function atualizarPontoTuristico(PontoTuristico $pontoTuristico){
			$conexao = $this->conexao->abrirConexao();
		
			$nome = $novoPontoTuristico->getNome();
			$cidade = $novoPontoTuristico->getCidade();
			$estado = $novoPontoTuristico->getEstado();
			$pais = $novoPontoTuristico->getPais();
			$latitude = $$novoPontoTuristico->getLatitude();
			$longitude = $novoPontoTuristico->getLongitude();
			$horarioAbertura = $novoPontoTuristico->getHorarioAbertura();
			$horarioFechamento = $novoPontoTuristico->getHorarioFechamento();
			$numero = $novoPontoTuristico->getNumero();
			$precoEntrada = $novoPontoTuristico->getPrecoEntrada();
			$rua = $novoPontoTuristico->getRua();
			
			$idPontoTuristico = $pontoTuristico->getId();
		
			$queryName = 'query_atualizar_turista';
			$sqlQuery = 'UPDATE Turista SET nome = $1, latitude = $2, 
					longitude = $3, cidade = $4, estado = $5, pais = $6, rua = $7, numero = $8,
					 precoDaEntrada = $9, horarioAbertura = $10, horarioFechamento = $11';
				
			if(pg_prepare($conexao, $queryName, $sqlQuery)){
				if(pg_execute($conexao, $queryName, array($nome, $latitude, $longitude, $cidade, $estado,
						 $pais, $rua, $numero, $precoEntrada, $horarioAbertura, $horarioFechamento))){
					
					$this->removerTagsPontoTuristico($idPontoTuristico);
					$this->cadastrarTagsPontoTuristico($turista);
					$this->conexao->fecharConexao();
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
			$sqlQuery = 'SELECT * FROM PontoTuristico WHERE idPontoTuristico = $1 LIMIT 1';
				
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
					$tags = $this->pegarTagsPontoTuristico($idPontoTuristico);
						
					$pontoTuristico = new PontoTuristico($nome, $latitude, $longitude, $cidade, $estado, $pais, $rua, $numero, $preco_entrada, $horario_abertura, $horario_fechamento, $tags, $idPontoTuristico);
						
					$this->conexao->fecharConexao();
					return $turista;
				}else{
					throw new FalhaAoExecutarQuery();
				}
			}else{
				throw new FalhaPrepareStatement();
			}
		}
		
		public function pegarTodosOsTuristas(){
			$conexao = $this->conexao->abrirConexao();
		
			$queryName = 'query_pegar_todos_os_pontos_turisticos';
			$sqlQuery = 'SELECT * FROM Turista';
				
			if(pg_prepare($conexao, $queryName, $sqlQuery)){
				$result = @pg_execute($conexao, $queryName, array());
				if($result){
					$pontosTuristicos = Array();
						
					while($resultado = pg_fetch_array($result)){
						
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
						$tags = $this->pegarTagsPontoTuristico($idPontoTuristico);
						
						$pontoTuristico = new PontoTuristico($nome, $latitude, $longitude, $cidade, $estado, $pais, $rua, $numero, $preco_entrada, $horario_abertura, $horario_fechamento, $tags, $idPontoTuristico);
						
						array_push($pontosTuristicos, $pontoTuristico);
					}
						
					$this->conexao->fecharConexao();
					return $pontosTuristicos;
		
				}else{
					throw new FalhaAoExecutarQuery();
				}
			}else{
				throw new FalhaPrepareStatement();
			}
		}
		
		private function pegarTagsPontoTuristico($idPontoTuristico){
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
		
		private function removerTagsPontoTuristico($idPontoTuristico){
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
		
		private function cadastrarTagsPontoTuristico(PontoTuristico $pontoTuristico){
				
			$conexao = $this->conexao->abrirConexao();
		
			$tags = $pontoTuristico->getTags();
			$idPontoTuristico = $pontoTuristico->getId();
			
			$queryName = 'query_cadastrar_preferencias';
			$sqlQuery = 'INSERT INTO TagsDePontoTuristico (idPontoTuristico, nome) VALUES ($1, $2)';
		
			for($i=0; $i<count($tags); $i++){
				if(pg_prepare($conexao, $queryName, $sqlQuery)){
					if(pg_execute($conexao, $queryName, array($idPontoTuristico, $tags[i]))){
						
					}else{
						throw new FalhaAoExecutarQuery();
					}
				}else{
					throw new FalhaPrepareStatement();
				}
			}
			
			$this->conexao->fecharConexao();
		}
	}
?>