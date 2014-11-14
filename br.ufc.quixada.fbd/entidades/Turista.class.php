<?php
	Class Turista{
		
		private $nome;
		private $email;
		private $senha;
		private $preferencias;
		
		function __construct($nome, $email, $senha, $data_de_nascimento, $preferencias=""){
			$this->preferencias = $preferencias;
			$this->email = $email;
			$this->data_de_nascimento = $data_de_nascimento;
			$this->nome = $nome;
			$this->senha = $senha;
		}

		
		public function getPreferencias(){
			return $this->preferencias;
		}
		
		public function setPreferencias($preferencias){
			$this->preferencias = $preferencias;
		}
		
		public function getNome(){
			return $this->nome;
		}
		
		public function setNome($nome){
			$this->nome = $nome;
		}
		
		public function getEmail(){
			return $this->email;
		}
		
		public function setEmail($email){
			$this->email = $email;
		}
		
		public function getSenha(){
			return $this->senha;
		}
		
		public function setSenha($senha){
			$this->senha = $senha;
		}
		
		public function getDataDeNascimento(){
			return $this->data_de_nascimento;
		}
		
		public function setDataDeNascimento($data_de_nascimento){
			$this->data_de_nascimento = $data_de_nascimento;
		}
	}
?>