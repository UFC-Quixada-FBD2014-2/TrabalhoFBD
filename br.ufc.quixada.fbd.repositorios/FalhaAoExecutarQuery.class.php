<?php
	include_once 'br.ufc.quixada.fbd.enumeration/ConstantesMensagensExcecoes.php';
	
	Class FalhaAoExecutarQuery extends Exception{
		function __construct(){
			parent::__construct(ConstantesMensagensExcecoes::FALHA_AO_EXECUTAR_QUERY);
			
		}
	}
?>