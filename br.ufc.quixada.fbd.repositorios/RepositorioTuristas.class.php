<?php

	include_once 'br.ufc.quixada.fbd.sgbd/Conexao.class.php';
	include_once 'FalhaPrepareStatement.class.php';
	include_once 'br.ufc.quixada.fbd.sgbd/FalhaAoCriarConexao.class.php';
	include_once 'FalhaAoExecutarQuery.class.php';
	include_once 'FalhaTuristaNaoCadastrado.class.php';
	include_once 'RepositorioPreferenciasTurista.class.php';
	
	Class RepositorioTuristas{
		private $conexao;
		private $repositorioPreferenciasTurista;
		
		public function __construct(){
			$this->conexao = new Conexao();
			$this->repositorioPreferenciasTurista = new RepositorioPreferenciasTurista();
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
				if(pg_execute($conexao, $queryName, array($email, $nome, $dataDeNascimento, $senha))){
					$this->repositorioPreferenciasTurista->cadastrarPreferenciasTurista($novoTurista);
					pg_close($conexao);
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
					$this->repositorioPreferenciasTurista->removerPreferenciasTurista($email);
					pg_close($conexao);
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
					$this->repositorioPreferenciasTurista->removerPreferenciasTurista($email);
					$this->repositorioPreferenciasTurista->cadastrarPreferenciasTurista($turista);
					pg_close($conexao);
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
					$preferencias = $this->repositorioPreferenciasTurista->pegarPreferenciasTurista($email);
					
					$turista = new Turista($nome, $email, $senha, $data_de_nascimento, $preferencias);
					
					pg_close($conexao);
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
						$preferencias = $this->repositorioPreferenciasTurista->pegarPreferenciasTurista($email);
						
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
		
		
	}
?>