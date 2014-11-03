<?php
	include_once 'br.ufc.quixada.fbd.controladores/ControladorTuristas.class.php';
	include_once 'br.ufc.quixada.fbd.entidades/Turista.class.php';
	include_once 'br.ufc.quixada.fbd.enumeration/ConstantesMensagensExcecoes.php';
	
	$turista = new Turista('nome', 'email', 'senha', 123213, 1);
	
	$controlador = new ControladorTuristas();

	
	try {
		$controlador->removerTurista($turista);
	} catch (FalhaAoRemoverTurista $e) {
		echo $e->getMessage()."<br>".$e->getExceptionInferior()->getMessage();
	}
	
?>
	
	
	