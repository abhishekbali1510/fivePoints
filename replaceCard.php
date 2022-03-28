<?php
require("conn.php");
session_start();
if($_SESSION['login']==true)
  {
        $sql = "SELECT * FROM customerDetails WHERE customerMobile='".$_SESSION["currentCustomer"]."'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        
        if(isset($_POST['replace']))
        {
            if($_POST['cusCard']!="")
            {
                $card=$_POST["cusCard"];
                $sql="UPDATE `customerDetails` SET `customerCardNumber` = '".$card."' WHERE `customerDetails`.`customerMobile` = '".$_SESSION["currentCustomer"]."'";
                $result = $conn->query($sql);
                header("location: customerDash.php");
            }
            else{
                $_SESSION['error5']="Enter Card number";
            }
            
        }

  }
  else
  {
    header("location: index.php");
    //redirect to dashboard
  }




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' href='http://codepen.io/assets/libs/fullpage/jquery-ui.css'>

<link rel="stylesheet" href="login.css" media="screen" type="text/css" />
    <title>five Points</title>
</head>
<body>
<header>
    <a href="customerDash.php"><div>Back</div></a>
    
  </header>
<div class= "customerInfo">
      <?php
        echo "<div>money left : ".$row["moneyLeft"]."</div>";
      
        echo "<div>membership amount : ".$row["membershipAmount"]."</div>";
        
        echo "<div>name : ".$row["customerName"]."</div>";
        
        echo "<div>mobile : ".$row["customerMobile"]."</div>";

        echo "<div>Email : ".$row["customerEmail"]."</div>";

        echo "<div>Card Number : ".$row["customerCardNumber"]."</div>";
        ?>
    </div>
    <h1>Replace Card</h1>
    <form method="POST" action="<?php echo $_SERVER["PHP_SELF"];?>">
    
    <input type="text" name="cusCard" placeholder="Customer Card number">
    <input type="submit" name="replace" class="login login-submit" value="replace">
    <p><?php echo $_SESSION['error5']?></p>
  </form>
</body>
</html>