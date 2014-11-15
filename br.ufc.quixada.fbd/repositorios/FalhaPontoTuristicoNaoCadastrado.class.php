<?php
	include_once __DIR__.'/../enumeration/ConstantesMensagensExcecoes.php';
	
	Class FalhaPontoTuristicoNaoCadastrado extends Exception{
		function __construct(){
			parent::__construct(ConstantesMensagensExcecoes::FALHA_PONTO_TURISTICO_NAO_CADASTRADO);
		}
	}