var geocoder;
var map;
var marker;

$(document).ready(function () {

	if($('#mapa').length > 0){ 
		initialize();
	}
	
	function initialize() {
		var latlng = new google.maps.LatLng(-4.9654896, -39.0241654,15);
		var options = {
				zoom: 18,
				center: latlng,
				mapTypeId: google.maps.MapTypeId.ROADMAP
		};

		map = new google.maps.Map(document.getElementById("mapa"), options);

		geocoder = new google.maps.Geocoder();

		marker = new google.maps.Marker({
			map: map,
			draggable: true,
		});

		marker.setPosition(latlng);
		
		atualizarEnderecoDoMapaParaOInformado();
	}

	function atualizarEnderecoDoMapaParaOInformado(){
		var pais = $("#pais").val();
		var cidade = $("#cidade").val();
		var estado = $("#estado").val();
		var rua = $("#rua").val();
		var numero = $("#numero").val();
		var bairro = $("#bairro").val();
		
		var endereco = rua+" "+bairro+" "+numero+" "+cidade+" "+estado+" "+pais;
		if(endereco.trim() != ""){
			carregarNoMapa(endereco);
		}
	}
	
	$('* .endereco').blur(function(){
		atualizarEnderecoDoMapaParaOInformado();
	});
	
	function buscandoAddressComponent(tipoDoComponente, resultadoDaBusca){
        for(var i=0; i<resultadoDaBusca.address_components.length; i++){
            if(resultadoDaBusca.address_components[i].types[0] == tipoDoComponente){
                return resultadoDaBusca.address_components[i].long_name;
            }
        }
        return null;
    }

	function carregarNoMapa(endereco) {
		geocoder.geocode({ 'address': endereco + ', Brasil', 'region': 'BR' }, function (results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
				if (results[0]) {
					var latitude = results[0].geometry.location.lat();
					var longitude = results[0].geometry.location.lng();

					$('#latitude').val(latitude);
					$('#longitude').val(longitude);
					
					var rua = buscandoAddressComponent('route', results[0]);
                    var bairro = buscandoAddressComponent('neighborhood', results[0]);
                    var cidade = buscandoAddressComponent('locality', results[0]);
                    var pais = buscandoAddressComponent('country', results[0]);
                    var estado = buscandoAddressComponent('administrative_area_level_1', results[0]);
                    
                    if($('#rua').val() == "") $('#rua').val(rua);
                    if($('#bairro').val() == "") $('#bairro').val(bairro);
                    if($('#cidade').val() == "") $('#cidade').val(cidade);
                    if($('#pais').val() == "") $('#pais').val(pais);
                    if($('#estado').val() == "") $('#estado').val(estado);
                    
					var location = new google.maps.LatLng(latitude, longitude);
					marker.setPosition(location);
					map.setCenter(location);
					map.setZoom(16);
				}
			}
		});
	}

	google.maps.event.addListener(marker, 'drag', function () {
		geocoder.geocode({ 'latLng': marker.getPosition() }, function (results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
				if (results[0]) { 
					var rua = buscandoAddressComponent('route', results[0]);
                    var bairro = buscandoAddressComponent('neighborhood', results[0]);
                    var cidade = buscandoAddressComponent('locality', results[0]);
                    var pais = buscandoAddressComponent('country', results[0]);
                    var estado = buscandoAddressComponent('administrative_area_level_1', results[0]);
					
                    $("#rua").val(rua);
                    $('#bairro').val(bairro);
                    $('#cidade').val(cidade);
                    $('#pais').val(pais);
                    $('#estado').val(estado);
                    
					$('#latitude').val(marker.getPosition().lat());
					$('#longitude').val(marker.getPosition().lng());
				}
			}
		});
	});

});