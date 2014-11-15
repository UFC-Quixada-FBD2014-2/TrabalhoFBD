<?php
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Tourista</title>

<link href="http://fonts.googleapis.com/css?family=Open+Sans:600"
	type="text/css" rel="stylesheet" />
<!-- <link type="text/css" rel="stylesheet" href="css/bootstrap/bootstrap.min.css"/>-->
<link href="css/styleTelaInicial.css" type="text/css" rel="stylesheet" />




</head>

<body>

	<div id="apresentacao">

		<fieldset>
			
			
			<div class="campos">
                <label for="txtEndereco">Endereço:</label>
                <input type="text" id="txtEndereco" name="txtEndereco" />
                <input type="button" id="btnEndereco" name="btnEndereco" value="Mostrar no mapa" />
				<!-- <input type="button" class="btn btn-link btn-primary" id="cadastrar" name="cadastrar" value="Cadastrar-se"/> 
				<input type="button" class="btn btn-primary" id="login" name="login" value="Login" />-->
			</div>

			<div id="mapa"></div>


		</fieldset>	

	</div>

	<script
		src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBHju8OGAGzK6TSjG1DI8H8MNqiuFykD00&sensor=false"></script>
	<script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
	<script type="text/javascript" src="js/google-maps/markerclusterer.js"></script>
	<script type="text/javascript" src="js/google-maps/infoBox.js"></script>
	<script type="text/javascript" src="js/jquery-autocomplete.js"></script>
	<script type="text/javascript" src="js/mapaTelaInicial.js"></script>

</body>
</html>