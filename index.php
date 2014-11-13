<?php
	include_once 'br.ufc.quixada.fbd.controladores/ControladorTuristas.class.php';
	include_once 'br.ufc.quixada.fbd.entidades/Turista.class.php';
	include_once 'br.ufc.quixada.fbd.enumeration/ConstantesMensagensExcecoes.php';
	
	$turista = new Turista('nome', 'asdsadsasdasd', 'senha', 123213, 1);
	
	$controlador = new ControladorTuristas();

	//$controlador->cadastrarTurista($turista);
	
	try {
		print_r($controlador->pegarTodosOsTuristas());
	} catch (Exception $e) {
		echo $e->getMessage();
	}
	
?>
	
	
	