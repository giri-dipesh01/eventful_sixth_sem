<?php
// aaj PHP ko code add
// session lai start gareko
  $connection= new mysqli("localhost","root","","eventful");
        // Checking Database Connection
        if($connection->connect_errno!=0)
        // 0 means connected 
        {
            die("Database Connectivity Error");
        }
  session_start(); 

  // session check gareko with $_SESSION variable
  if(!isset($_SESSION['admin'])) 
  {
    // yedi session xaina bane login ma patidine
    header("Location:index.php"); 
  }

  // yedi session xa bane
  // afno table ko nam, mero students thiyo
  $row=$_SESSION['admin']; 

  // email lai store gareko admin ko table bata
  $email=$row['admin_email']; 

  // logout ko main functionality

  // logout button click gareko case ma
  if(isset($_POST['logout'])) // isset le click bako xa ki xaina check garxa
  {
    // user ko data session bata hataideu
    session_destroy();
    // ani back to login page 
    header("Location:../index.php");  
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!----======== CSS ======== -->
    <link rel="stylesheet" href="style.css">
    <!----=======Table CSS---->
    <style>
        /* Table Styles */
      table 
      {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;
      }

      th, td {
      padding: 10px;
      text-align: left;
      }
      
      
      th {
      background-color: #7fa6d1;
      color: var(--text-color);
      } 

      td {
      background-color: #ffe6ac;
      color: var(--text-color);
      border-bottom: 1px solid var(--border-color);
      }

      tr:nth-child(even) td {
      background-color: var(--box2-color);
      }

      tr:last-child td {
      border-bottom: none;
      }

      tr:hover td {
      background-color: #e6e5e5;
      }

      /* Form Styles */
      form {
      display: inline-block;
      }

      input[type="submit"] {
      background-color: #9784bb;
      color: var(--text-color);
      border: none;
      padding: 5px 10px;
      cursor: pointer;
      }

      input[type="submit"]:hover {
      background-color: var(--box3-color);
      }

      input[type="hidden"] {
      display: none;
      }

    </style>
     
    <!----===== Iconscout CSS ===== -->
    <link rel="stylesheet" href="../css/line.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

    <title>Admin Dashboard Panel</title> 
</head>
<body>
    <nav>
        <div class="logo-name">
            <div class="logo-image">
                <img src="images/logo2.png" alt="">
            </div>
            <span class="logo_name">EventFul!</span>
        </div>
        <div class="menu-items">
            <ul class="nav-links">
                <li><a href="admin.php">
                    <i class="uil uil-estate"></i>
                    <span class="link-name">Dahsboard</span>
                </a></li>
                <li><a href="admin.php">
                    <i class="uil uil-book-reader"></i>
                    <span class="link-name">Students</span>
                </a></li>
                <li><a href="events.php">
                    <i class="uil uil-coffee"></i>
                    <span class="link-name">Events</span>
                </a></li>
                <li><a href="readreviews.php">
                    <i class="uil uil-favorite"></i>
                    <span class="link-name">Reviews</span>
                </a></li>
                </ul>
            <ul class="logout-mode">
                <li>
                  <form action="admin.php" method="POST">
                    <button type="submit" name="logout"><i class="uil uil-signout"></i></button>
                  </form>
                </li>  
            </ul>
        </div>
    </nav>