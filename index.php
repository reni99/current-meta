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
    <link rel="stylesheet" href="css/style.css">
    <?php 
	include('constants.php');
	?>	

</head>
<body>		
<!-- Content -->
	
	<div id="wrapper">	
		<header>
			<img src="img/header.png">
		</header>
		<nav>
			<?php
			include('menu.php');
			?>
		</nav>
		<div class="content">
		<?php 		
			if(empty($_GET['page'])){
				$page = 'start.php';
			}else{
				$page = $_GET['page'];
			}	
			
			include $page; 
		?>
		</div>
		<footer>
		<?php		
			include('footer.php');
		?>	
		</footer>
	</div>
	</body>
</html>