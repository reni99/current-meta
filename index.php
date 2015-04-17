<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">
    <title>HeathStone Cards Search API</title>
    <script type="text/javascript" src="js/validation.js"></script>

</head>
<body>	
<div id="wrapper">		

<!-- Navigation -->

	<div id="navigation_wrapper">		
	
	<?php 
	include('constants.php');
	include('menu.php');
	?>		
	</div>
		
<!-- Content -->
	
	<div id="content_wrapper">	
			
	<?php 		
		if(empty($_GET['page'])){
		$page = 'start.php';
		}else{
		$page = $_GET['page'];
		}	
		include $page; 
	?>
	
	</div>
	
<!-- Footer -->

	<div id="footer_wrapper">	
	
	<?php		
		include('footer.php');
	?>		
	</div>

</div>
	</body>
</html>