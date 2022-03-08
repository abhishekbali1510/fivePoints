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

  <title>CodePen - Log-in</title>

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
    <input type="text" name="phone" placeholder="Mobile num">
    
    <input type="submit" name="loginbtn" class="login login-submit" value="Submit">
    <p><?php echo $_SESSION['error']?></p>
  </form>

  
</div>


  <script src='http://codepen.io/assets/libs/fullpage/jquery_and_jqueryui.js'></script>

</body>

</html>