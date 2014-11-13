<?php
	include_once 'FalhaAoExecutarQuery.class.php';
	include_once 'FalhaPrepareStatement.class.php';
	include_once 'br.ufc.quixada.fbd.sgbd/FalhaAoCriarConexao.class.php';
	include_once 'br.ufc.quixada.fbd.sgbd/Conexao.class.php';
	
	
	class RepositorioEnderecoPontosTuristicos{
		private $conexao;
		
		public function __construct(Conexao $conexao){
			$this->conexao = $conexao;
		}
		
		public function cadastrarEnderecoPontoTuristico(PontoTuristico $pontoTuristico){
			$rua = $pontoTuristico->getRua();
			$cidade = $pontoTuristico->getCidade();
			$estado = $pontoTuristico->getEstado();
			$pais = $pontoTuristico->getPais();
			$numero = $pontoTuristico->getNumero();
			$bairro = $pontoTuristico->getBairro();
			$idPontoTuristico = $pontoTuristico->getId();
			
			$queryName = 'query_cadastrar_endereco_ponto_turistico';
			$sqlQuery = "INSERT INTO EnderecoPontoTuristico (idPontoTuristico, rua, cidade, estado, pais, numero, bairro) VALUES ($1, $2, $3, $4, $5, $6, $7)";
				
			if(pg_prepare($conexao, $queryName, $sqlQuery)){
				if(pg_execute($conexao, $queryName, array($idPontoTuristico, $rua, $cidade, $estado, $pais, $numero, $bairro))){
					$this->conexao->fecharConexao();
				}else{
					$this->conexao->fecharConexao();
					throw new FalhaAoExecutarQuery();
				}
			}else{
				throw new FalhaPrepareStatement();
			}
		}
		
		public function removerEnderecoPontoTuristico($idPontoTuristico){
			$conexao = $this->conexao->abrirConexao();
			
			$queryName = 'query_remover_ponto_turistico';
			$sqlQuery = 'DELETE FROM EnderecoPontoTuristico WHERE idPontoTuristico = $1';
			
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
		
		public function atualizarEnderecoPontoTuristico(PontoTuristico $pontoTuristico){
			$conexao = $this->conexao->abrirConexao();
		
			
			$cidade = $pontoTuristico->getCidade();
			$estado = $pontoTuristico->getEstado();
			$pais = $pontoTuristico->getPais();
			$numero = $pontoTuristico->getNumero();
			$rua = $pontoTuristico->getRua();
			$idPontoTuristico = $pontoTuristico->getId();
			$bairro =  $pontoTuristico->getBairro();
		
			$queryName = 'query_atualizar_endereco_ponto_turistico';
			$sqlQuery = 'UPDATE EnderecoPontoTuristico SET rua = $1, cidade = $2, estado = $3, pais = $4, numero = $5, bairro = $6
						WHERE idPontoTuristico = $7';
		
			if(pg_prepare($conexao, $queryName, $sqlQuery)){
				if(pg_execute($conexao, $queryName, array($rua, $cidade, $estado, $pais, $numero, $bairro, $idPontoTuristico))){
						
					$this->conexao->fecharConexao();
				}else{
					throw new FalhaAoExecutarQuery();
				}
			}else{
				throw new FalhaPrepareStatement();
			}
		}
		
		
	}