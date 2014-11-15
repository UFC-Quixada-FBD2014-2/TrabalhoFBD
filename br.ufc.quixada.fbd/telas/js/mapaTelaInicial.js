var geocoder;
var map;
var pontosTuristicos;



$(document).ready(function () {

	initialize();
	
	function initialize() {
		var latlng = new google.maps.LatLng(-4.9683542,-39.016226,15);
		var options = {
			zoom: 15,
			center: latlng,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		};
		
		map = new google.maps.Map(document.getElementById("mapa"), options);
		
		geocoder = new google.maps.Geocoder();
		carregarPontosTuristicos();
	}
	
	
	
	
	function adicionarPontosAoMapa(){
		for(i = 0 ; i < pontosTuristicos.length ; i++){
			latLngPonto = new google.maps.LatLng(pontosTuristicos[i].latitude, pontosTuristicos[i].longitude);
			nome = pontosTuristicos[i].nome;
			id = pontosTuristicos[i].id;
			
            var marker = new google.maps.Marker({
            	  map: map,
                  position: latLngPonto,
                  title: nome,
                  url: '/',
                  animation: google.maps.Animation.DROP
            });
            
						
      }
	}
	
	function carregarPontosTuristicos(){
		$.ajax({
			url:"../fronteiras/ajax/buscarTodosOsPontosTuristicos.php",
			dataType:"json",
			success:function(data){
				if(data != -5){
					pontosTuristicos = data;
					adicionarPontosAoMapa();
				}
			},
			error:function(){
				
			}
		});
	}
	
	function carregarNoMapa(endereco) {
		geocoder.geocode({ 'address': endereco + ', Brasil', 'region': 'BR' }, function (results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
				if (results[0]) {
					var latitude = results[0].geometry.location.lat();
					var longitude = results[0].geometry.location.lng();
		
					$('#txtEndereco').val(results[0].formatted_address);
		
					var location = new google.maps.LatLng(latitude, longitude);
					map.setCenter(location);
				}
			}
		})
	}
	
	$("#btnEndereco").click(function() {
		if($(this).val() != "")
			carregarNoMapa($("#txtEndereco").val());
	})
	
	$("#txtEndereco").blur(function() {
		if($(this).val() != "")
			carregarNoMapa($(this).val());
	});
	
	$("#txtEndereco").autocomplete({
		source: function (request, response) {
			geocoder.geocode({ 'address': request.term + ', Brasil', 'region': 'BR' }, function (results, status) {
				response($.map(results, function (item) {
					return {
						label: item.formatted_address,
						value: item.formatted_address,
						latitude: item.geometry.location.lat(),
          				longitude: item.geometry.location.lng()
					}
				}));
			})
		},
		select: function (event, ui) {
			var location = new google.maps.LatLng(ui.item.latitude, ui.item.longitude);
			marker.setPosition(location);
			map.setCenter(location);
			map.setZoom(16);
		}
	});
	
	$("form").submit(function(event) {
		event.preventDefault();
		
	});

});