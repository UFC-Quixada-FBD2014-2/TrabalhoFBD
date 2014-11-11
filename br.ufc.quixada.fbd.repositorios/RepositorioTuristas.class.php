<?php

	include_once 'br.ufc.quixada.fbd.sgbd/Conexao.class.php';
	include_once 'FalhaPrepareStatement.class.php';
	include_once 'br.ufc.quixada.fbd.sgbd/FalhaAoCriarConexao.class.php';
	include_once 'FalhaAoExecutarQuery.class.php';
	include_once 'FalhaTuristaNaoCadastrado.class.php';
	
	Class RepositorioTuristas{
		private $conexao;
		
		public function __construct(){
			$this->conexao = new Conexao();
		}
		
		public function cadastrar(Turista $novoTurista){
			$conexao = $this->conexao->abrirConexao();
			
			$nome = $novoTurista->getNome();
			$dataDeNascimento = $novoTurista->getDataDeNascimento();
			$senha = $novoTurista->getSenha();
			$email = $novoTurista->getEmail();
			
			$queryName = 'query_cadastrar_turista';
			$sqlQuery = 'INSERT INTO Turista (email, nome, dataDeNascimento, senha) VALUES ($1, $2, $3, $4)';
			
			if(pg_prepare($conexao, $queryName, $sqlQuery)){
				if(pg_execute($conexao, $queryName, array($email, $idCategoria, $nome, $dataDeNascimento, $senha))){
					$this->cadastrarPreferenciasTurista($novoTurista);
					$this->conexao->fecharConexao();
				}else{
					throw new FalhaAoExecutarQuery();	
				}
			}else{
				throw new FalhaPrepareStatement();
			}	
		}
		
		public function removerTurista(Turista $turista){
			$conexao = $this->conexao->abrirConexao();
				
			$email = $turista->getEmail();
			if($email == null){
				throw new FalhaTuristaNaoCadastrado();
			}
			
			$queryName = 'query_remover_turista';
			$sqlQuery = 'DELETE FROM Turista WHERE email = $1';
			
			if(pg_prepare($conexao, $queryName, $sqlQuery)){
				if(pg_execute($conexao, $queryName, array($email))){
					$this->removerPreferenciasTurista($email);
					$this->conexao->fecharConexao();
				}else{
					throw new FalhaAoExecutarQuery();
				}
			}else{
				throw new FalhaPrepareStatement();
			}
		}
		
		public function atualizarTurista(Turista $turista){
			$conexao = $this->conexao->abrirConexao();
		
			
			$nome = $turista->getNome();
			$dataDeNascimento = $turista->getDataDeNascimento();
			$senha = $turista->getSenha();
			$email = $turista->getEmail();
				
			$queryName = 'query_atualizar_turista';
			$sqlQuery = 'UPDATE Turista SET nome = $1, dataDeNascimento = $2, senha = $3, email = $4 WHERE email = $5';
			
			if(pg_prepare($conexao, $queryName, $sqlQuery)){
				if(pg_execute($conexao, $queryName, array( $nome, $dataDeNascimento, $senha, $email, $email))){
					$this->removerPreferenciasTurista($email);
					$this->cadastrarPreferenciasTurista($turista);
					$this->conexao->fecharConexao();
				}else{
					throw new FalhaAoExecutarQuery();
				}
			}else{
				throw new FalhaPrepareStatement();
			}
		}
		
		public function pegarTuristaPorEmail($email){
			$conexao = $this->conexao->abrirConexao();
						
			$queryName = 'query_pegar_turista_por_email';
			$sqlQuery = 'SELECT * FROM Turista WHERE email = $1 LIMIT 1';
			
			if(pg_prepare($conexao, $queryName, $sqlQuery)){
				$result = @pg_execute($conexao, $queryName, array($email));
				if($result){
					$resultado = pg_fetch_array($result);
					$nome = $resultado['nome'];
					$email = $resultado['email'];
					$senha = $resultado['senha'];
					$data_de_nascimento = $resultado['datadenascimento'];
					$preferencias = $this->pegarPreferenciasTurista($email);
					
					$turista = new Turista($nome, $email, $senha, $data_de_nascimento, $preferencias);
					
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
				
			$queryName = 'query_pegar_todos_os_turistas';
			$sqlQuery = 'SELECT * FROM Turista';
			
			if(pg_prepare($conexao, $queryName, $sqlQuery)){
				$result = @pg_execute($conexao, $queryName, array());
				if($result){
					$turistas = Array();
					
					while($resultado = pg_fetch_array($result)){
						$nome = $resultado['nome'];
						$email = $resultado['email'];
						$senha = $resultado['senha'];
						$data_de_nascimento = $resultado['datadenascimento'];
						$preferencias = $this->pegarPreferenciasTurista($email);
						
						$turista = new Turista($nome, $email, $senha, $data_de_nascimento, $preferencias);
						
						array_push($turistas, $turista);
					}
					
					$this->conexao->fecharConexao();
					return $turistas;
						
				}else{
					throw new FalhaAoExecutarQuery();
				}
			}else{
				throw new FalhaPrepareStatement();
			}
		}
		
		private function pegarPreferenciasTurista($email){
			$conexao = $this->conexao->abrirConexao();
			
			$queryName = 'query_pegar_todas_as_preferencias';
			$sqlQuery = 'SELECT * FROM PreferenciaDeTurista WHERE emailTurista = $1';
				
			if(pg_prepare($conexao, $queryName, $sqlQuery)){
				$result = @pg_execute($conexao, $queryName, array($email));
				if($result){
					$preferencias = Array();
						
					while($resultado = pg_fetch_array($result)){
						$preferencia = $resultado['nome'];
			
						array_push($preferencias, $preferencia);
					}
						
					$this->conexao->fecharConexao();
					return $preferencias;
			
				}else{
					throw new FalhaAoExecutarQuery();
				}
			}else{
				throw new FalhaPrepareStatement();
			}
		}
		
		private function removerPreferenciasTurista($email){
			$conexao = $this->conexao->abrirConexao();
			
			$queryName = 'query_remover_preferencias';
			$sqlQuery = 'DELETE FROM PreferenciaDeTurista WHERE emailTurista = $1';
				
			if(pg_prepare($conexao, $queryName, $sqlQuery)){
				if(pg_execute($conexao, $queryName, array($email))){
					$this->conexao->fecharConexao();
				}else{
					throw new FalhaAoExecutarQuery();
				}
			}else{
				throw new FalhaPrepareStatement();
			}
		}
		
		private function cadastrarPreferenciasTurista(Turista $turista){
			
			$conexao = $this->conexao->abrirConexao();
				
			$preferencias = $turista->getPreferencias();
			$email = $turista->getEmail();	
			
			$queryName = 'query_cadastrar_preferencias';
			$sqlQuery = 'INSERT INTO PreferenciaDeTurista(email, nome) VALUES ($1, $2)';

			for($i=0; $i<count($preferencias); $i++){
				if(pg_prepare($conexao, $queryName, $sqlQuery)){
					if(pg_execute($conexao, $queryName, array($email, $preferencias[i]))){
						
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