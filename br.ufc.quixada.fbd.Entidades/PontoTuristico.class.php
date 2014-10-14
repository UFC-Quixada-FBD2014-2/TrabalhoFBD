<?php
	Class PontoTuristico{
		
		private $id;
		private $id_categoria;
		private $nome;
		private $latitude;
		private $longitude;
		private $cidade;
		private $estado;
		private $pais;
		private $rua;
		private $numero;
		private $horario_abertura;
		private $horario_fechamento;
		private $preco_entrada;
		
		function __construct($nome, $latitude, $longitude, $cidade, $estado, $pais, $rua, $numero, $preco_entrada, $horario_abertura, $horario_fechamento, $id_categoria="", $id=""){
			$this->nome = $nome;
			$this->cidade = $cidade;
			$this->estado = $estado;
			$this->id = $id;
			$this->id_categoria = $id_categoria;
			$this->latitude = $latitude;
			$this->longitude = $longitude;
			$this->numero = $numero;
			$this->pais = $pais;
			$this->rua = $rua;
			$this->horario_abertura = $horario_abertura;
			$this->horario_fechamento = $horario_fechamento;
			$this->preco_entrada = $preco_entrada;
		}
		
		public function getId(){
			return $this->id;
		}
		
		public function setId($id){
			$this->id = $id;
		}
		
		public function getIdCategoria(){
			return $this->id_categoria;
		}
		
		public function setIdCategoria($id_categoria){
			$this->id_categoria = $id_categoria;
		}
		
		public function getNome(){
			return $this->nome;
		}
		
		public function setNome($nome){
			$this->nome = $nome;
		}
		
		public function getLatitude(){
			return $this->latitude;
		}
		
		public function setLatitude($latitude){
			$this->latitude = $latitude;
		}
		
		public function getLongitude(){
			return $this->longitude;
		}
		
		public function setLongitude($longitude){
			$this->longitude = $longitude;
		}
		
		public function getCidade(){
			return $this->cidade;
		}
		
		public function setCidade($cidade){
			$this->cidade = $cidade;
		}
		
		public function getEstado(){
			return $this->estado;
		}
		
		public function setEstado($estado){
			$this->estado = $estado;
		}
		
		public function getPais(){
			return $this->pais;
		}
		
		public function setPais($pais){
			$this->pais = $pais;
		}
		
		public function getRua(){
			return $this->rua;
		}
		
		public function setRua($rua){
			$this->rua = $rua;
		}
		
		public function getNumero(){
			return $this->numero;
		}
		
		public function setNumero($numero){
			$this->numero = $numero;
		}
		
		public function getHorarioAbertura(){
			return $this->horario_abertura;
		}
		
		public function setHorarioAbertura($horario_abertura){
			$this->horario_abertura = $horario_abertura;
		}
		
		public function getHorarioFechamento(){
			return $this->horario_fechamento;
		}
		
		public function setHorarioFechamento($horario_fechamento){
			$this->horario_fechamento = $horario_fechamento;
		}
		
		public function getPrecoEntrada(){
			return $this->preco_entrada;
		}
		
		public function setPrecoEntrada($preco_entrada){
			$this->preco_entrada = $preco_entrada;
		}
		
	}