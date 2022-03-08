<?php
  session_start();
  if($_SESSION['login']==false)
  {
    if(isset($_POST['loginbtn']))
    {
      if(($_POST['user']=="admin")&&($_POST['pass']=="password"))
      {
        $_SESSION['login']=true;
        header("location: dash.php");
      }
      else
      {
        $_SESSION['error']="wrong credentials";
      }
    }
  }
  else
  {
    header("location: dash.php");
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
    <br><br><br><br>
  <div class="login-card">
    <h1>Log-in</h1><br>
  <form method="POST" action="<?php echo $_SERVER["PHP_SELF"];?>">
    <input type="text" name="user" placeholder="Username">
    <input type="password" name="pass" placeholder="Password">
    <input type="submit" name="loginbtn" class="login login-submit" value="login">
    <p><?php echo $_SESSION['error']?></p>
  </form>

  
</div>


  <script src='http://codepen.io/assets/libs/fullpage/jquery_and_jqueryui.js'></script>

</body>

</html>