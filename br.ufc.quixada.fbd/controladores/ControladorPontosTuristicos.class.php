<?php
	include_once __DIR__.'/../repositorios/RepositorioPontosTuristicos.class.php';
	include_once __DIR__.'/../sgbd/FalhaAoCriarConexao.class.php';
	include_once __DIR__.'/../repositorios/FalhaAoExecutarQuery.class.php';
	include_once __DIR__.'/../repositorios/FalhaPrepareStatement.class.php';
	include_once __DIR__.'/../enumeration/ConstantesMensagensFeedback.class.php';
	include_once __DIR__.'/../repositorios/FalhaPontoTuristicoNaoCadastrado.class.php';
	include_once __DIR__.'/../entidades/PontoTuristico.class.php';
	include_once __DIR__.'/../controladores/ControladorLogin.class.php';
	include_once __DIR__.'/../repositorios/RepositorioVisitas.class.php';
	include_once __DIR__.'/../entidades/Visita.class.php';
	
	Class ControladorPontosTuristicos{
		
		private $repositorioPontosTuristicos;
		private $repositorioVisitas;
			
		function __construct(){
			$this->repositorioPontosTuristicos = new RepositorioPontosTuristicos();
			$this->repositorioVisitas =  new RepositorioVisitas();
		}
		
		function cadastrarPontoTuristico(){
			if(isset($_POST['nome'], $_POST['latitude'], $_POST['longitude'], $_POST['rua'], $_POST['cidade'],
					 $_POST['estado'],	$_POST['pais'], $_POST['bairro'])){
				
				
				
				$nome = $_POST['nome'];
				$latitude = $_POST['latitude'];
				$longitude = $_POST['longitude'];
				$rua = $_POST['rua'];
				$cidade = $_POST['cidade'];
				$estado = $_POST['estado'];
				$pais = $_POST['pais'];
				$tags = split( "," , $_POST['tags']);
				$bairro = $_POST['bairro'];
				$numero = $_POST['numero'];
				$precoEntrada = $_POST['precoEntrada'];
				$horarioAbertura = $_POST['horarioAbertura'];
				$horarioFechamento = $_POST['horarioFechamento'];
				
				
				$emailLogado = $_SESSION['email'];
				
				$novoPontoTuristico = new PontoTuristico($nome, $latitude, $longitude, $cidade, $estado, $pais, $rua, $numero, $bairro, $precoEntrada, $horarioAbertura, $horarioFechamento, $tags);
				try {
					$this->repositorioPontosTuristicos->cadastrar($novoPontoTuristico, $emailLogado);
					
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
				$tags = split( "," , $_POST['tags']);
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
			} catch (Exception $e){
				return json_encode(ConstantesMensagensFeedback::FALHA_NO_BANCO);
			}
		}
		
		function cadastrarPontoTuristicoFavorito(){
			
			if(isset($_POST['idPontoTuristico'])){
					$idPontoTuristico  = $_POST['idPontoTuristico'];
					$emailLogado = $_SESSION['email'];
					
					try{
						$this->repositorioPontosTuristicos->cadastrarPontoTuristicoFavorito($idPontoTuristico, $emailLogado);
						return json_encode(ConstantesMensagensFeedback::SUCESSO);
					}catch (Exception $e){
						return json_encode(ConstantesMensagensFeedback::FALHA_NO_BANCO);
					}
			}
		}
		
		function removerPontoTuristicoDosFavoritosTurista(){
			
			if(isset($_POST['idPontoTuristico'])){
				$idPontoTuristico  = $_POST['idPontoTuristico'];
				$emailLogado = $_SESSION['email'];
					
				try{
					$this->repositorioPontosTuristicos->removerPontoTuristicoDosFavoritosTurista($idPontoTuristico, $emailLogado);
					return json_encode(ConstantesMensagensFeedback::SUCESSO);
				}catch (Exception $e){
					return json_encode(ConstantesMensagensFeedback::FALHA_NO_BANCO);
				}
			}
		}
		
		function pegarPontosTuristicosFavoritos(){
			
			$emailLogado = $_SESSION['email'];
			
			try {
				return $this->repositorioPontosTuristicos->
				 pegarPontosTuristicosFavoritosTurista($emailLogado);
				
			}catch (Exception $e){
				return json_encode(ConstantesMensagensFeedback::FALHA_NO_BANCO);
			}
		}
		
		function cadastrarAvaliacaoPontoTuristico(){
			
			$emailLogado = $_SESSION['email'];
			
			if(isset($_POST['valorAvaliado'], $_POST['idPontoTuristico'])){
				
				$valorAvaliado = $_POST['valorAvaliado'];
				$idPontoTuristico = $_POST['idPontoTuristico'];
				
				try {
					if($this->repositorioPontosTuristicos->pegarValorPontoTuristicoJaAvaliadoPelo($emailLogado, $idPontoTuristico) == 0){
						$this->repositorioPontosTuristicos->cadastrarAvaliacaoPontoTuristico($valorAvaliado, $idPontoTuristico, $emailLogado);
					}else{
						$this->repositorioPontosTuristicos->atualizarAvaliacaoPontoTuristico($valorAvaliado, $idPontoTuristico, $emailLogado);
					}
						
				}catch (Exception $e){
					return json_encode(ConstantesMensagensFeedback::FALHA_NO_BANCO);
				}
			}
			
		}
		
		function cadastrarVisita(){
		
			$emailLogado = $_SESSION['email'];
			if(isset($_POST['idPontoTuristico'])){
				$idPontoTuristico = $_POST['idPontoTuristico'];
				$data = time();
					
				$visita = new Visita($data, $emailLogado, $idPontoTuristico);
				
					
				try {
					$this->repositorioVisitas->cadastrar($visita);
				}catch (Exception $e){
					return json_encode(ConstantesMensagensFeedback::FALHA_NO_BANCO);
				}
					
			}
		}
	}
	
	if(isset($_POST['acao'])){
		$acao = $_POST['acao'];
		$controlador = new ControladorPontosTuristicos();
		$controladorLogin = new ControladorLogin();
		$controladorLogin->iniciarSessao();
		
		if(!$controladorLogin->checarLogin()){
			header("location: ../telas/TelaInicial.php");
			exit(); //TODO : REVER
		}
		
		
		if($acao == "cadastrar"){
			$retorno = $controlador->cadastrarPontoTuristico();
			if($retorno == ConstantesMensagensFeedback::SUCESSO){
				header("Location: ../telas/TelaInicial.php");
			}else{
				header("Location: ../telas/CadastroPontoTuristico.php?success=false");
			}
			
		}else if($acao == "cadastrar_ponto_turistico_favorito"){
			$retorno = $controlador->cadastrarPontoTuristicoFavorito();
			
		}else if($acao == "remover"){
			$retorno = $controlador->removerPontoTuristico();
			header("Location: ../telas/MeusPontos.php");
		}else if($acao == "atualizar"){
			$controlador->atualizarPontoTuristico();
		}else if($acao == "pegar_ponto_turistico_id"){
			$controlador->pegarPontoTuristicoPorId();
		}else if($acao == "pegar_pontos_visitados_por_turista"){
			$controlador->pegarTodosOsPontosTuristicosVisitadosPorUmTurista();
		}else if($acao == "pegar_todos_pontos_turisticos"){
			$controlador->pegarTodosOsPontosTuristicos();
		}else if($acao == "pegar_pontos_turisticos_favoritos"){
			$controlador->pegarPontosTuristicosFavoritos();
		}else if($acao == "remover-ponto-turistico-dos-favoritos"){
			$controlador->removerPontoTuristicoDosFavoritosTurista();
		}else if($acao == "cadastrar_avaliacao_ponto_turistico"){
			$controlador->cadastrarAvaliacaoPontoTuristico();
		}else if($acao == "add-visita"){
			$controlador->cadastrarVisita();
		}else{
			
		}
	}
?>
