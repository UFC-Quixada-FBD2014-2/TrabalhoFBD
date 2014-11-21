var geocoder;
var map;
var pontosTuristicos;
var idinfoBoxAberto;
var infoBox = [];
var markers = [];

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
		carregarpontosTuristicos();
	}
	
	
	function abririnfoBox(id, marker) {
	    if (typeof(idinfoBoxAberto) == 'number' && typeof(infoBox[idinfoBoxAberto]) == 'object') {
	        infoBox[idinfoBoxAberto].close();
	    }
	 
	    infoBox[id].open(map, marker);
	    idinfoBoxAberto = id;
	}
	
	function adicionarPontosAomapa(){
		var latlngbounds = new google.maps.LatLngBounds();
		for(i = 0 ; i < pontosTuristicos.length ; i++){
			latLngPonto = new google.maps.LatLng(pontosTuristicos[i].latitude, pontosTuristicos[i].longitude);
			nome = pontosTuristicos[i].nome;
			id = pontosTuristicos[i].id;
			
            var marker = new google.maps.Marker({
            	  map: map,
                  position: latLngPonto,
                  title: nome,
                  icon:'img/marcador-azul.png',
                  animation: google.maps.Animation.DROP
            });
            
            
            
            
            var content = [
                           '<h5>{{nome}}</h5>',
            			   '<p>',
	            				'<a class="btn btn-link" href="TelaPontoTuristico.php?idPontoTuristico={{id}}">',
	            					'Mais >>',
	            				'</a>',
            			   '</p>'
	        ].join('');
            
            var content = Mustache.to_html(content, pontosTuristicos[i]);
            	
            
            var myOptions = {
                content: content,
                pixelOffset: new google.maps.Size(-150, 0)
            };
         
            infoBox[id] = new InfoBox(myOptions);
            infoBox[id].marker = marker;
         
            infoBox[id].listener = google.maps.event.addListener(marker, 'click', function (e) {
                abririnfoBox(id, marker);
            });
            
            markers.push(marker);
            latlngbounds.extend(marker.position);
						
		}
		var markerCluster = new MarkerClusterer(map, markers);
		map.fitBounds(latlngbounds);
	}
	
	function carregarpontosTuristicos(){
		$.ajax({
			url:"../fronteiras/ajax/buscarTodosOsPontosTuristicos.php",
			dataType:"json",
			success:function(data){
				if(data != -5){
					pontosTuristicos = data;
					adicionarPontosAomapa();
					
				}
			},
			error:function(){
				
			}
		});
	}
	
	function carregarNomapa(endereco) {
		geocoder.geocode({ 'address': endereco + ', Brasil', 'region': 'BR' }, function (results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
				if (results[0]) {
					var latitude = results[0].geometry.location.lat();
					var longitude = results[0].geometry.location.lng();
		
					$('#txtEndereco').val(results[0].formatted_address);
		
					var location = new google.maps.LatLng(latitude, longitude);
					map.setCenter(location);
					map.setZoom(15);
				}
			}
		})
	}
	
	$("#btnEndereco").click(function() {
		if($(this).val() != "")
			carregarNomapa($("#txtEndereco").val());
	})
	
	$("#txtEndereco").blur(function() {
		if($(this).val() != "")
			carregarNomapa($(this).val());
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
			map.setCenter(location);
			map.setZoom(16);
		}
	});
	
	$("form").submit(function(event) {
		event.preventDefault();
		
	});

});