<?php
	include_once 'br.ufc.quixada.fbd.enumeration/ConstantesMensagensExcecoes.php';
	
	Class FalhaAoRealizarLogin extends Exception{
	
		function __construct(Exception $e){
			parent::__construct(ConstantesMensagensExcecoes::FALHA_AO_REALIZAR_LOGIN);
		}
	
	}