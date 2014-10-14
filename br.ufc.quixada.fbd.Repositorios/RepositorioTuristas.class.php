<?php

	include_once 'br.ufc.quixada.fbd.SGBD/Conexao.class.php';
	include_once 'br.ufc.quixada.fbd.Excecoes/PrepareStatementFalha.class.php';
	include_once 'br.ufc.quixada.fbd.Excecoes/FalhaAoCriarConexao.class.php';
	include_once 'br.ufc.quixada.fbd.Excecoes/FalhaAoExecutarQuery.class.php';
	
	Class RepositorioTuristas{
		private $conexao;
		
		function __construct(){
			$this->conexao = new Conexao();
			
		}
		
		function cadastrar(Turista $novoTurista){
			try{
				$conexao = $this->conexao->abrirConexao();
			}catch (FalhaAoCriarConexao $e){
				throw $e;
			}
			
			$idCategoria = $novoTurista->getCategoria();
			$nome = $novoTurista->getNome();
			$dataDeNascimento = $novoTurista->getDataDeNascimento();
			$senha = $novoTurista->getSenha();
			$email = $novoTurista->getEmail();
			
			$queryName = 'query_cadastrar_turista';
			$sqlQuery = 'INSERT INTO Turista (idCategoria, nome, dataDeNascimento, senha, email) VALUES ($1, $2, $3, $4, $5)';
			
			if(pg_prepare($conexao, $queryName, $sqlQuery)){
				if(pg_execute($conexao, $queryName, array($idCategoria, $nome, $dataDeNascimento, $senha, $email))){
					$this->conexao->fecharConexao();
				}else{
					throw new FalhaAoExecutarQuery('Ocorreu algum erro na execução da Query');	
				}
			}else{
				throw new PrepareStatementFalha('Erro ao criar prepare statement');
			}	
		}
		
		function removerPorId($id_turista){
			
		}
		
		function removerTurista(Turista $turista){
			
		}
		
		function atualizarTurista(Turista $turista){
			
		}
		
		function pegarTuristaPorEmail($email){
			
		}
		
		function pegarTuristaPorId($id_turista){
			
		} 
		
		function pegarTodosOsTuristas(){
			
		}
	}
?>