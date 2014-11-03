<?php

	include_once 'br.ufc.quixada.fbd.sgbd/Conexao.class.php';
	include_once 'FalhaPrepareStatement.class.php';
	include_once 'br.ufc.quixada.fbd.sgbd/FalhaAoCriarConexao.class.php';
	include_once 'FalhaAoExecutarQuery.class.php';
	include_once 'FalhaTuristaNaoCadastrado.class.php';
	
	Class RepositorioTuristas{
		private $conexao;
		
		function __construct(){
			$this->conexao = new Conexao();
			
		}
		
		function cadastrar(Turista $novoTurista){
			$conexao = $this->conexao->abrirConexao();
			
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
					throw new FalhaAoExecutarQuery();	
				}
			}else{
				throw new FalhaPrepareStatement();
			}	
		}
		
		function removerPorId($id_turista){
			$conexao = $this->conexao->abrirConexao();
			
			$queryName = 'query_remover_turista_por_id';
			$sqlQuery = 'DELETE FROM Turista WHERE idTurista = $1';
				
			if(pg_prepare($conexao, $queryName, $sqlQuery)){
				if(pg_execute($conexao, $queryName, array($id_turista))){
					$this->conexao->fecharConexao();
				}else{
					throw new FalhaAoExecutarQuery();
				}
			}else{
				throw new FalhaPrepareStatement();
			}
		}
		
		function removerTurista(Turista $turista){
			$conexao = $this->conexao->abrirConexao();
				
			$id_turista = $turista->getId();
			if($id_turista == null){
				throw new FalhaTuristaNaoCadastrado();
			}
			
			$queryName = 'query_remover_turista';
			$sqlQuery = 'DELETE FROM Turista WHERE idTurista = $1';
			
			if(pg_prepare($conexao, $queryName, $sqlQuery)){
				if(pg_execute($conexao, $queryName, array($id_turista))){
					$this->conexao->fecharConexao();
				}else{
					throw new FalhaAoExecutarQuery();
				}
			}else{
				throw new FalhaPrepareStatement();
			}
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