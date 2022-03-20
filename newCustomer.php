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

              if($_POST['membershipAmt']=="5000")
              {
                $discount=20;
              }
              elseif($_POST['membershipAmt']=="10000")
              {
                $discount=30;
              }
              elseif($_POST['membershipAmt']=="30000")
              {
                $discount=40;
              }

          $sql = "INSERT INTO `customerDetails` (`customerName`, `customerMobile`, `customerEmail`, `membershipAmount`, `customerCardNumber` ,`moneyLeft`) VALUES ('".$_POST["cusName"]."','".$_POST["cusPhone"]."', '".$_POST["cusEmail"]."', '".$_POST["membershipAmt"]."','".$_POST["cusCard"]."','".$_POST["membershipAmt"]."');";
          $conn->query($sql);
          $html="done";
          $html=nl2br("Hello ".$_POST['cusName']."\n
          Congratulations  and welcome to Five Points Unisex Salon, thank you for being a valuable member! Please enjoy ".$discount."% OFF on all your services at Five Points Unisex Salon. \n
          Your unique card number is ".$_POST['cusCard']." .Always Bring this card while visiting salon.\n
          Terms and Conditions :\n
          -You'll get ".$discount."% off on all your services\n
          -This card can be used by 4 members including you\n
          -If the membership amount is over, it is optional for you to renew it.\n
          -In case your card is lost, immediately inform on 9773689916\n
          If you have any questions or ever need help, feel free to email us at fivepointsE1@gmail.com or  call us at 9773689916.\n
          Thanks and Regards\n
          FIve Points Unisex Salon");

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