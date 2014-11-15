<?php
	include_once __DIR__.'/../enumeration/ConstantesMensagensExcecoes.php';
	
	Class FalhaPrepareStatement extends Exception{
		function __construct(){
			parent::__construct(ConstantesMensagensExcecoes::FALHA_PREPARE_STATEMENT);
		}
	}
?>	