<?php
  require 'conn.php';
  require 'mail.php';
  session_start();
  if($_SESSION['login']==true)
  {
    if(isset($_POST['createCustomer']))
    {
      
      if($_POST['cusPhone']!="" AND $_POST['membershipAmt']!="" AND $_POST['cusName']!="" AND $_POST['cusEmail']!="" AND $_POST['cusCard']!="")
      {
        $sql = "SELECT customerMobile FROM customerDetails WHERE customerMobile='".$_POST["cusPhone"]."'";
        $resultMobile = $conn->query($sql);

        $sql = "SELECT customerEmail FROM customerDetails WHERE customerEmail='".$_POST["cusEmail"]."'";
        $resultEmail = $conn->query($sql);

        $sql = "SELECT customerCardNumber FROM customerDetails WHERE customerCardNumber='".$_POST["cusCard"]."'";
        $resultCard = $conn->query($sql);

        if ($resultMobile->num_rows > 0) 
        {
          $_SESSION['error2']="Already registered";
        }
        else if ($resultEmail->num_rows > 0) 
        {
          $_SESSION['error2']="Already registered Email";
        }
        else if ($resultCard->num_rows > 0) 
        {
          $_SESSION['error2']="Already registered card number";
        }
        else
        {
          $_SESSION['error2']= "";
          $sql = "INSERT INTO `customerDetails` (`customerName`, `customerMobile`, `customerEmail`, `membershipAmount`, `customerCardNumber` ,`moneyLeft`) VALUES ('".$_POST["cusName"]."','".$_POST["cusPhone"]."', '".$_POST["cusEmail"]."', '".$_POST["membershipAmt"]."','".$_POST["cusCard"]."','".$_POST["membershipAmt"]."');";
          $conn->query($sql);
          $html="done";
          $html="Hello ".$_POST['cusName']."
          Congratulations  and welcome to Five Points Unisex Salon, thank you for being a valuable member! Please enjoy 20% OFF on all your services at Five Points Unisex Salon.Always Bring this card while visiting salon.
          Terms and Conditions :
          -You'll get 20% off on all your services
          -This card can be used by 4 members including you
          -If the membership amount is over, it is optional for you to renew it.
          -In case your card is lost, immediately inform on 9773689916
          If you have any questions or ever need help, feel free to email us at fivepointsE1@gmail.com or  call us at 9773689916.
          Thanks and Regards
          FIve Points Unisex Salon";

				  echo smtp_mailer($_POST['cusEmail'],'FivePoints',$html);
          header("location: dash.php");
          
        }
        
      }
      else
      {
        
        $_SESSION['error22']="Enter all fields";
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
<html>

<head>

  <meta charset="UTF-8">

  <title>Five points</title>

  <link rel='stylesheet' href='http://codepen.io/assets/libs/fullpage/jquery-ui.css'>

    <link rel="stylesheet" href="login.css" media="screen" type="text/css" />

</head>

<body>

  <header>
    <a href="dash.php"><span>Back</span></a>
  </header>

    <br><br><br><br>
  <div class="login-card">
    <h2>Enter Customer Details</h2><br>
  <form method="POST" action="<?php echo $_SERVER["PHP_SELF"];?>">
    <input type="text" name="cusPhone" placeholder="Mobile num">
    <input type="text" name="cusName" placeholder="Customer name">
    <input type="email" name="cusEmail" placeholder="Customer email">
    Membership Amount : 
    <br>
    <input type="radio"  name="membershipAmt" value="5000">
    <label for="5000">5000</label><br>
    <input type="radio"  name="membershipAmt" value="10000">
    <label for="10000">10000</label><br>
    <input type="radio"  name="membershipAmt" value="30000">
    <label for="30000">30000</label>
    
    <br><br>
    <input type="text" name="cusCard" placeholder="Customer Card number">
    <br>
    <input type="submit" name="createCustomer" class="login login-submit" value="Submit">
    <p><?php echo $_SESSION['error2']?></p>
  </form>

  
</div>


  <script src='http://codepen.io/assets/libs/fullpage/jquery_and_jqueryui.js'></script>

</body>

</html>