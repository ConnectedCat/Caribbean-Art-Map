$(document).ready(function(){
  var map;
  var markers;
  //instantiate map
  map = L.mapbox.map(
    'map',
    'notsirk.map-j5w38xos',
    {detectRetina: true,
      retinaVersion: 'notsirk.map-j5w38xos',
      attributionControl: false}
  ).setView(
    [18.229351,-67.701416],
    5
  ).addControl(
    L.mapbox.geocoderControl('notsirk.map-j5w38xos')
  );
  //add markers
  map.markerLayer.on('ready', function() {
    var fullScreen = new L.Control.FullScreen();
    map.addControl(fullScreen);
    map.addControl(new defaultZoom());

    map.removeLayer(map.markerLayer);
    markers = showPlaces(getPlaces());
    map.addLayer(markers);
  });

  // Map helpers
  var defaultZoom = L.Control.extend({
    options: {position: 'topleft'},
    onAdd: function (map) {
      // create the control container with a particular class name
      var container = L.DomUtil.create('div', 'pan');
      var innerContainer = L.DomUtil.create('div', 'wrapper', container);
      var aButton = L.DomUtil.create('a', 'panner', innerContainer);
      container.className += ' nodisplay';
      // ... initialize other DOM elements, add listeners, etc.
      L.DomEvent.addListener(
        aButton,
        'click',
        L.DomEvent.stop
      ).addListener(
        map,
        'zoomend',
        function(){
          if(map.getZoom() === 5){
            L.DomUtil.addClass(container, 'nodisplay');
          }
          else {
            L.DomUtil.removeClass(container, 'nodisplay');
            aButton.innerHTML = '1:1';
          }
        }
      ).addListener(
        aButton,
        'click',
        function(){
          map.setView([18.229351,-67.701416], 5);
        }
      );
      return container;
    }
  });

  var filterSpace = function(){
    $('.filterspace').removeClass('active');
    $(this).addClass('active');
    map.removeLayer(markers);
    var type = $(this).attr('id');
    if(type == "all"){
      markers = showPlaces(getPlaces());
    }
    else {
      markers = showPlaces(getPlaces(type));
    }
    markers = showPlaces(getPlaces('art-gallery'));
    map.addLayer(markers);
    return false;
  }

  var filterRegion = function(){
    $('.filterregion').removeClass('active');
    $(this).addClass('active');
    map.removeLayer(markers);
    var color = $(this).data('color');
    if(color != ''){
      markers = showPlaces(getPlaces('', color));
    }
    else {
      markers = showPlaces(getPlaces());
    }
    map.addLayer(markers);
    return false;
  }

  function getPlaces(type, region){
    var type = type || 'all';
    if(type == ''){
      type = 'all';
    }
    var region = region || 'all';
    var key = 0;
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
      var marker = new L.Marker(
        new L.LatLng(places[i].geometry.coordinates[1],
        places[i].geometry.coordinates[0]),
        {icon: myIcon}
      );
      var popupContent;
      (function(i, marker){
        $.post(
          'index.php/backend/get_space/',
          {selected : places[i].properties.title}
        ).done(function(data){
          if(data == "none"){
            popupContent = '<h3>'+places[i].properties.title+'</h2><p>'+places[i].properties.description+'</p>';
          }
          else {
            data = JSON.parse(data);
            popupContent = '<div id="' + places[i].properties.id + '" class="popup">' + '<h2>' + places[i].properties.title + '</h2>' + '<div class="slideshow">';
            for(var j=0; j<6; j++){
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
            popupContent += '</div>' + '<div class="cycle">' + '<a href="#" class="slide-arrow prev">&laquo; Previous</a>' + '<a href="#" class="slide-arrow next">Next &raquo;</a>' + '</div></div>';
          }//end of if...else
          marker.bindPopup(popupContent,{
            closeButton: false,
            minWidth: 320
          });
        });//end of done for post
      })(i, marker);
      markers.addLayer(marker);
    }//end for loop
    return markers;
  }
  // UI helpers:
  var moveSlide = function(e){
    e.preventDefault();
    var slideshow = $('.slideshow');
    var totalSlides = slideshow.children().length;
    if ($(this).hasClass('prev')) {
      var newSlide = slideshow.find('.active').prev();
      if (newSlide.index() < 0) {
        newSlide = $('.image').last();
      }
    }
    if ($(this).hasClass('next')) {
      var newSlide = slideshow.find('.active').next();
      if (newSlide.index() < 0) {
        newSlide = $('.image').first();
      }
    }
    slideshow.find('.active').removeClass('active').hide();
    newSlide.addClass('active').show();
    return false;
  }

  $('.leaflet-control-mapbox-geocoder-form input:first-child').attr( "placeholder", "Search Island");

  $( "#map-ui" ).accordion({
    collapsible: true,
    active: false,
    icons: {
      "header": "ui-icon-plusthick",
      "activeHeader": "ui-icon-minusthick"
    },
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

  $('.select').click(function(){
    var active = $( ".selector" ).accordion( "option", "active");
  });
  $('body').on('click', '.slide-arrow', moveSlide);
  $('.filterspace').click(filterSpace);
  $('.filterregion').click(filterRegion);
});
