<?php
	include_once 'br.ufc.quixada.fbd.enumeration/ConstantesMensagensExcecoes.php';
	
	Class FalhaPontoTuristicoNaoCadastrado extends Exception{
		function __construct(){
			parent::__construct(ConstantesMensagensExcecoes::FALHA_PONTO_TURISTICO_NAO_CADASTRADO);
		}
	}