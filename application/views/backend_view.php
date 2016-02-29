<?php
$this->load->view('header_view');
?>
<body style="background-color: #f9f9f9;">
	<div id="backend-content">
		<a href="../login/logout/"><div class="logout" id="logout">Log out</div></a>
	
		<header id="backend-header">
			
<!-- 			<div class="small-logo" id="login-logo"><img src="<?php echo base_url();?>img/SmallLogo.png"/></div> -->
			<div class="topbar">CARIBBEAN ART SPACES &nbsp;&nbsp;|&nbsp;&nbsp; <a href="<?php echo base_url();?>" target="_blank">View Map</a></div>
		
		</header>
		<ul id="spaces-list">
            <h4>Directory:</h4>
        </ul>
        <div id="img-mgmt">
        	<h4 id="current-name"></h4>
        	<p class="error"></p>
        	<div id="instructions">
        		<h3>Guide to updating Fresh Milk Map:</h3>

				<h4>Step 1. Update Mapbox markers.</h4>
				
				<p>The map is built on the beautiful Mapbox platform. To update the Art Spaces, you first need to add a marker in Mapbox. You need to have the following information from the art space:</p>
				
				<ol>
					<li>Name</li>
					<li>Description</li>
					<li>Country</li>
					<li>Type of Art Space</li>
					<li>Coordinates (latitude & longitude)</li>
				</ol>
				<h4>Step 2. Select Art Space on the left.</h4>
				
				<p>Once Mapbox has been updated, this Fresh Milk Map admin should show the new space. Please select Art Space to update. Have the following ready to upload:</p>
				<ol>
					<li>1-6 images (landscape). Please use PSD template to scale.</li>
					<li>1-6 captions.</li>
					<li>Website/links</li> 
				</ol>
				<h4>Step 3. Upload images and captions.</h4>
				
				<p>Upload image > Add caption > Add link >Click Save. Repeat for additional images.</p>
				
				<h4>Questions?</h4>
				
				<h4>Email Kriston Chen at <a href="mailto:notsirkdesign@gmail.com">notsirkdesign@gmail.com</a>. Thanks</h4>
        	</div>
        </div>
	</div>
	<div id="map" style="display: none; z-index: -1000"></div>
</body>
<script src="<?php echo base_url()?>js/ajaxfileupload.js"></script>
<script src='//api.tiles.mapbox.com/mapbox.js/v1.3.1/mapbox.js'></script>
<script>
	var map = L.mapbox.map('map', 'notsirk.map-j5w38xos');
	
	map.markerLayer.on('ready', function() {
		
		var key, count = 0;
		var places = new Array();
		 
		for(key in map.markerLayer.getGeoJSON().features) {
			
			if(map.markerLayer.getGeoJSON().features.hasOwnProperty(key)) {
			
		  		$('#spaces-list').append('<li>'+map.markerLayer.getGeoJSON().features[key].properties.title+'</li>');
		  		
		  		places.push(map.markerLayer.getGeoJSON().features[key].properties.title);
		  		
		  		key++;
		  		count++;
		  	}
		}//end for

	
		$('#spaces-list li').click(function() {
	        $(this).siblings('li').removeClass('active');
	        $(this).addClass('active');
	        
	        $('#img-mgmt').html('<h4 id="current-name">'+$(this).html()+'</h4><p class="error"></p>');
	        
	        $.post('../backend/get_space/', {
	        	selected : $(this).html()
	        	}).done(function(data){
		        	
		        	if(data == "none"){
		        		$('.error').html("No images available for this space!");
		        		
		        		$('#img-mgmt').append('<div id="for-upload"></div>');
		        		
		        		for(var i=1; i<7; i++ ){
			        		$('#for-upload').append('<div class="file-wrapper" id="thumb'+i+'"><div class="for-upload-pane"><p class="add">+</p><p>Click here to upload another image</p></div><input type="file" name="file'+i+'" id="file'+i+'" class="upload-file" value="" onchange="InputChange(event, this)"/></div>');
		        		}
		        		for(var i=1; i<7; i++ ){
			        		$('#for-upload').append('<input type="hidden" value="" id="path'+i+'"/><textarea id="caption'+i+'" class="caption-field">Caption '+i+'</textarea><input name="link" class="link" id="link'+i+'" placeholder="http://" />');
		        		}
		        		
		        		$('#caption1').addClass('active-textarea');
		        		$('#link1').addClass('active-link');
		        		$('#for-upload').append('<button name="submit" id="submit">Save</button>');
		        	}
		        	
		        	else {
		        		data = JSON.parse(data);
		        		//console.log(data);
		        		$('#img-mgmt').append('<div id="for-upload"></div>');
		        		
		        		for(var i=0; i<6; i++ ){
		        			var j = i+1;
		        			
		        			if(data.thumbs[i] == null){
			        			data.thumbs[i] = "";
		        			}
		        			
		        			if(data.thumbs[i] != ""){
			        			$('#for-upload').append('<div class="file-wrapper" id="thumb'+j+'" style="overflow: visible;"><img src="'+data.thumbs[i]+'"><button class="remove"><img src="../../img/close.png"></button></div>');
		        			}
		        			else {
			        			$('#for-upload').append('<div class="file-wrapper" id="thumb'+j+'"><div class="for-upload-pane"><p class="add">+</p><p>Click here to upload another image</p></div><input type="file" name="file'+j+'" id="file'+j+'" class="upload-file" value="" onchange="InputChange(event, this)"/></div>');
		        			}	
		        		}
		        		for(var i=0; i<6; i++ ){
		        			var j = i+1;
		        			
			        		$('#for-upload').append('<input type="hidden" value="'+data.images[i]+'" id="path'+j+'"/><textarea id="caption'+j+'" class="caption-field">'+data.comments[i]+'</textarea><input name="link" class="link" id="link'+j+'" placeholder="http://" value="'+data.links[i]+'"/>');
		        		}
		        		
		        		$('#caption1').addClass('active-textarea');
		        		$('#link1').addClass('active-link');
		        		$('#for-upload').append('<button name="submit" id="submit">Save</button>');
		        		$('#for-upload').append('<button name="remove" id="remove">Remove</button>');
			        	
		        	}
	        });//end post get_space
	    });//end of space-list li click	   
	});//end of map.markerLayer on ready

	jQuery.extend({
	    handleError: function( s, xhr, status, e ) {
	        // If a local callback was specified, fire it
	        if ( s.error )
	            s.error( xhr, status, e );
	        // If we have some XML response text (e.g. from an AJAX call) then log it in the console
	        else if(xhr.responseText)
	            console.log(xhr.responseText);
	    }
	});
