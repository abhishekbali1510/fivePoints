<?php
require("conn.php");
session_start();
if($_SESSION['login']==true)
  {
        $sql = "SELECT * FROM customerDetails WHERE customerMobile='".$_SESSION["currentCustomer"]."'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        
        if(isset($_POST['renew']))
        {
            if($_POST['membershipAmt']!="")
            {
                $money=$row["moneyLeft"]+$_POST["membershipAmt"];
                $sql="UPDATE `customerDetails` SET `moneyLeft` = '".$money."' WHERE `customerDetails`.`customerMobile` = '".$_SESSION["currentCustomer"]."'";
                $result = $conn->query($sql);
                $sql="UPDATE `customerDetails` SET `membershipAmount` = '".$_POST["membershipAmt"]."' WHERE `customerDetails`.`customerMobile` = '".$_SESSION["currentCustomer"]."'";
                $result = $conn->query($sql);
                header("location: customerDash.php");
            }
            else{
                $_SESSION['error4']="select amount";
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
    <h1>Renew Membership</h1>
    <form method="POST" action="<?php echo $_SERVER["PHP_SELF"];?>">
    
    Membership Amount : 
    <br>
    <input type="radio"  name="membershipAmt" value="5000">
    <label for="5000">5000</label><br>
    <input type="radio"  name="membershipAmt" value="10000">
    <label for="10000">10000</label><br>
    <input type="radio"  name="membershipAmt" value="30000">
    <label for="30000">30000</label>
    
    <br><br>
    
    <br>
    <input type="submit" name="renew" class="login login-submit" value="Renew">
    <p><?php echo $_SESSION['error4']?></p>
  </form>
</body>
</html>