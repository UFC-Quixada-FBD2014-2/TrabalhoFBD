<?php
	include_once __DIR__.'/../enumeration/ConstantesMensagensExcecoes.php';
	
	Class FalhaAoRealizarLogin extends Exception{
		function __construct(){
			parent::__construct(ConstantesMensagensExcecoes::FALHA_AO_REALIZAR_LOGIN);
				
		}
	}