<?php
include_once 'br.ufc.quixada.fbd.enumeration/ConstantesMensagensExcecoes.php';

Class FalhaAoBuscarTurista extends Exception{
	private $exceptionInferior;

	function __construct(Exception $e){
		parent::__construct(ConstantesMensagensExcecoes::FALHA_AO_BUSCAR_TURISTA);
		$this->exceptionInferior = $e;
	}

	public function getExceptionInferior(){
		return $this->exceptionInferior;
	}
}