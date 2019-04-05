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
	<title>Portfolio</title>
	<link rel="stylesheet" type="text/css" href="asg2.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
	<h1>Portfolio</h1>
	<div class="row">
		<div>
			<?php 
			if(isset($_SESSION['user_id'])){
			    $user=$_SESSION['user_id'];
				?>
				<!--
				    Make a table
				-->
			<table id='tab'>
				<thead>
					<th>Logo</th>
					<th>Symbol</th>
					<th>Name</th>
					<th>#Shares</th>
					<th>$Close</th>
					<th>$Value</th>
				</thead>
				<tbody>
					<?php //Retreive data from joined tables and insert the data to the table
						$sql = "SELECT * FROM portfolio JOIN companies WHERE portfolio.symbol = companies.symbol AND portfolio.userId = $user";
						$result = $pdo->query($sql);
							while($row = $result->fetch()){
								?>
								<tr>
									<td><img src = "logos/<?php echo $row['symbol']; ?>.svg" class='tableImg'></td>
									<td><a href="single-company.php?id=<?php echo $row['symbol']; ?>"><font color="white" class='symbol'><?php echo $row['symbol']; ?></font></a></td>
									<td><a href="single-company.php?id=<?php echo $row['symbol']; ?>"><font color="white"><?php echo $row['name']; ?></font></a></td>
                                    <td><font color="white" class='share'><?php echo $row['amount']; ?></font></td>
                                    <td><font color="white" class='price'></font></td>
                                    <td><font color="white" class='value'></font></td>
								</tr>
								<?php
							}
						$pdo=null; //set pdo to null
						?>
						<tr>
						<td colspan="4" align="right"><b class='total'>Total Portfolio Value:</b></td>
            					</tr>
            	</tbody>
            </table>
			<p class='message'></p>
			<?php
            }
			else{ //display error message if user is not logged in
				?>
				<tr>
					<td colspan="4" class="text-center">Please log in to your account! </td>
				</tr>
				</tbody>
			</table>
			<a href="login.php" class="login"> Log in</a>
				<?php
			}
		?>
		</div>
	</div>
</div>
    <script>
    /*
        Script for calculate all the required stock values
    */
    let symbol = document.querySelectorAll('.symbol');
    let close = document.querySelectorAll('.price');
    let share = document.querySelectorAll('.share');
    let value = document.querySelectorAll('.value');
    let arr = [];
    for(let sym of symbol){
        arr.push(sym.textContent);
    }
    let symbols = arr.join(); //split the array then fetch
    fetch(`https://api.iextrading.com/1.0/stock/market/batch?symbols=${symbols}&types=price`)
    .then(response => response.json())
    .then(function (data){
        let total = 0;
       for(let i=0;i<close.length;i++){
            let price = document.createTextNode((data[arr[i]]['price']).toFixed(2));
            let sha = share[i].textContent;
           close[i].appendChild(price);
           let amt = close[i].textContent;
           let val = document.createTextNode((amt*sha).toFixed(2));
           value[i].appendChild(val);
           let pointNum = parseFloat(value[i].textContent);
           total=total+pointNum;
       }
       let totVal = document.querySelector('.total');
       let totText = document.createTextNode("$"+total.toFixed(2));
       totVal.appendChild(totText);
       if(totVal.textContent=="Total Portfolio Value:$0.00"){
           //display message for new user
            let msg = document.createTextNode("Sorry! We do not have any record of your portfolio since you are a brand new user.");
           document.querySelector('.message').appendChild(msg);
       }
    })
    .catch(error => console.error(error));
    </script>
</body>

</html>