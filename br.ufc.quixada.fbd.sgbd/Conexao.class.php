<?php
	include_once 'br.ufc.quixada.fbd.sgbd/Conexao.class.php';
	
	Class Conexao{
		
		private $host = "localhost";
		private $user = "postgres";
		private $passwd = "postgres";
		private $bd = "trabalhoFBD";
		private $conexao = null;
		
		function __contruct(){
			
		}
		
		function abrirConexao(){
			$this->conexao = @pg_connect("host=$this->host user=$this->user password=$this->passwd dbname=$this->bd");
			if($this->conexao)
				return $this->conexao;
			else
				throw new FalhaAoCriarConexao(ConstantesMensagensExcecoes::FALHA_AO_CRIAR_CONEXAO);
		}
		
		function fecharConexao(){
			@pg_close($this->conexao);
		}
		
		function statusConexao(){
			if($this->conexao)return true;
			else return false;
		}
		
	}
?>