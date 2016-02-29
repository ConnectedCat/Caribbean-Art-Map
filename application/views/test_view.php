<html>
<head>
	<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<head>
<body>
	<div id="title">Tito's & Toto's</div>
	<?php //if(isset($test)){ echo $test; }?>
	<script>
		$(document).ready(function(){
			$('#title').click(function(){
				$.post('../test/process/', {
					test : $('#title').html()
				}).done(function(data){
					$('body').append(data);	
				});
			});
		});
	</script>
</body>
</html>