<?php
// register button click gare paxi k kam garne
if(isset($_POST['register'])) 
{
  // Variable declare gareko for collecting input fields from form
    $email=$_POST['email'];
    $full_name=$_POST['full_name'];
    $phone=$_POST['phone'];
    $batch=$_POST['batch'];
    $gender=$_POST['gender'];
    $regno=$_POST['regno'];
    //$semester=$_POST['semester'];
    // md5 encryption for password
    $password=md5($_POST['password']);
    
    //Database ko Path
   $connection=new mysqli("localhost","root","","eventful");
   if($connection->connect_errno!=0)// 0 means connected 
   {
      die("Database Connectivity Error");
   }
  $select="SELECT * FORM students WHERE email='$email'";
  $no=$connection->query($select);
  if($no->num_rows>0)
  {
  echo("<script> alert('User Already Exists');</script>");
  }
  else
  {
   // Insert garne SQL Query
  
  $sql="INSERT INTO students(email,password,full_name,gender,turegno, phone, batch) 
  VALUES ('$email','$password','$full_name','$gender','$regno','$phone','$batch')";
    
    // query execution
    $result=$connection->query($sql);
    if($result)
    {
      header("Location:login.php");
      $profile="INSERT INTO students_profile(email,full_name) VALUES ('$email','$full_name')";
		  $result2=$connection->query($profile);
    }
    else
    {
      echo(" Please Try Again');</script>");
    }
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
    <!-- JS Start-->
    <script>
      document.addEventListener("DOMContentLoaded", function() {
        var password = document.querySelector('input[name="password"]');
        var confirm = document.querySelector('input[name="confirm"]');
        var form = document.querySelector("form");

        form.addEventListener("submit", function(event) {
          if (password.value !== confirm.value) {
            event.preventDefault(); // Prevent form submission
            showError("Password and confirm password do not match");
          }
        });

        function showError(message) {
          var errorContainer = document.createElement("div");
          errorContainer.classList.add("error-message");
          errorContainer.textContent = message;

          // Remove existing error message if any
          var existingError = document.querySelector(".error-message");
          if (existingError) {
            existingError.remove();
          }

          // Append error message to the form
          form.appendChild(errorContainer);
        }
      });
    </script>
  </head>
  <body>
  <nav>
  <div class="navbar-left">
    <h2><a href="index.php">Eventful!</a></h2>
  </div>
  <div class="navbar-right">
  <h2> <a href="login.php">Login</a> <h2>
  </div>
</nav>

    <br><br><br>
    <section class="container">
      <header>Student Registration Form</header>
     
      <form action="register.php" method="post" class="form" autocomplete="off">
        <div class="input-box">
          <label>Email Address</label>
          <input type="email" placeholder="Enter email address" name="email" required />
        </div>
       
        <div class="input-box address">
          <label>Personal Details</label>
          <div class="column">
          <div class="input-box">
          <label>Full Name</label>
          <input type="text" placeholder="Enter full name" name="full_name" 
          pattern="^[A-Za-z\s]+$" 
          value="" required />
          </div>
          <div class="input-box">
            <label>Phone Number</label>
            <input type="text" placeholder="Enter phone number" name="phone" pattern="^\d{10}$"  required />
          </div>
        </div>
          <div class="column">
          <div class="input-box">
            <label>Gender</label>
            <div class="select-box">
              <select name="gender" >
                <option hidden>Gender</option>
                <option value="Female">Female</option>
                <option value="Male">Male</option>
                <option value="Perfer not to say">Prefer Not to Say</option>
              </select>
            </div>
          </div>  
            <div class="input-box">
            <label>TU Registration Number</label>
            <input type="text" placeholder="Enter Reg NO Ex: 6292012019" name="regno" pattern="^\d{10,11}$"  required />
          </div>
        </div>
        <div class="input-box address">
          <label>Academic Details</label>
          
          <div class="column">
            <div class="select-box">
              <select name="batch" >
                <option hidden>Batch</option>
                <option value="2075 BS">2075 BS</option>
                <option value="2076 BS">2076 BS</option>
                <option value="2077 BS">2077 BS</option>
                <option value="2078 BS">2078 BS</option>
                <option value="2079 BS">2079 BS</option>
                <option value="2080 BS">2080 BS</option>
              </select>
            </div>           
        </div>
        <div class="column">
          <div class="input-box">
            <label>Password</label>
            <input type="password" name="password" pattern="^.{10,}$" placeholder="Enter Your Password" required />
          </div>
          <div class="input-box">
            <label>Confirm Password</label>
            <input type="password" name="confirm"  pattern="^.{10,}$" placeholder="Confirm Password" required />
          </div>
        </div>
        <button type="submit" name="register">Submit</button>
      </form>
    </section>
  </body>
</html>

