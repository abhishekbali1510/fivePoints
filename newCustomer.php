<?php
  session_start();
  if($_SESSION['login']==true)
  {
    
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
    <a href="link.html"><span>New customer</span></a>
  </header>

    <br><br><br><br>
  <div class="login-card">
    <h2>Enter Customer Details</h2><br>
  <form method="POST" action="<?php echo $_SERVER["PHP_SELF"];?>">
    <input type="text" name="phone" placeholder="Mobile num">
    <input type="text" name="cusName" placeholder="Customer name">
    <input type="email" name="email" placeholder="Customer email">
    <input type="text" name="membershipAmt" placeholder="Membership amount">
    
    
    <input type="submit" name="loginbtn" class="login login-submit" value="Submit">
    <p><?php echo $_SESSION['error']?></p>
  </form>

  
</div>


  <script src='http://codepen.io/assets/libs/fullpage/jquery_and_jqueryui.js'></script>

</body>

</html>