<?php
  
  require 'conn.php';
  session_start();
  $_SESSION['currentCustomer']="";
  if($_SESSION['login']==true)
  {
    if(isset($_POST['getData']))
    {
      
      if($_POST['cusID']!="" )
      {
        
        $_SESSION['error1']= "";
        
        $sql = "SELECT customerMobile FROM customerDetails WHERE customerMobile='".$_POST["cusID"]."'";
        $result = $conn->query($sql);
        
        $sql = "SELECT customerCardNumber,customerMobile FROM customerDetails WHERE customerCardNumber='".$_POST["cusID"]."'";
        $result2 = $conn->query($sql);

        if ($result->num_rows > 0) 
        {   
            while($row = $result->fetch_assoc())
            {
                $_SESSION['currentCustomer']=$row['customerMobile'];
                header("location: customerDash.php");   
            }
        }
        else if ($result2->num_rows > 0) 
        {   
            while($row = $result2->fetch_assoc())
            {
                $_SESSION['currentCustomer']=$row['customerMobile'];
                header("location: customerDash.php");   
            }
        }
        else
        {
          $_SESSION['error1']= "Customer not registered";
        }
      }
      else
      {
        
        $_SESSION['error1']="Enter phone number";
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
    <a href="newCustomer.php"><span>New customer</span></a>
  </header>

    <br><br><br><br>
  <div class="login-card">
    <h2>Customer Mobile number</h2><br>
  <form method="POST" action="<?php echo $_SERVER["PHP_SELF"];?>">
    <input type="text" name="cusID" placeholder="Mobile num">
    
    <input type="submit" name="getData" class="login login-submit" value="Submit">
    <p><?php echo $_SESSION['error1']?></p>
  </form>

  
</div>


  <script src='http://codepen.io/assets/libs/fullpage/jquery_and_jqueryui.js'></script>

</body>

</html>