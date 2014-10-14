<?php
	include_once 'br.ufc.quixada.fbd.Controladores/ControladorTuristas.class.php';
	include_once 'br.ufc.quixada.fbd.Entidades/Turista.class.php';
	
	$turista = new Turista('nome', 'email', 'senha', 123213, 1);
	echo "1";
	
	$controlador = new ControladorTuristas();
	
	echo "2";
	
	$controlador->cadastrarTurista($turista);
	
	echo "3";
	
	
	