<?php
	include('includes/db.php');
	
	if(isset($_GET['id'])) {
		$id = $_GET['id'];
		
		$qry = "select * from clients where id=".$id;
		$run = mysqli_query($conn, $qry);
		$row = mysqli_fetch_array($run);
		
		$name = $row['name'];
		
		$qry = "select * from tickets where clientid=$id";
		$run = mysqli_query($conn, $qry);
		$ticket = [];
		$i = 0;
		while ($row = mysqli_fetch_array($run)) {
			$ticket[$i] = $row['token'];
			$i++;
		} 
	}
	else {
		echo "<script type='text/javascript'>window.open('index.php', '_self')</script>";
	}
?>
<!DOCTYPE html>
<html>
<head>
<meta name="title" content="Ivan Cilento aka Zanoth">
<meta name="description" content="">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="author" content="Unknown" >
<meta name="keywords" content=""/>	
	
	<link rel="stylesheet" href="bootstrap/css/bootstrap.css"/>
	<script type="text/javascript" src="js/funcs.js"></script>
	 
<style>
body {
	text-align: center;
}
 .inner {padding-top:30px;color:#ffffff}
 .inner [type='submit'] {
 	background-color: #9f2121;
 	border-radius:5px;
 	color: #e9e9e9;
 	font-size: 18px;

 	padding:10px;
 	transition: 2s background-color, color;
 }
  .inner [type='submit']:hover {
  		background-color: #e9e9e9;
  		color: #9f2121;
 }
 .inner button {
 	background-color: #9f2121;
 	border-radius:15px;
 	color: #e9e9e9;
 	font-size: 18px;

 	padding:10px;
 	transition: 2s background-color, color;
 }
  .inner button:hover {
  		background-color: #e9e9e9;
  		color: #9f2121;
 } 

	.mn {
		font-size: 42px;
		font-family: serif;
		color:#cf5555;
		display:inline-block;
	}
	
	.jumbotron {
		background-color: #efaaaa	
	}
	
	p.mask {	
		 background: url(img/mask.png) 0 0 / cover repeat;
	    color: #de466c;
	   -webkit-background-clip: text;
	   -webkit-text-fill-color: transparent;	    
   }
   .tokbg {
		background-image:url('img/maskbg2.png');
		background-repeat:repeat;
		color:white;
		width:320px;
		margin: auto;
		text-align:center; 
   }
   .tokbg img {
		  mix-tokbg-mode: lighten;
   }	
</style>
</head>

	<body>
	<!--div class="bx"-->
		<div class="container" style="padding-top:10px;padding-bottom:10px;">		
			Tire um print do seu comprovante:			
			<div class="inner tokbg" style="padding-bottom:10px;text-align:center;margin-bottom:10px;border-radius:30px;">
				<?php
					echo "<table class='' style='color:#000;font-weight:900;width:100%;position:relative;text-align:center;'>
								<tr>
									<td style='font-size:12px;'>Nome: ".$name."</td>
									<td style='font-size:12px;'>Data :".date('d/m/y')."</td>
								</tr>
								<tr>
									<td colspan='2' style='padding:10px;font-size:12px;'>Sorteio: 000000001</td>
								<tr>";
					for ($i=0;$i<count($ticket);$i++) {
		 				echo "<tr>
		 							<td colspan='2' style='text-align:center;font-size:32px;text-shadow:1px 1px 2px dark;'><p class='mask'>".$ticket[$i]."</p></td>
		 						</tr>";
					}
					echo "</table>";
				?>
			</div>
		
		<div class="container" style="text-align:center;">
			<small>Dúvidas entrar em contato pelo e-mail contato@rifart.com.br </small>
		</div>	
		<div class="container">
			<img style="display:block;margin-left:auto;margin-right:auto;" width="auto" height="60px" src="img/rifa.png">
		</div>
	</div>
</body>
</html>
	