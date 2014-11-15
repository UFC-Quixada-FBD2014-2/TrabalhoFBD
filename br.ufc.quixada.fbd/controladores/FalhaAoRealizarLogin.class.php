<?php
	include_once __DIR__.'/../enumeration/ConstantesMensagensExcecoes.php';
	
	Class FalhaAoExecutarQuery extends Exception{
		function __construct(){
			parent::__construct(ConstantesMensagensExcecoes::FALHA_AO_REALIZAR_LOGIN);
				
		}
	}