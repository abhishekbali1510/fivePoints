<?php
  require 'conn.php';
  session_start();
  if($_SESSION['login']==true)
  {
    if(isset($_POST['createCustomer']))
    {
      
      if($_POST['cusPhone']!="" AND $_POST['membershipAmt']!="" AND $_POST['cusName']!="" AND $_POST['cusEmail']!="")
      {
        $sql = "SELECT customerMobile FROM customerDetails WHERE customerMobile='".$_POST["cusPhone"]."'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) 
        {
          $_SESSION['error']="Already registered";
        }
        else
        {
          $_SESSION['error']= "";
          $sql = "INSERT INTO `customerDetails` (`customerName`, `customerMobile`, `customerEmail`, `membershipAmount`,`moneyLeft`) VALUES ('".$_POST["cusName"]."','".$_POST["cusPhone"]."', '".$_POST["cusEmail"]."', '".$_POST["membershipAmt"]."','".$_POST["membershipAmt"]."');";
          $conn->query($sql);
          // pop up customer created
        }
        
      }
      else
      {
        
        $_SESSION['error']="Enter all fields";
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
    
    <br>
    <input type="submit" name="createCustomer" class="login login-submit" value="Submit">
    <p><?php echo $_SESSION['error']?></p>
  </form>

  
</div>


  <script src='http://codepen.io/assets/libs/fullpage/jquery_and_jqueryui.js'></script>

</body>

</html>