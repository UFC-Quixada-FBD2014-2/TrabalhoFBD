<?php
	Class Visita{
		
		private $emailTurista;
		private $idPontoTuristico;
		private $data;
		
		function __construct($data, $emailTurista, $idPontoTuristo){
			$this->data = $data;
			$this->idPontoTuristico = $idPontoTuristo;
			$this->emailTurista = $emailTurista;
		}
		
		public function getEmailTurista(){
			return $this->emailTurista;
		}
		
		public function setEmailTurista($emailTurista){
			$this->emailTurista = $emailTurista;
		}
		
		public function getIdPontoTuristico(){
			return $this->idPontoTuristico;
		}
		
		public function setIdPontoTuristico($idPontoTuristico){
			$this->idPontoTuristico = $idPontoTuristico;
		}
		
		public function getData(){
			return $this->data;
		}
		
		public function setData($data){
			$this->data = $data;
		}
	}
?>