<?php 
session_start();
require 'header.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <link rel="stylesheet" type="text/css" href="asg2.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>
    <body>
<?php
    require_once('services/config.inc.php'); 
?>
<?php 
                 $i = $_GET['id'];
?>
<main class="container">
    <h1>Monthly Data</h1>
    <div class='table'>
    <table id="tableContainer">
            <tr>
                <th id="dateCol" class="th">Date</th>
                <th id="openCol" class="th">Open</th>
                <th id="closeCol" class="th">High</th>
                <th id="highCol" class="th">Low</th>
                <th id="lowCol" class="th">Close</th>
                <th id="volumeCol" class="th">Volume</th>
            </tr>
            <tbody id="tableBody"></tbody>
    </table>
    </div>
</main>
<script>
const monData = document.querySelector('#tableBody');
var i = "<?php echo $i; ?>";//populate the company month stock info section
    const url = "https://api.iextrading.com/1.0/stock/" +i+ "/chart/1m";
    console.log(url);
        fetch(url).then(response => response.json())
        .then(function (data){
                // add monthly stock data to the table 
                for (let filed of data){
                    const row = document.createElement('tr');
                    for(let d in filed){
                        const text = document.createTextNode(filed[d]);
                        const col = document.createElement('td');
                        // add info to the table
                        if(d == 'date' || d == 'open' || d == 'high' || d == 'low' || d == 'close' || d == 'volume'){
                            col.appendChild(text);
                            row.appendChild(col),
                            monData.appendChild(row);
                        }
                    }
                }
            
        })
        .catch(error => console.error(error));
        
        function changeTable(){
        let ths = document.querySelectorAll('th');
        for(let i=0;i<ths.length;i++){
        ths[i].addEventListener('click',function(){
            sortTable(i);
        });
        }
    }
    changeTable();
    
    // This function is used for sorting the table.
    //It was retrieved from "https://www.w3schools.com/howto/howto_js_sort_table.asp".
    function sortTable(n) {
      let table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
      table = document.querySelector("#tableContainer");
      switching = true;
      //Set the sorting direction to ascending:
      dir = "asc"; 
      /*Make a loop that will continue until
      no switching has been done:*/
      while (switching) {
        //start by saying: no switching is done:
        switching = false;
        rows = table.rows;
        /*Loop through all table rows (except the
        first, which contains table headers):*/
        for (i = 1; i < (rows.length - 1); i++) {
          //start by saying there should be no switching:
          shouldSwitch = false;
          /*Get the two elements you want to compare,
          one from current row and one from the next:*/
          x = rows[i].getElementsByTagName("TD")[n];
          y = rows[i + 1].getElementsByTagName("TD")[n];
          /*check if the two rows should switch place,
          based on the direction, asc or desc:*/
          if (dir == "asc") {
            if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
              //if so, mark as a switch and break the loop:
              shouldSwitch= true;
              break;
            }
          } else if (dir == "desc") {
            if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
              //if so, mark as a switch and break the loop:
              shouldSwitch = true;
              break;
            }
          }
        }
        if (shouldSwitch) {
          /*If a switch has been marked, make the switch
          and mark that a switch has been done:*/
          rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
          switching = true;
          //Each time a switch is done, increase this count by 1:
          switchcount ++;      
        } else {
          /*If no switching has been done AND the direction is "asc",
          set the direction to "desc" and run the while loop again.*/
          if (switchcount == 0 && dir == "asc") {
            dir = "desc";
            switching = true;
          }
        }
      }
    }
</script>
</body>

</html>