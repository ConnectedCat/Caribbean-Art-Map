<html>
<head>
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
	<link href='//api.tiles.mapbox.com/mapbox.js/v1.3.1/mapbox.css' rel='stylesheet' />
	<!--[if lte IE 8]>
    	<link href='//api.tiles.mapbox.com/mapbox.js/v1.3.1/mapbox.ie.css' rel='stylesheet' />
    <![endif]-->
    <script src='//api.tiles.mapbox.com/mapbox.js/v1.3.1/mapbox.js'></script>
    <!----- FOR MARKER CLUSTERS ------>
    <link rel="stylesheet" href="http://connectedcatmedia.com/freshmilk3/plugins/cluster/dist/MarkerCluster.css" />
	<link rel="stylesheet" href="http://connectedcatmedia.com/freshmilk3/plugins/cluster/dist/MarkerCluster.Default.css" />
	<!--[if lte IE 8]>
	  <link rel="stylesheet" href="http://connectedcatmedia.com/freshmilk3/plugins/cluster/dist/MarkerCluster.Default.ie.css" />
	<![endif]-->
	<script src="http://connectedcatmedia.com/freshmilk3/plugins/cluster/dist/leaflet.markercluster.js"></script>
	<!---- FOR FULLSCREEN CONTROLS ----->
	<link rel="stylesheet" href="http://connectedcatmedia.com/freshmilk3/plugins/fullscreen/Control.FullScreen.css" />
	<script src="http://connectedcatmedia.com/freshmilk3/plugins/fullscreen/Control.FullScreen.js"></script>
	<!---- ADD SOME JQUERY ------------>
	<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
	<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
	<!----ADD GOOGLE FONT ------------->
	<link href='http://fonts.googleapis.com/css?family=Muli' rel='stylesheet' type='text/css'>
	
    <style>
    	html { height: 100% }
    	body { height: 100%; margin: 0; padding: 0 }
    	#map { height: 100% }
    	
    	.my-legend .legend-title {
	    	text-align: left;
	    	margin-bottom: 8px;
	    	font-weight: bold;
	    	font-size: 90%;
	    }
	    .my-legend .legend-scale{
	    	width: 167px;
	    	height: 60px;
	    	background-image: url('img/FreshMilk_logo.png');
	    }
	    .map-legend {
		    padding: 0 !important;
	    }
    	
    	#map-ui {
	        position: absolute;
	        top: 10px;
	        right: 10px;
	        z-index: 100;
	    }
	
	    #map-ui ul {
	        list-style: none;
	        margin: 0;
	        padding: 0;
	    }
	
	    #map-ui a, h3 {
	    	font-family: 'Muli', sans-serif;
	        font-size: 13px;
	        background: #FFF;
	        color: #3C4E5A;
	        display: block;
	        margin: 0;
	        padding: 0;
	        border: 1px solid #BBB;
	        border-bottom-width: 0;
	        min-width: 138px;
	        padding: 10px;
	        text-decoration: none;
	    }
	
	    #map-ui a:hover {
	        background: #ECF5FA;
	    }
	
	    #map-ui li:last-child a {
	        border-bottom-width: 1px;
	        -webkit-border-radius: 0 0 3px 3px;
	        border-radius: 0 0 3px 3px;
	    }
	
	    #map-ui li:first-child a {
	        -webkit-border-radius: 3px 3px 0 0;
	        border-radius: 3px 3px 0 0;
	    }
	
	    #map-ui a.active {
	        background: #5a6872;
	        border-color: #3887BE;
	        color: #FFF;
	    }
	    
	    .actioncall {
		    float: right;
	    }
	    .popup {
		    text-align: center;
		}
		.popup .slideshow {
		    width: 100%;
		}
		.popup .slideshow .image {
		    display: none;
		}
		.popup .slideshow .active {
		    display: block;
		}
		.popup .slideshow img {
		    width: 100%;
		}
		.popup .slideshow .caption {
		    background: #eee;
		    padding: 8px;
		}
		.popup .cycle {
		    height: 30px;
		    margin-top: 5px;
		    padding-top: 5px;
		}
		.popup .cycle a.prev {
		    float: left;
		}
		.popup .cycle a.next {
		    float: right;
		}
		
		.pan {
		    position: absolute;
		    top: 107px;
		    left: 10px;
		    z-index: 999;
		}
		
		.wrapper {
		    position: relative;
		}
		
		.pan .wrapper .panner {
		    background: #fff;
		    font-family: 'Muli', sans-serif;
	        font-size: 10px;
	        font-weight: 700;
		    position: absolute;
		    left: -10px;
		    top: 25px;
		    width: 16px;
		    height: 16px;
		    padding: 6px 5px 5px;
		    border: 1px solid #bbb;
		    border-radius: 2px;
		    text-align: center;
		    -webkit-user-select: none;
		    color: #000;
		}
		
		.nodisplay {
			display: none;
		}
		
  </style>