</script>
<script>
	$(document).ready(function(){
		//remove image
	    $('#img-mgmt').on('click', '.remove', function(e){
	    	
	    	
	    	var id = $(this).parent().attr('id');
			var lastChar = id.substr(id.length - 1);
	    	var thumbServerPath = $('#thumb'+lastChar).children('img').attr('src').slice(4);
	    	
	    	$.post('../backend/image_delete/', {
	    			path : $('#path'+lastChar).val(),
	    			thumb: thumbServerPath
	    		}).done(function(data){
	    		
	    		if(data == 'Done'){
		    		
		    		$('#'+id).html('<div class="for-upload-pane"><p class="add">+</p><p>Click here to upload another image</p></div><input type="file" name="file'+lastChar+'" id="file'+lastChar+'" class="upload-file"/>');
		    		
		    		$('input:file').each(function(){
			    		$(this).val('');
		    		});
		    	}
		    	else {
			    	alert(data);
		    	}
	    	});		    
	    });
	    
	    //select image
	    $('#img-mgmt').on('click', '.file-wrapper', function(){
		    $(this).siblings('.file-wrapper').removeClass('activeThumb');
		    $(this).addClass('activeThumb');
		    
		    var id = $(this).attr('id');
			var lastChar = id.substr(id.length - 1);
			$("#caption"+lastChar).siblings('textarea').removeClass('active-textarea');
		    $("#caption"+lastChar).addClass('active-textarea');
		    $("#link"+lastChar).siblings('.link').removeClass('active-link');
		    $("#link"+lastChar).addClass('active-link');
	    });
	    		
	    
	    //Deleting from the database
	    $('#img-mgmt').on('click', '#remove', function(e){
		    e.preventDefault();
		    
		    var retVal = confirm("Are you sure you want to delete \n all the information and images \n associated with this space?");
		    if(retVal){
		    	$('#img-mgmt').html('<h4 id="current-name">'+$('#spaces-list li.active').html()+'</h4><p class="error"></p>');
		    			    
			    $.post('../backend/space_remove/', {
				    space_name	: $('#spaces-list li.active').html()
			    }).done(function(data){
				    	if(data == "success deleting space"){
					    	$('.error').html("No images available for this space!");
			        		
			        		$('#img-mgmt').append('<div id="for-upload"></div>');
			        		
			        		for(var i=1; i<7; i++ ){
				        		$('#for-upload').append('<div class="file-wrapper" id="thumb'+i+'"><div class="for-upload-pane"><p class="add">+</p><p>Click here to upload another image</p></div><input type="file" name="file'+i+'" id="file'+i+'" class="upload-file" value="" onchange="InputChange(event, this)"/></div>');
			        		}
			        		for(var i=1; i<7; i++ ){
				        		$('#for-upload').append('<input type="hidden" value="" id="path'+i+'"/><textarea id="caption'+i+'" class="caption-field">Caption '+i+'</textarea><input name="link" class="link" id="link'+i+'" placeholder="http://" />');
			        		}
			        		
			        		$('#caption1').addClass('active-textarea');
			        		$('#link1').addClass('active-link');
			        		$('#for-upload').append('<button name="submit" id="submit">Save</button>');
				    	}
						alert(data); 
				    });
			}
		});
		    
	    
	    //Saving to the database
	    $('#img-mgmt').on('click', '#submit', function(e){
		    e.preventDefault();
		    
		    if(typeof $('#spaces-list li.active').html() != "undefined"){
		    	
		    	var thumb_src1, thumb_src2, thumb_src3, thumb_src4, thumb_src5, thumb_src6;
		    	
		    	if(typeof $('#thumb1').children('img').attr('src') == "undefined"){
			    	thumb_src1 = "";
		    	}
		    	else {
			    	thumb_src1 = $('#thumb1').children('img').attr('src');
		    	}
		    	
		    	if(typeof $('#thumb2').children('img').attr('src') == "undefined"){
			    	thumb_src2 = "";
		    	}
		    	else {
			    	thumb_src2 = $('#thumb2').children('img').attr('src');
		    	}
		    	
		    	if(typeof $('#thumb3').children('img').attr('src') == "undefined"){
			    	thumb_src3 = "";
		    	}
		    	else {
			    	thumb_src3 = $('#thumb3').children('img').attr('src');
		    	}
		    	
		    	if(typeof $('#thumb4').children('img').attr('src') == "undefined"){
			    	thumb_src4 = "";
		    	}
		    	else {
			    	thumb_src4 = $('#thumb4').children('img').attr('src');
		    	}
		    	if(typeof $('#thumb5').children('img').attr('src') == "undefined"){
			    	thumb_src5 = "";
		    	}
		    	else {
			    	thumb_src5 = $('#thumb5').children('img').attr('src');
		    	}
		    	
		    	if(typeof $('#thumb6').children('img').attr('src') == "undefined"){
			    	thumb_src6 = "";
		    	}
		    	else {
			    	thumb_src6 = $('#thumb6').children('img').attr('src');
		    	}
		    	
			    $.post('../backend/space_update/', {
			    	space_info : {
				    	space_name	: $('#spaces-list li.active').html(),
				    	
				    	image_path1 : $('#path1').val(),
				    	thumb_path1	: thumb_src1,
				    	comment1 	: $('#caption1').val(),
				    	link1 		: $('#link1').val(),
				    	
				    	image_path2 : $('#path2').val(),
				    	thumb_path2	: thumb_src2,
				    	comment2 	: $('#caption2').val(),
				    	link2 		: $('#link2').val(),
						
						image_path3 : $('#path3').val(),
						thumb_path3	: thumb_src3,
						comment3 	: $('#caption3').val(),
						link3 		: $('#link3').val(),
						
						image_path4 : $('#path4').val(),
				    	thumb_path4	: thumb_src4,
				    	comment4 	: $('#caption4').val(),
				    	link4 		: $('#link4').val(),
				    	
				    	image_path5 : $('#path5').val(),
				    	thumb_path5	: thumb_src5,
				    	comment5 	: $('#caption5').val(),
				    	link5 		: $('#link5').val(),
						
						image_path6 : $('#path6').val(),
						thumb_path6	: thumb_src6,
						comment6 	: $('#caption6').val(),
						link6 		: $('#link6').val()
				    	}
			    }).done(function(data){
			    	if(data == "success updating" || data == "success inserting"){
				    	$('.error').html('');
			    	}
					alert(data); 
			    });
		    }
		    else {
			    alert("Please select a space");
		    }
	    });//end of submit on click
	    
	    
	});//end of document(ready)
	
	function InputChange(e, el){
			e.preventDefault();
			var thisEl = el;
			
			switch($(thisEl).attr('id')){
				case 'file1':
					var current_thumb = 'thumb1';
					var current_path = 'path1';
					break;
				case 'file2':
					var current_thumb = 'thumb2';
					var current_path = 'path2';
					break;
				case 'file3':
					var current_thumb = 'thumb3';
					var current_path = 'path3';
					break;
				case 'file4':
					var current_thumb = 'thumb4';
					var current_path = 'path4';
					break;
				case 'file5':
					var current_thumb = 'thumb5';
					var current_path = 'path5';
					break;
				case 'file6':
					var current_thumb = 'thumb6';
					var current_path = 'path6';
					break; 
			}
			
			$.ajaxFileUpload({
				url         	: '../backend/image_upload/',
				secureuri      	: false,
				fileElementId  	: $(thisEl).attr('id'),
				dataType    	: 'json',
				data        	: {
					'element_name'	: $(thisEl).attr('name')
					},
				success  : function (data, status){
					$('.error').html("");
					
					console.log(data);
					
					if(data.status != 'error'){
						$('#'+current_thumb).html("<img src='"+data.msg+"'/>");
						$('#'+current_path).attr('value', data.path);
						$('#'+current_thumb).css('overflow', 'visible');
						$('#'+current_thumb).append("<button class='remove'><img src='../../img/close.png' /></button>");
					}
					else {
						alert(data.msg);
					}
				},
				error: function (data, status, e)
                {
                    alert("Image corrupt!\nError is "+e);
                }
			});
			
			return false;
		}//end of InputChange
</script>
<?php
$this->load->view('footer_view');
?>