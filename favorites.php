<?php
	session_start();
	require_once('services/config.inc.php');
	require 'header.php';
	try {
		   $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
		   $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
	catch (PDOException $e) {
	   die( $e->getMessage() );
	}
	
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Favorites</title>
	<link rel="stylesheet" type="text/css" href="asg2.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
    	img {max-width: 200px;height: 100px}
    </style>
</head>
<body>
<div class="container">
	<h1>Favorites</h1>
	<div class="row">
		<div>
			<?php 
			if(isset($_SESSION['message'])){
				?>
				<div class="alert alert-info text-center">
					<?php echo $_SESSION['message']; ?>
				</div>
				<?php
				unset($_SESSION['message']);
			}
 
			?>
			<form method="POST" action="save_cart.php">
			<table>
				<thead>
					<th>Logo</th>
					<th>Symbol</th>
					<th>Name</th>
					<th></th>
				</thead>
				<tbody>
					<?php //retreive data from company table if favs is not empty and insert the data to the table
						if(!empty($_SESSION['favs'])){
    				    $symbols = $_SESSION['favs'];
						$sql = "SELECT * FROM companies WHERE symbol = :symbols";
						for($i=0; $i<count($symbols); $i++){
						$stmt = $pdo->prepare($sql);
						$stmt->bindValue(':symbols', $symbols[$i]);
						$stmt->execute();
							while($row = $stmt->fetch()){
								?>
								<tr>
									<td><img src = "logos/<?php echo $row['symbol']; ?>.svg" class='tableImg'></td>
									<td><a href="single-company.php?id=<?php echo $row['symbol']; ?>"><font color="white"><?php echo $row['symbol']; ?></font></a></td>
									<td><a href="single-company.php?id=<?php echo $row['symbol']; ?>"><font color="white"><?php echo $row['name']; ?></font></a></td>
									<td>
										<a href="delete_item.php?id=<?php echo $row['symbol']; ?>"><font color="red">Remove</font></a>
									</td>
								</tr>
								<?php
							}
						}
						$pdo=null;//set pdo to null
						}
						else{//display message for 0 favorite
							?>
							<tr>
								<td colspan="4" class="text-center">No Item in Favorites</td>
							</tr>
							<?php
						}//consulted from https://phppot.com/php/simple-php-shopping-cart/
 
					?>
					<tr>
						<td colspan="4" align="right"><b>Total <?php echo count($_SESSION['favs']); ?> Favorites</b></td>
					</tr>
				</tbody>
			</table>
			<!--
			Remove all favorites from the table
			-->
			<a href="clear_fav.php"> Remove All</a>
			</form>
		</div>
	</div>
</div>
</body>
</html>