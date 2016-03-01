<html>
<head>
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
	<link href='//api.tiles.mapbox.com/mapbox.js/v1.3.1/mapbox.css' rel='stylesheet' />
	<!--[if lte IE 8]>
  	<link href='//api.tiles.mapbox.com/mapbox.js/v1.3.1/mapbox.ie.css' rel='stylesheet' />
  <![endif]-->

	<script src='//api.tiles.mapbox.com/mapbox.js/v1.3.1/mapbox.js'></script>

	<!----- FOR MARKER CLUSTERS ------>
  <link rel="stylesheet" href="<?php echo base_url();?>plugins/cluster/dist/MarkerCluster.css" />
	<link rel="stylesheet" href="<?php echo base_url();?>plugins/cluster/dist/MarkerCluster.Default.css" />
	<!--[if lte IE 8]>
  	<link rel="stylesheet" href="http://connectedcatmedia.com/freshmilk3/plugins/cluster/dist/MarkerCluster.Default.ie.css" />
	<![endif]-->
	<script src="<?php echo base_url();?>plugins/cluster/dist/leaflet.markercluster.js"></script>

	<!---- FOR FULLSCREEN CONTROLS ----->
	<link rel="stylesheet" href="<?php echo base_url();?>plugins/fullscreen/Control.FullScreen.css" />
	<script src="<?php echo base_url();?>plugins/fullscreen/Control.FullScreen.js"></script>

	<!---- ADD SOME JQUERY ------------>
	<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
	<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>

	<!-- ADD THE FUNCTIONAL SCRIPT -->
	<script type='text/javascript' src="<?php echo base_url();?>js/homepage.js"></script>

	<!----ADD GOOGLE FONT ------------->
	<link href='http://fonts.googleapis.com/css?family=Muli' rel='stylesheet' type='text/css'>
	<link href="<?php echo base_url();?>style/homepage.css" rel="stylesheet" type="text/css">
</head>
<body>

	<div id='map'>
		<div id='map-ui'>
			<h3 id="spaces" class="select">Art Spaces<span id="spaces-plus" class="actioncall">+</span></h3>
			<ul>
			  <li><a href='#' class='filterspace' id='art-gallery'>Art Galleries</a></li>
			  <li><a href='#' class='filterspace' id='town-hall'>Cultural Institutions</a></li>
			  <li><a href='#' class='filterspace' id='college'>Education</a></li>
			  <li><a href='#' class='filterspace' id='embassy'>Festivals & Biennials</a></li>
			  <li><a href='#' class='filterspace' id='star'>Informal Spaces</a></li>
			  <li><a href='#' class='filterspace' id='museum'>Museums</a></li>
			  <li><a href='#' class='filterspace' id='circle'>Virtual Spaces</a></li>
			  <li><a href='#' class='filterspace' id='library'>Publications</a></li>
			  <li><a href='#' class='filterspace active' id='all'>All Spaces</a></li>
			</ul>
		  <h3 id="regions" class="select" style="border-bottom-width: 1px;">Regions<span id="regions-plus" class="actioncall">+</span></h3>
			<ul>
			  <li><a href='#' class='filterregion' id='english' data-color="#ffc84e">English</a></li>
			  <li><a href='#' class='filterregion' id='french' data-color="#5b8dd3">French</a></li>
			  <li><a href='#' class='filterregion' id='spanish' data-color="#f63a39">Spanish</a></li>
			  <li><a href='#' class='filterregion' id='dutch' data-color="#ff793d">Dutch</a></li>
			  <li><a href='#' class='filterregion' id='carribean' data-color="#71bc4e">Caribbean Diaspora</a></li>
			  <li><a href='#' class='filterregion active' id='allregion' data-color="">All Regions</a></li>
			</ul>
		</div><!--- end of map UI --->
	</div>

	<div class="branding">
		<a href="http://www.freshmilkbarbados.com/" target="_blank"><div class="branding-logo"></div></a>
  </div>
</body>
</html>
