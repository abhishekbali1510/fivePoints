<?php
  require "conn.php";
  session_start();
  if($_SESSION['login']==true)
  {
        $sql = "SELECT * FROM customerDetails WHERE customerMobile='".$_SESSION["currentCustomer"]."'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
  }
  else
  {
    header("location: index.php");
    //redirect to dashboard
  }


?>
 <!DOCTYPE html>
 <html>
 <head>
     <meta charset="utf-8" />
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <title>Five points</title>
     <link rel="stylesheet" href="login.css" media="screen" type="text/css" />
     <meta name="viewport" content="width=device-width, initial-scale=1">
     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
     <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
     <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
 
     <script
   src="http://code.jquery.com/jquery-3.3.1.min.js"
   integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
   crossorigin="anonymous"></script>
   <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
   <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js" ></script>
 </head>
 <body>

 <header>
    <a href="dash.php"><div>Back</div></a>
    <a href="generateBill.php"><span>Generate bill</span></a>
  </header>

    <!-- <br><br><br><br> -->
    <div class= "customerInfo">
      <?php
        echo "<div>money left : ".$row["moneyLeft"]."</div>";
      
        echo "<div>membership amount : ".$row["membershipAmount"]."</div>";
        
        echo "<div>name : ".$row["customerName"]."</div>";
        
        echo "<div>mobile : ".$row["customerMobile"]."</div>";

        echo "<div>Email : ".$row["customerEmail"]."</div>";
        ?>
    </div>
    <br>
 <div class="container">
     <h2>History</h2>
     <table class="table table-fluid" id="myTable" >
     <thead>
     <tr><th>Items</th><th>Price</th><th>Discount</th><th>Total</th><th>Date & Time</th></tr>
     </thead>
     <tbody>
       <?php
       $sql = "SELECT * FROM customerHistory WHERE customerMobile='".$row["customerMobile"]."' ORDER BY `date` DESC" ;
       $result = $conn->query($sql);
       if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
     echo "<tr><td>".$row["items"]."</td><td>".$row["totalPrice"]."</td><td>".$row["discount"]."</td><td>".$row["paidAmount"]."</td><td>".$row["date"]."</td></tr>";
     
        }
      }
     ?>
     </tbody>
     </table>
 </div>
 
 <script>
     $(document).ready( function () {
     $('#myTable').DataTable({
      "pageLength": 5,
      "lengthMenu": [[5,10, 25,-1], [5,10, 25, "All"]]
     });
 } );
     </script>
 </body>
 </html>