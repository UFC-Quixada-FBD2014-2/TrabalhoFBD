<?php
	include_once 'br.ufc.quixada.fbd.enumeration/ConstantesMensagensExcecoes.php';

	Class FalhaTuristaNaoCadastrado extends Exception{
		function __construct(){
			parent::__construct(ConstantesMensagensExcecoes::FALHA_TURISTA_NAO_CADASTRADO);
		}	
	}