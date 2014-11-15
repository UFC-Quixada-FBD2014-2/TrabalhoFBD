<?php
	include_once __DIR__.'/../../repositorios/RepositorioPontosTuristicos.class.php';
	include_once __DIR__.'/../../enumeration/ConstantesMensagensFeedback.class.php';
		
	$repositorioPontosTuristicos = new RepositorioPontosTuristicos();
	
	$pontosTuristicos = $repositorioPontosTuristicos->pegarTodosOsPontosTuristicos();
	
	if($pontosTuristicos != null){
		$pontos = Array();
		foreach ($pontosTuristicos as $pontoTuristico){
			$ponto = Array('latitude'=>$pontoTuristico->getLatitude(), 'longitude'=>$pontoTuristico->getLongitude(),
					'nome'=>$pontoTuristico->getNome(),'id'=>$pontoTuristico->getId());
			array_push($pontos, $ponto);
		}
		echo json_encode($pontos);
	}else{
		echo ConstantesMensagensFeedback::FALHA_AJAX_RETORNO;
	}
?>