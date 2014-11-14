<?php
	include_once 'br.ufc.quixada.fbd.enumeration/ConstantesMensagensExcecoes.php';
	
	Class FalhaPrepareStatement extends Exception{
		function __construct(){
			parent::__construct(ConstantesMensagensExcecoes::FALHA_PREPARE_STATEMENT);
		}
	}
?>	