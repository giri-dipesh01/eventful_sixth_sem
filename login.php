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
        $sql="SELECT * FROM students WHERE email='$email' AND password='$password' AND verification='Verified'";
        $result=$connection->query($sql);// query execution
        if($result->num_rows>0)// data match bako xa bane
        {
          // session start after login
          session_start();

          // table ma bako data extract gareko students table bata
         $row=$result->fetch_assoc();

           // tes lai $_Session ma store gareko
         $_SESSION['students']=$row;

          // redirecting to  user dashboard page after login is successful with session
          header("Location:students/students.php");
          echo("<script> alert('Success');</script>"); 
        }
        $checksql="SELECT * FROM students WHERE email='$email' AND password='$password' AND verification!='Verified'";
        $r=$connection->query($checksql);// query execution
        if($r->num_rows>0)// data match bako xaina bane
        {
          echo("<script> alert(' Please Contact Admin for Verification');</script>");
          $errorMessage = "Please Contact Admin for Verification";
        }
        else{
          $errorMessage = "Account doesn't Exist or Wrong Email or Password";
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
    <link rel="stylesheet" href="css/register.css" />   
  </head>
  <body>
  <nav>
  <div class="navbar-left">
    <h2><a href="index.php">Eventful!</a></h2>
  </div>
  <div class="navbar-right">
  <h2> <a href="register.php">Register</a> <h2>
  </div>
</nav>
    <br><br><br>
    <section class="container">
      <header>Student Login Form</header>
      <form action="login.php" method="post" class="form" autocomplete="off">
        <div class="input-box">
          <label>Email Address</label>
          <input type="email" placeholder="Enter email address" name="email" value="<?php if(isset($_POST['login'])){echo $email;}?>" required />
        </div>
        <div class="input-box">
          <label>Password</label>
          <input type="password" placeholder="Enter Your Password" name="password" required />
        </div>
        <button type="submit" name="login">Login</button>
        <?php if (!empty($errorMessage)) {
        echo '<div class="error-message">' . $errorMessage . '</div>';
    }
    ?>
      </form>
    </section>
  </body>
</html><!--Hello-->