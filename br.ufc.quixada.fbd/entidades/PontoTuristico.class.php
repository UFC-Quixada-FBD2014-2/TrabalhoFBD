<?php
	Class PontoTuristico{
		
		private $id;
		private $tags;
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
		private $bairro;
		
		function __construct($nome, $latitude, $longitude, $cidade, $estado, $pais, $rua, $numero, $bairro, $preco_entrada, $horario_abertura, $horario_fechamento, $tags="", $id=""){
			$this->nome = $nome;
			$this->cidade = $cidade;
			$this->estado = $estado;
			$this->id = $id;
			$this->tags = tags;
			$this->latitude = $latitude;
			$this->longitude = $longitude;
			$this->numero = $numero;
			$this->pais = $pais;
			$this->rua = $rua;
			$this->horario_abertura = $horario_abertura;
			$this->horario_fechamento = $horario_fechamento;
			$this->preco_entrada = $preco_entrada;
			$this->bairro = $bairro;
		}
		
		public function getBairro(){
			return $this->bairro;
		}
		
		public function setBairro($bairro){
			$this->bairro = $bairro;
		}
		
		public function getId(){
			return $this->id;
		}
		
		public function setId($id){
			$this->id = $id;
		}
		
		public function getTags(){
			return $this->tags;
		}
		
		public function setTags($tags){
			$this->tags = $tags;
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
?>