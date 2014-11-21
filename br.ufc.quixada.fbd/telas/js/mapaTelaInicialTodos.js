var geocoder;
var map;
var pontosTuristicos;
var idInfoBoxAberto;
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
		carregarPontosTuristicos();
	}

	
	function adicionarPontosAoMapa(){
		var latlngbounds = new google.maps.LatLngBounds();
		for(i = 0 ; i < pontosTuristicos.length ; i++){
			latLngPonto = new google.maps.LatLng(pontosTuristicos[i].latitude, pontosTuristicos[i].longitude);
			nome = pontosTuristicos[i].nome;
			id = pontosTuristicos[i].id;
			
			
            var marker = new google.maps.Marker({
                  position: latLngPonto,
                  title: nome,
                  icon:'img/marcador-azul.png',
                  animation: google.maps.Animation.DROP
            });
            
            
            var content = [
                           '<h5><a href="TelaPontosTuristicos.php?id={{id}}" title="Clique ver detalhes desse lugar...">{{nome}}</a></h5>',
            			   '<p id="tags{{id}}">',
            			   		'Tags: {{tags}}',
            			   '</p>',
	            		   '<a class="btn btn-link pull-right" title="Clique ver detalhes desse lugar..." href="TelaPontosTuristicos.php?id={{id}}">',
	            				'Mais >>',
	            		   '</a>'
            			   
	        ].join('');
            
            
            
            var content = Mustache.to_html(content, pontosTuristicos[i]);
            
            
            
            var myOptions = {
    				content: "<p>"+nome+"</p>",
    				pixelOffset: new google.maps.Size(-150, 0),
    				infoBoxClearance: new google.maps.Size(1, 1)
            	};
            	var info = new InfoBox(myOptions);

            	
            	var infowindow = new google.maps.InfoWindow(), marker;
            	 
            	google.maps.event.addListener(marker, 'click', (function(marker, i) {
            	    return function() {
            	        infowindow.setContent(content);
            	        infowindow.open(map, marker);
            	    }
            	})(marker))
    			
    			markers.push(marker);
            
            latlngbounds.extend(marker.position);
			
            
		}
		var markerCluster = new MarkerClusterer(map, markers);
		map.fitBounds(latlngbounds);
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
					map.setZoom(15);
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
			map.setCenter(location);
			map.setZoom(16);
		}
	});
	
	$("form").submit(function(event) {
		event.preventDefault();
		
	});

});