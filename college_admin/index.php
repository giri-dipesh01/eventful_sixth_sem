<?php
    if(isset($_POST['login'])) 
    // isset le click , submit bako ho ki hoina check garxa
    {
        // login gareko xa bane k kam garne define gareko 
        $email=$_POST['email']; // name collect garne variable
        $password=md5($_POST['password']);// password collect garne variable
        //echo ($email." and ".$password."<br>");// display of variable

        // Connection ko variable
        $connection= new mysqli("localhost","root","","eventful");
        // Checking Database Connection
        if($connection->connect_errno!=0)
        // 0 means connected 
        {
            die("Database Connectivity Error");
        }

        // comparision qeury using select
        //user ko table databse sanga
        $sql="SELECT * FROM admin WHERE admin_email='$email' AND admin_password='$password'";
        $result=$connection->query($sql);// query execution
        if($result->num_rows>0)// data match bako xa bane
        {
          // session start after login
          session_start();

          // table ma bako data extract gareko adminlist table bata
         $row=$result->fetch_assoc();

           // tes lai $_Session ma store gareko
         $_SESSION['admin']=$row;

          // redirecting to  user dashboard page after login is successful with session
          header("Location:admin.php");
          echo("<script> alert('Success');</script>"); 
        }
        else // data match bako xaina bane
        {
          echo("<script> alert('$email $password Wrong Email Or Password ');</script>");
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Eventful</title>
    <!---Custom CSS File--->
    <link rel="stylesheet" href="../css/register.css" />   
  </head>
  <body>
  <nav>
  <div class="navbar-left">
    <h2><a href="../index.php">Eventful!</a></h2>
  </div>
</nav>
    <br><br><br>
    <section class="container">
      <header>Admin Login Form</header>
      <form action="index.php" method="post" class="form" autocomplete="off">
        <div class="input-box">
          <label>Email Address</label>
          <input type="email" placeholder="Enter email address" name="email" required />
        </div>
        <div class="input-box">
          <label>Password</label>
          <input type="password" placeholder="Enter Your Password" name="password" required />
        </div>
        <button type="submit" name="login">Login</button>
      </form>
    </section>
  </body>
</html>