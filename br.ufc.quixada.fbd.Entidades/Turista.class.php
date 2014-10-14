<?php
	Class Turista{
		private $id;
		private $categoria;
		private $nome;
		private $email;
		private $senha;
		private $data_de_nascimento;
		
		function __construct($nome, $email, $senha, $data_de_nascimento, $categoria="", $id=""){
			$this->categoria = $categoria;
			$this->email = $email;
			$this->data_de_nascimento = $data_de_nascimento;
			$this->id = $id;
			$this->nome = $nome;
			$this->senha = $senha;
		}
		
		public function getId(){
			return $this->id;
		}
		
		public function setId($id){
			$this->id = $id;
		}
		
		public function getCategoria(){
			return $this->categoria;
		}
		
		public function setCategoria($categoria){
			$this->categoria = $categoria;
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