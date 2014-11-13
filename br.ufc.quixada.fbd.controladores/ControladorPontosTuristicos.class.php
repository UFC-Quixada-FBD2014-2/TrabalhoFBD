<?php
	include_once 'br.ufc.quixada.fbd.repositorios/RepositorioPontosTuristicos.class.php';
	include_once 'br.ufc.quixada.fbd.sgbd/FalhaAoCriarConexao.class.php';
	include_once 'br.ufc.quixada.fbd.repositorios/FalhaAoExecutarQuery.class.php';
	include_once 'br.ufc.quixada.fbd.repositorios/FalhaPrepareStatement.class.php';
	include_once 'br.ufc.quixada.fbd.repositorios/FalhaPontoTuristicoNaoCadastrado.class.php';

	Class ControladorPontosTuristicos{
		
		private $repositorioPontosTuristicos;
			
		function __construct(){
			$this->repositorioPontosTuristicos = new RepositorioPontosTuristicos();
		}
		
		function cadastrarPontoTuristico(){
			if(isset($_POST['nome'], $_POST['latitude'], $_POST['longitude'], $_POST['rua'], $_POST['cidade'],
					 $_POST['estado'],	$_POST['pais'], $_POST['tags'], $_POST['bairro'], $_POST['numero'],
					 $_POST['precoEntrada'], $_POST['horarioAbertura'], $_POST['horarioFechamento'])){
				
				$nome = $_POST['nome'];
				$latitude = $_POST['latitude'];
				$longitude = $_POST['longitude'];
				$rua = $_POST['rua'];
				$cidade = $_POST['cidade'];
				$estado = $_POST['estado'];
				$pais = $_POST['pais'];
				$tags = $_POST['tags'];
				$bairro = $_POST['bairro'];
				$numero = $_POST['numero'];
				$precoEntrada = $_POST['precoEntrada'];
				$horarioAbertura = $_POST['horarioAbertura'];
				$horarioFechamento = $_POST['horarioFechamento'];
				
				
				$novoPontoTuristico = new PontoTuristico($nome, $latitude, $longitude, $cidade, $estado, $pais, $rua, $numero, $bairro, $preco_entrada, $horario_abertura, $horario_fechamento, $tags);
				try {
					$this->repositorioPontosTuristicos->cadastrar($novoPontoTuristico);
					return ConstantesMensagensFeedback::SUCESSO;
				} catch (Exception $e){
					return ConstantesMensagensFeedback::FALHA_NO_BANCO;
				}	
			}else{
				return ConstantesMensagensFeedback::FALHA_NOS_PARAMETROS;
			}
		}
				
		function removerPontoTuristico(){
			if(isset($_POST['idPontoTuristico'])){
				$idPontoTuristico = $_POST['idPontoTuristico'];
				try {
					$this->repositorioPontosTuristicos->remover($idPontoTuristico);
					return ConstantesMensagensFeedback::SUCESSO;
				} catch (Exception $e){
					return ConstantesMensagensFeedback::FALHA_NO_BANCO;
				}
			}else{
				return ConstantesMensagensFeedback::FALHA_NOS_PARAMETROS;
			}
		}
		
		function atualizarPontoTuristico(){
			if(isset($_POST['nome'], $_POST['latitude'], $_POST['longitude'], $_POST['rua'], $_POST['cidade'],
					 $_POST['estado'],	$_POST['pais'], $_POST['tags'], $_POST['bairro'], $_POST['numero'],
					 $_POST['precoEntrada'], $_POST['horarioAbertura'], $_POST['horarioFechamento'])){
				
				$nome = $_POST['nome'];
				$latitude = $_POST['latitude'];
				$longitude = $_POST['longitude'];
				$rua = $_POST['rua'];
				$cidade = $_POST['cidade'];
				$estado = $_POST['estado'];
				$pais = $_POST['pais'];
				$tags = $_POST['tags'];
				$bairro = $_POST['bairro'];
				$numero = $_POST['numero'];
				$precoEntrada = $_POST['precoEntrada'];
				$horarioAbertura = $_POST['horarioAbertura'];
				$horarioFechamento = $_POST['horarioFechamento'];
				
				
				$novoPontoTuristico = new PontoTuristico($nome, $latitude, $longitude, $cidade, $estado, $pais, $rua, $numero, $bairro, $preco_entrada, $horario_abertura, $horario_fechamento, $tags);
				try {
					$this->repositorioPontosTuristicos->atualizar($pontoTuristico);
					return ConstantesMensagensFeedback::SUCESSO;
				} catch (Exception $e){
					return ConstantesMensagensFeedback::FALHA_NO_BANCO;
				}
			}else{
				return ConstantesMensagensFeedback::FALHA_NOS_PARAMETROS;
			}
		}
		
		function pegarPontoTuristicoPorId(){
			if(isset($_POST['idPontoTuristico'])){
				try {
					$idPontoTuristico = $_POST['idPontoTuristico'];
					
					$pontoTuristico = $this->repositorioPontosTuristicos->pegarPontoTuristicoPorId($idPontoTuristico);
					return $pontoTuristico;
				} catch (Exception $e){
					return ConstantesMensagensFeedback::FALHA_NO_BANCO;
				}
			}else{
				return ConstantesMensagensFeedback::FALHA_NOS_PARAMETROS;
			}
		}
		
		function pegarTodosOsPontosTuristicosVisitadosPorUmTurista(){
			if(isset($_POST['idTurista'])){
				$idTurista = $_POST['idTurista'];
				try {
					$pontosTuristicos = $this->repositorioPontosTuristicos->pegarTodosOsPontosTuristicosVisitadosPorUmTurista($idTurista);
					return $pontosTuristicos;
				} catch (Exception $e){
					return ConstantesMensagensFeedback::FALHA_NO_BANCO;
				}
			}else{
				return ConstantesMensagensFeedback::FALHA_NOS_PARAMETROS;
			}
		}
		
		function pegarTodosOsPontosTuristicos(){
			try {
				return $this->repositorioPontosTuristicos->pegarTodosOsTuristas();
				echo json_encode(ConstantesMensagensFeedback::SUCESSO);
			} catch (Exception $e){
				echo json_encode(ConstantesMensagensFeedback::FALHA_NO_BANCO);
			}
		}
		
	}
	
	$acao = $_POST['acao'];
	$controlador = new ControladorPontosTuristicos();
	if($acao == "cadastrar"){
		$retorno = $controlador->cadastrarPontoTuristico();
		if($retorno == ConstantesMensagensFeedback::SUCESSO){
			//TODO: modificar tela
		}
	}else if($acao == "remover"){
		$controlador->removerPontoTuristico();
	}else if($acao == "atualizar"){
		$controlador->atualizarPontoTuristico();
	}else if($acao == "pegar_ponto_turistico_id"){
		$controlador->pegarPontoTuristicoPorId();
	}else if($acao == "pegar_pontos_visitados_por_turista"){
		$controlador->pegarTodosOsPontosTuristicosVisitadosPorUmTurista();
	}else if($acao == "pegar_todos_pontos_turisticos"){
		$controlador->pegarTodosOsPontosTuristicos();
	}else{
		
	}
?>