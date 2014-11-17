<?php
include_once __DIR__.'/../sgbd/Conexao.class.php';
include_once 'FalhaPrepareStatement.class.php';
include_once __DIR__.'/../sgbd/FalhaAoCriarConexao.class.php';
//include_once 'FalhaAoExecutarQuery.class.php';
include_once 'FalhaTuristaNaoCadastrado.class.php';
include_once 'RepositorioPreferenciasTurista.class.php';
include_once __DIR__.'/../entidades/Turista.class.php';

Class RepositorioTuristas{
	private $conexao;
	private $repositorioPreferenciasTurista;

	public function __construct(){
		$conexao = new Conexao();
		$this->conexao = $conexao->abrirConexao();
		$this->repositorioPreferenciasTurista = new RepositorioPreferenciasTurista();
	}

	public function cadastrar(Turista $novoTurista){
			
		$nome = $novoTurista->getNome();
		$dataDeNascimento = $novoTurista->getDataDeNascimento();
		$senha = $novoTurista->getSenha();
		$email = $novoTurista->getEmail();
			
		$sqlQuery = 'INSERT INTO Turista (email, nome, dataDeNascimento, senha) VALUES (?, ?, ?, ?)';
			
		if($stmt = $this->conexao->prepare($sqlQuery)){
			$stmt->bindParam(1, $email);
			$stmt->bindParam(2, $nome);
			$stmt->bindParam(3, $dataDeNascimento);
			$stmt->bindParam(4, $senha);
			
			if($stmt->execute()){
				
				try{
					$this->repositorioPreferenciasTurista->cadastrarPreferenciasTurista($novoTurista);
				}catch (Exception $e){
				}
			}else{
				throw new FalhaAoExecutarQuery();
			}
		}else{
			throw new FalhaPrepareStatement();
		}
	}

	public function removerTurista($email){
			
		$sqlQuery = 'DELETE FROM Turista WHERE email = ?';
			
		if($stmt = $this->conexao->prepare($sqlQuery)){
			$stmt->bindParam(1, $email);

			if($stmt->execute()){
				
			}else{
				throw new FalhaAoExecutarQuery();
			}
		}else{
			throw new FalhaPrepareStatement();
		}
	}

	public function atualizarTurista(Turista $turista){
			
		$nome = $turista->getNome();
		$dataDeNascimento = $turista->getDataDeNascimento();
		$senha = $turista->getSenha();
		$email = $turista->getEmail();

		$sqlQuery = 'UPDATE Turista SET nome = ?, dataDeNascimento = ?, senha = ? WHERE email = ?';
		
		$this->conexao->beginTransaction();
		if($stmt = $this->conexao->prepare($sqlQuery)){
			$stmt->bindParam(1, $nome);
			$stmt->bindParam(2, $dataDeNascimento);
			$stmt->bindParam(3, $senha);
			$stmt->bindParam(4, $email);

			if($stmt->execute()){
				try{
					$this->repositorioPreferenciasTurista->removerPreferenciasTurista($email);
					$this->repositorioPreferenciasTurista->cadastrarPreferenciasTurista($turista);
					$this->conexao->commit();
				}catch (Exception $e){
					$this->conexao->rollBack();
				}
			}else{
				throw new FalhaAoExecutarQuery();
			}
		}else{
			throw new FalhaPrepareStatement();
		}
	}

	public function pegarTuristaPorEmail($email){
			
		$sqlQuery = 'SELECT * FROM Turista WHERE email = ? LIMIT 1';
			
		if($stmt = $this->conexao->prepare($sqlQuery)){
			$stmt->bindParam(1, $email);
			if($stmt->execute()){
				$resultado = $stmt->fetch();
				if($resultado){
					$nome = $resultado['nome'];
					$email = $resultado['email'];
					$senha = $resultado['senha'];
					$data_de_nascimento = $resultado['datadenascimento'];
					$preferencias = $this->repositorioPreferenciasTurista->pegarPreferenciasTurista($email);

					$turista = new Turista($nome, $email, $senha, $data_de_nascimento, $preferencias);

					return $turista;
				}
			}else{
				throw new FalhaAoExecutarQuery();
			}
		}else{
			throw new FalhaPrepareStatement();
		}
	}


	public function pegarTodosOsTuristas(){
			
		$sqlQuery = 'SELECT * FROM Turista';
			
		if($stmt = $this->conexao->prepare($sqlQuery)){
			if($stmt->execute()){
				$turistas = Array();
				$resultados = $stmt->fetchAll();
				foreach ($resultados as $resultado){
					$nome = $resultado['nome'];
					$email = $resultado['email'];
					$senha = $resultado['senha'];
					$data_de_nascimento = $resultado['datadenascimento'];
					$preferencias = $this->repositorioPreferenciasTurista->pegarPreferenciasTurista($email);

					$turista = new Turista($nome, $email, $senha, $data_de_nascimento, $preferencias);

					array_push($turistas, $turista);
				}
					
					
					
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