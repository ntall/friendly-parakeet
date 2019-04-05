<?php 
session_start();
require 'header.php';

//initialize favorite if not set or is unset
if(!isset($_SESSION['favs'])){
	$_SESSION['favs'] = array();
}
require_once('services/config.inc.php'); 
require_once('services/functions.inc.php'); 
require_once('services/helpers.inc.php'); 

if (isset($_GET["id"]))
 $id = $_GET["id"];
else
 $id = 'AAP'; // set a default id if its missing

$info = getSingleInfo($id); 

//http://1bestcsharp.blogspot.com/2015/10/php-mysql-update-using-form-code-pdo.html
if(isset($_POST['update']))
{
    try {
        $pdoConnect = setConnectionInfo(DBCONNSTRING,DBUSER,DBPASS);
    } catch (PDOException $exc) {
        echo $exc->getMessage();
        exit();
    }
    
    // get values form input text and number
    $symbol = $_GET["id"];
    $name = $_POST['name'];
    $sector = $_POST['sector'];
    $subindustry = $_POST['subindustry'];
    $address = $_POST['address'];
    $exchange = $_POST['exchange'];
    $website = $_POST['website'];
    
    // mysql query to Update data
    $query = "UPDATE `companies` SET `name`=:name,`sector`=:sector,`subindustry`=:subindustry,`address`=:address,`exchange`=:exchange,`website`=:website WHERE `symbol` = :symbol";
    $pdoResult = $pdoConnect->prepare($query);
    $pdoExec = $pdoResult->execute(array(":name"=>$name,":sector"=>$sector,":subindustry"=>$subindustry,":address"=>$address,":exchange"=>$exchange,":website"=>$website,":symbol"=>$symbol));
    if($pdoExec){
        echo 'Data Updated';
        $info['name']=$name;
        $info['sector']=$sector;
        $info['subindustry']=$subindustry;
        $info['address']=$address;
        $info['exchange']=$exchange;
        $info['website']=$website;
    }
    else{
        echo 'ERROR Data Not Updated';
    }
}
$i = $_GET['id'];
?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <link rel="stylesheet" type="text/css" href="asg2.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>
    <body>
        <main class="container">
            <div class='col-2 col-s-2 imga' id='ig'></div>
            <div class='col-3 col-s-3 symName'>
                <div id="symbol"><span class='chage'><?php echo $info['symbol']; ?></span></div>
                <div id="nam"><?php echo $info['name']; ?></div>
            </div>
            
            <div class='col-6 col-s-6 view'>
                <div class='con'>Sector: 
                    <label id="sector"><?php echo $info['sector']; ?></label>
                </div>
                <div class='con'>Subindustry: 
                    <label id="subindustry"><?php echo $info['subindustry']; ?></label>
                </div>
                <div class='con'>Address: 
                    <label id="address"><?php echo $info['address']; ?></label>
                </div>
                <div class='con'>Exchange: 
                    <label id="exchange"><?php echo $info['exchange']; ?></label>
                </div>
                <div class='con'>Website: 
                    <label id="website"><?php echo "<a href='".$info['website']."'>".$info['website']."</a>"; ?></label>
                </div>
            </div>
            
            <div class='col-6 col-s-6 form'>
                <form action="<?php echo 'single-company.php?id=' . $id;?>" method='post'>
                 <div class='con'>Name: 
                    <label id="name"><input type="text" name="name" id='nm'></label>
                </div>  
                <div class='con'>Sector: 
                    <label id="sector"><input type="text" name="sector" id='sct'></label>
                </div>
                <div class='con'>Subindustry: 
                    <label id="subindustry"><input type="text" name="subindustry" id='sub'></label>
                </div>
                <div class='con'>Address: 
                    <label id="address"><input type="text" name="address" id='addr'></label>
                </div>
                <div class='con'>Exchange: 
                    <label id="exchange"><input type="text" name="exchange" id='exch'></label>
                </div>
                <div class='con'>Website: 
                    <label id="website"><input type="text" name="website" id='webs'></label>
                </div>
                <div>
                    <input type="submit" name="update" required placeholder="Update Data" id='save' value='Change'>
                </div>
            </div>
            
            
            <div class='col-9 col-s-9 ct'>
                <div id='edit' class='col-1 col-s-1 tg edit lnk'>Edit</div>
                <div class='col-1 col-s-1 tg ad fm'>
                    <?php 
                    if(isset($_SESSION["user_id"])){?>
                        <a href="addToFav.php?id=<?php echo $id ?>">My favorites</a>
                    <?php }else{?>
                        <a href="login.php">Log in</a>
                    <?php }
                    ?>
                </div>
                <div class='col-2 col-s-2 tg mnt fm'><a id="month">Month</a></div>
                <div class='col-1 col-s-1 hide cancel lnk'>Cancel</div>
            </div>
            
        </main>
        <script>
            var i = "<?php echo $i; ?>";
            const url = 'https://comp-3512-assignment-2-curtisloucks.c9users.io/w2019-assign2-master/services/companies.php';
            fetch(url)
            .then(function (response) {
                if (response.ok){
                    return response.json();
                }
            })
            .then((data)=>{
                data.forEach(function(d){
                    if(d.symbol == i){
                        var ig = document.querySelector('#ig');
                        let img = document.createElement('img');
                        img.setAttribute('src',`logos/${d.symbol}.svg`);
                        img.setAttribute('title',d.symbol);
                        img.style.width = '50px';
                        img.style.height = '50px';
                        ig.appendChild(img);
                        
                        var month = document.querySelector("#month");
                        month.setAttribute('href', `month.php?id=${d.symbol}`);
    
                        document.querySelector('#edit').addEventListener('click', function(e){
                            document.querySelector('#nm').setAttribute('value', d.name);
                            document.querySelector('#sct').setAttribute('value', d.sector);
                            document.querySelector('#sub').setAttribute('value', d.subindustry);
                            document.querySelector('#addr').setAttribute('value', d.address);
                            document.querySelector('#exch').setAttribute('value', d.exchange);
                            document.querySelector('#webs').setAttribute('value', d.website);
        
                            document.querySelector('.edit').style.display = 'none';
                            document.querySelector('.ad').style.display = 'none';
                            document.querySelector('.mnt').style.display = 'none';
                            document.querySelector('#nam').style.display = 'none';
                            document.querySelector('.cancel').style.display = 'block';
                            document.querySelector('.form').style.display = 'block';
                            document.querySelector('.view').style.display = 'none';
                        });
                        
                        document.querySelector('.cancel').addEventListener('click', function(e){
                            hide();
                        });
                        
                    }
                });
            })
            .catch((error) => console.log(error));
            function hide(){
                document.querySelector('.edit').style.display = 'block';
                document.querySelector('.ad').style.display = 'block';
                document.querySelector('.mnt').style.display = 'block';
                document.querySelector('#nam').style.display = 'block';
                document.querySelector('.cancel').style.display = 'none';
                document.querySelector('.form').style.display = 'none';
                document.querySelector('.view').style.display = 'block';
            }
        </script>
    </body>
 
</html>