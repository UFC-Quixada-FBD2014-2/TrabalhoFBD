var geocoder;
var map;
var pontosTuristicos;
var idInfoBoxAberto;
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
		
		map = new google.maps.Map(document.getElementById("mapaTodos"), options);
		
		geocoder = new google.maps.Geocoder();
		carregarPontosTuristicos();
	}
	
	
	function abrirInfoBox(id, marker) {
	    if (typeof(idInfoBoxAberto) == 'number' && typeof(infoBox[idInfoBoxAberto]) == 'object') {
	        infoBox[idInfoBoxAberto].close();
	    }
	 
	    infoBox[id].open(map, marker);
	    idInfoBoxAberto = id;
	}
	
	function adicionarPontosAoMapa(){
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
                  url: '/',
                  animation: google.maps.Animation.DROP
            });
            
            
            
            var infowindow = new google.maps.InfoWindow(), marker;
            
            var content = "<h5>"+nome+"</h5></br><p>Conteúdo</p>"
            
            /*google.maps.event.addListener(marker, 'click', (function(marker, i) {
                return function() {
                    infowindow.setContent(content);
                    infowindow.open(map, marker);
                }
            })(marker));*/
            
            var myOptions = {
                content: content,
                pixelOffset: new google.maps.Size(-150, 0)
            };
         
            infoBox[id] = new InfoBox(myOptions);
            infoBox[id].marker = marker;
         
            infoBox[id].listener = google.maps.event.addListener(marker, 'click', function (e) {
                abrirInfoBox(id, marker);
            });
            
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
		
					$('#txtEnderecoTodos').val(results[0].formatted_address);
		
					var location = new google.maps.LatLng(latitude, longitude);
					map.setCenter(location);
					map.setZoom(15);
				}
			}
		})
	}
	
	$("#btnEnderecoTodos").click(function() {
		if($(this).val() != "")
			carregarNoMapa($("#txtEnderecoTodos").val());
	})
	
	$("#txtEnderecoTodos").blur(function() {
		if($(this).val() != "")
			carregarNoMapa($(this).val());
	});
	
	$("#txtEnderecoTodos").autocomplete({
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