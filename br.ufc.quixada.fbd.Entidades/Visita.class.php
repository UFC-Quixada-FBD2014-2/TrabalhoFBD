<?php
	Class Visita{
		
		private $id_turista;
		private $id_ponto_turistico;
		private $data;
		
		function __construct($data, $id_turista, $id_ponto_turistico){
			$this->data = $data;
			$this->id_ponto_turistico = $id_ponto_turistico;
			$this->id_turista = $id_turista;
		}
		
		public function getId_turista(){
			return $this->id_turista;
		}
		
		public function setId_turista($id_turista){
			$this->id_turista = $id_turista;
		}
		
		public function getId_ponto_turistico(){
			return $this->id_ponto_turistico;
		}
		
		public function setId_ponto_turistico($id_ponto_turistico){
			$this->id_ponto_turistico = $id_ponto_turistico;
		}
		
		public function getData(){
			return $this->data;
		}
		
		public function setData($data){
			$this->data = $data;
		}
	}