</head>
<body>

	<div id='map'>
		<div id='map-ui'>
			<h3 id="spaces" class="select">Art Spaces<span id="spaces-plus" class="actioncall">+</span></h3>
			<ul>
		        <li><a href='#' class='filterspace' id='filter-art'>Art Galleries</a></li>
		        <li><a href='#' class='filterspace' id='filter-cultural'>Cultural Institutions</a></li>
		        <li><a href='#' class='filterspace' id='filter-edu'>Education</a></li>
		        <li><a href='#' class='filterspace' id='filter-festival'>Festivals & Biennials</a></li>
		        <li><a href='#' class='filterspace' id='filter-informal'>Informal Spaces</a></li>
		        <li><a href='#' class='filterspace' id='filter-museum'>Museums</a></li>
		        <li><a href='#' class='filterspace' id='filter-virtual'>Virtual Spaces</a></li>
		        <li><a href='#' class='filterspace' id='filter-publication'>Publications</a></li>
		        <li><a href='#' class='filterspace active' id='filter-all'>All Spaces</a></li>
		    </ul>
		    <h3 id="regions" class="select" style="border-bottom-width: 1px;">Regions<span id="regions-plus" class="actioncall">+</span></h3>
		    <ul>
		        <li><a href='#' class='filterregion' id='filter-english'>English</a></li>
		        <li><a href='#' class='filterregion' id='filter-french'>French</a></li>
		        <li><a href='#' class='filterregion' id='filter-spanish'>Spanish</a></li>
		        <li><a href='#' class='filterregion' id='filter-dutch'>Dutch</a></li>
		        <li><a href='#' class='filterregion' id='filter-carribean'>Caribbean Diaspora</a></li>
		        <li><a href='#' class='filterregion active' id='filter-allregion'>All Regions</a></li>
		    </ul>
		    
		</div><!--- end of map UI --->
		
	</div>
	<!-- <div id='logo' style="display: none;"><img src="img/FreshMilk_logo.png"/></div> -->
	<div id='legend-content' style='display: none;'>
	  <div class='my-legend'>
	  	<a href="http://www.freshmilkbarbados.com/" target="_blank"><div class='legend-scale'>
	  	</div></a>
	  </div>
	</div>
	<script type='text/javascript'>
	
		var map = L.mapbox.map('map', 'notsirk.map-j5w38xos', {
			detectRetina: true,
			retinaVersion: 'notsirk.map-j5w38xos',
			attributionControl: false
		})
	    .setView([18.229351,-67.701416], 5)
	    .addControl(L.mapbox.geocoderControl('notsirk.map-j5w38xos'));
	    
	    map.legendControl.addLegend(document.getElementById('legend-content').innerHTML);
	    
	    map.on('enterFullscreen', function(){
			if(window.console) window.console.log('enterFullscreen');
		});
		map.on('exitFullscreen', function(){
			if(window.console) window.console.log('exitFullscreen');
		});
		
		var markers;
	
		map.markerLayer.on('ready', function() {
			//console.log(map.markerLayer.getGeoJSON());
			var fullScreen = new L.Control.FullScreen(); 
			map.addControl(fullScreen);
			map.addControl(new defaultZoom());
			
			map.removeLayer(map.markerLayer);
			markers = showPlaces(getPlaces());
			map.addLayer(markers);
			
		});
		
		
		var defaultZoom = L.Control.extend({
		    options: {
		        position: 'topleft'
		    },
		
		    onAdd: function (map) {
		        // create the control container with a particular class name
		        var container = L.DomUtil.create('div', 'pan');
		        var innerContainer = L.DomUtil.create('div', 'wrapper', container);
		        var aButton = L.DomUtil.create('a', 'panner', innerContainer);
		        container.className += ' nodisplay';
		        // ... initialize other DOM elements, add listeners, etc.
		        
		        L.DomEvent
		        .addListener(aButton, 'click', L.DomEvent.stop)
		        .addListener(map, 'zoomend', function(){
			        if(map.getZoom() === 5){
						L.DomUtil.addClass(container, 'nodisplay');		
					}
					else {
						//$('#default').html('1:1').css('background', '#FFFFFF');
						L.DomUtil.removeClass(container, 'nodisplay');
						aButton.innerHTML = '1:1';
					}
		        })
		        .addListener(aButton, 'click', function(){
			        map.setView([18.229351,-67.701416], 5);
		        });
		
		        return container;
		    }
		});		
		
    
	    var art = document.getElementById('filter-art');
	    var museum = document.getElementById('filter-museum');
	    var edu = document.getElementById('filter-edu');
	    var informal = document.getElementById('filter-informal');
	    var cultural = document.getElementById('filter-cultural');
	    var virtual = document.getElementById('filter-virtual');
		var festival = document.getElementById('filter-festival');
		var publication = document.getElementById('filter-publication');
	    var all = document.getElementById('filter-all');
	    
	    
	    var english = document.getElementById('filter-english');
	    var french = document.getElementById('filter-french');
	    var spanish = document.getElementById('filter-spanish');
	    var dutch = document.getElementById('filter-dutch');
	    var carribean = document.getElementById('filter-carribean');
	    var allregion = document.getElementById('filter-allregion');
	    
	    var defaultzoom1 = document.getElementById('default');
	    
	    
	    
	    
	
	    art.onclick = function(e) {
			$('.filterspace').removeClass('active');
			$(this).addClass('active'); 
	        	map.removeLayer(markers);;
	        	markers = showPlaces(getPlaces('art-gallery'));
	        	map.addLayer(markers); 
	        return false;
	    };
	    
	    museum.onclick = function(e) {
	        $('.filterspace').removeClass('active');
			$(this).addClass('active');
		        map.removeLayer(markers);
				markers = showPlaces(getPlaces('museum'));
				map.addLayer(markers);
	        return false;
	    };
	    
	    edu.onclick = function(e) {
	        $('.filterspace').removeClass('active');
			$(this).addClass('active');
		        map.removeLayer(markers);
				markers = showPlaces(getPlaces('college'));
				map.addLayer(markers);
	        return false;
	    };
	    
	    informal.onclick = function(e) {
	        $('.filterspace').removeClass('active');
			$(this).addClass('active');
		        map.removeLayer(markers);
				markers = showPlaces(getPlaces('star'));
				map.addLayer(markers);
	        return false;
	    };
	    
	    cultural.onclick = function(e) {
	        $('.filterspace').removeClass('active');
			$(this).addClass('active');
		        map.removeLayer(markers);
				markers = showPlaces(getPlaces('town-hall'));
				map.addLayer(markers);
	        return false;
	    };
	    
	    virtual.onclick = function(e) {
	        $('.filterspace').removeClass('active');
			$(this).addClass('active');
		        map.removeLayer(markers);
				markers = showPlaces(getPlaces('circle'));
				map.addLayer(markers);
	        return false;
	    };
	    
	    publication.onclick = function(e) {
	        $('.filterspace').removeClass('active');
			$(this).addClass('active');
		        map.removeLayer(markers);
				markers = showPlaces(getPlaces('library'));
				map.addLayer(markers);
	        return false;
	    };
	    
	    festival.onclick = function(e) {
	        $('.filterspace').removeClass('active');
			$(this).addClass('active');
		        map.removeLayer(markers);
				markers = showPlaces(getPlaces('embassy'));
				map.addLayer(markers);
	        return false;
	    };
	
	    all.onclick = function() {
	        $('.filterspace').removeClass('active');
			$(this).addClass('active');
		        map.removeLayer(markers);
				markers = showPlaces(getPlaces());
				map.addLayer(markers);
	        return false;
	    };
	    
	    english.onclick = function(e) {
	        $('.filterregion').removeClass('active');
			$(this).addClass('active');
		        map.removeLayer(markers);
				markers = showPlaces(getPlaces('', '#ffc84e'));
				map.addLayer(markers);
	        return false;
	    };
	    french.onclick = function(e) {
	        $('.filterregion').removeClass('active');
			$(this).addClass('active');
		        map.removeLayer(markers);
				markers = showPlaces(getPlaces('', '#5b8dd3'));
				map.addLayer(markers);
	        return false;
	    };
	    spanish.onclick = function(e) {
	        $('.filterregion').removeClass('active');
			$(this).addClass('active');
		        map.removeLayer(markers);
				markers = showPlaces(getPlaces('', '#f63a39'));
				map.addLayer(markers);
	        return false;
	    };
	    dutch.onclick = function(e) {
	        $('.filterregion').removeClass('active');
			$(this).addClass('active');
		        map.removeLayer(markers);
				markers = showPlaces(getPlaces('', '#ff793d'));
				map.addLayer(markers);
	        return false;
	    };
	    carribean.onclick = function(e) {
	        $('.filterregion').removeClass('active');
			$(this).addClass('active');
		        map.removeLayer(markers);
				markers = showPlaces(getPlaces('', '#71bc4e'));
				map.addLayer(markers);
	        return false;
	    };
	    allregion.onclick = function(e) {
	        $('.filterregion').removeClass('active');
			$(this).addClass('active');
		        map.removeLayer(markers);
				markers = showPlaces(getPlaces());
				map.addLayer(markers);
	        return false;
	    };
	    
	    $('.select').click(function(){
	    	var active = $( ".selector" ).accordion( "option", "active");
	    });
	    
	    
	    function getPlaces(type, region){
		    var type = type || 'all';
		    if(type == ''){
			    type = 'all';
		    }
		    var region = region || 'all';
		    
		    var key, count = 0;
		    var places = new Array();
			
			for(key in map.markerLayer.getGeoJSON().features) {
			  if(map.markerLayer.getGeoJSON().features.hasOwnProperty(key)) {
			  		
			  	if(type != 'all' && map.markerLayer.getGeoJSON().features[key].properties['marker-symbol'] == type){
			  		
			  		if(region != 'all' && map.markerLayer.getGeoJSON().features[key].properties['marker-color'] == region){
				  		places.push(map.markerLayer.getGeoJSON().features[key]);
			  		}
			  		else if(region == 'all') {
				  		places.push(map.markerLayer.getGeoJSON().features[key]);
			  		}
			  		
			  		//console.log(map.markerLayer.getGeoJSON().features[key].properties.title);
			  	}
			  	else if(type == 'all'){
				  	if(region != 'all' && map.markerLayer.getGeoJSON().features[key].properties['marker-color'] == region){
				  		places.push(map.markerLayer.getGeoJSON().features[key]);
			  		}
			  		else if(region == 'all') {
				  		places.push(map.markerLayer.getGeoJSON().features[key]);
			  		}
			  	}
			  	
			  	key++;
			  	count++;
			  }
			}
			
			return places;
	    }
	    
	    function showPlaces(places) {
	    	var places = places || getPlaces();
			var markers = new L.MarkerClusterGroup();
			
			
			for (var i = 0; i < places.length; i++) {
				
				var myIcon = L.mapbox.marker.icon({
					'marker-symbol': places[i].properties['marker-symbol'],
					'marker-size' : 'small',
					'marker-color' : places[i].properties['marker-color']
				});
				
				var marker = new L.Marker(new L.LatLng(places[i].geometry.coordinates[1], places[i].geometry.coordinates[0]), {
					icon: myIcon
					});
				
				var popupContent;
				
				(function(i, marker){ 
					$.post('index.php/backend/get_space/', {
		        			selected : places[i].properties.title
		        		}).done(function(data){
			        		if(data == "none"){
				        		popupContent = '<h3>'+places[i].properties.title+'</h2><p>'+places[i].properties.description+'</p>';
			        		}
			        		else {
				        		data = JSON.parse(data);
				        		
				        		popupContent = 	'<div id="' + places[i].properties.id + '" class="popup">' +
	                            		'<h2>' + places[i].properties.title + '</h2>' +
	                            		'<div class="slideshow">';
				        		
				        		for(var j=0; j<6; j++){
									var k = j+1;
									
									if(data.images[j] != "" && data.images[j] != null){
										if(j == 0){
											popupContent += '<div class="image active">';
										}
										else {
											popupContent += '<div class="image">';
										}
										popupContent += '<img src="'+data.images[j]+'" /><div class="caption">'+data.comments[j];
										
										if(data.links[j] != "" && data.links[j] != null){
											popupContent += '<div><a href="'+data.links[j]+'" target="_blank">'+data.links[j]+'</a></div></div>';
										}
										else {
											popupContent += '</div>';
										}
										
										popupContent += '</div>';//ending div class image
									}// if there is an image
									
								}//end for loop
				        		
				        		 popupContent += '</div>' +
			                            '<div class="cycle">' +
			                                '<a href="#" class="prev" onclick="return moveSlide(\'prev\')">&laquo; Previous</a>' +
			                                '<a href="#" class="next" onclick="return moveSlide(\'next\')">Next &raquo;</a>' +
			                            '</div>'
			                            '</div>';
			        		}//end of if...else
			        		
			        		marker.bindPopup(popupContent,{
							        closeButton: false,
							        minWidth: 320,
							        //offset: [-6, 0]
							    });
			        		
			        	});//end of done for post
				})(i, marker);
				
				markers.addLayer(marker);
				
				
			}//end for loop
			
			return markers;
	    }
	    
	    // This example uses jQuery to make selecting items in the slideshow easier.
		// Download it from http://jquery.com
		function moveSlide(direction) {
		    var $slideshow = $('.slideshow'),
		        totalSlides = $slideshow.children().length;
		
		    if (direction === 'prev') {
		        var $newSlide = $slideshow.find('.active').prev();
		        if ($newSlide.index() < 0) {
		            $newSlide = $('.image').last();
		        }
		    } else {
		        var $newSlide = $slideshow.find('.active').next();
		        if ($newSlide.index() < 0) {
		            $newSlide = $('.image').first();
		        }
		    }
		
		    $slideshow.find('.active').removeClass('active').hide();
		    $newSlide.addClass('active').show();
		    return false;
		}
		
		 $(function() {
			$("#map-ui").accordion({
				collapsible: true,
				active: false,
				icons: { "header": "ui-icon-plusthick", "activeHeader": "ui-icon-minusthick" }
			});	
		});
		
		$( "#map-ui" ).accordion({
			activate: function( event, ui ) {
				
				var active = $( "#map-ui" ).accordion( "option", "active");
				if(active === false){
					$('.actioncall').html('+');
				}
				else if(active === 0){
					$('.actioncall').html('+');
					$('#spaces-plus').html('&mdash;');
				}
				else if (active === 1){
					$('.actioncall').html('+');
					$('#regions-plus').html('&mdash;');
				}
			}
		});
		$(document).ready(function(){
			$('.leaflet-control-mapbox-geocoder-form input:first-child').attr( "placeholder", "Search Island");
		});
		
  </script>
</body>
</html>