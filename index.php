<?php
	include_once 'br.ufc.quixada.fbd.controladores/ControladorTuristas.class.php';
	include_once 'br.ufc.quixada.fbd.entidades/Turista.class.php';
	include_once 'br.ufc.quixada.fbd.enumeration/ConstantesMensagensExcecoes.php';
	
	$turista = new Turista('nome', 'email', 'senha', 123213, 1);
	echo "1";
	
	$controlador = new ControladorTuristas();
	
	echo "2";
	
	$controlador->cadastrarTurista($turista);
	
	echo '3<br>';
	
	echo ConstantesMensagensExcecoes::FALHA_AO_CRIAR_CONEXAO.'<br>';
	echo ConstantesMensagensExcecoes::FALHA_AO_EXECUTAR_QUERY.'<br>';
	echo ConstantesMensagensExcecoes::PREPARE_STATEMENT_FALHA.'<br>';
?>
	
	
	