<?php
include("studentsheader.php");
?>

    <div class= "dash-content">
        <div class="overview">
            <div class="title">
                <i class="uil uil-tachometer-fast-alt"></i>
                <span class="text">
                <?php 
                    date_default_timezone_set("Asia/Kathmandu");  
                    $h = date('G');
                    if($h>=5 && $h<=11)
                    {
                        echo ("Good Morning $full_name!");
                    }
                    else if($h>=12 && $h<=15)
                    {
                        echo ("Good Afternoon $full_name!");
                    }
                    else
                    {
                        echo ("Good Evening $full_name!");
                    }
                ?>
                </span> <br>
                
            </div>
            <div class="activity">
            <p>Your Interests are:- </p>
                <?php
                $connection=new mysqli("localhost","root","","eventful");
                
                $selectsql = "SELECT * FROM `students_profile` WHERE email='$email'";
                if($connection->connect_errno!=0)
                // 0 means connected 
                {
                die("Database Connectivity Error");
                }
                $result = mysqli_query($connection, $selectsql);

                if ($result) {
                $row = $result->fetch_assoc();
                echo"<p>".$row['interests']."</p>";
                } else {
                echo "Error: " . mysqli_error($connection);
                }
                ?>
                <div class="title">
                    <i class="uil uil-clock-three"></i>
                    <span class="text">Update Your Interests</span>      
                </div>
                
                <!-- Updated Checkbox Layout -->
                <div class="checkbox-group">
                    <form action="students.php" method="post" enctype="multipart/form-data">
                    <label>
                    <input type="checkbox" id="Sports" name="interests[]" value="Sports">
                        Sports
                    </label> 
                    <label>
                    <input type="checkbox" id="InternetOfThings" name="interests[]" value="Internet of Things">
                        Internet of Things
                    </label> 
                    <label>
                    <input type="checkbox" id="Programming" name="interests[]" value="Programming">
                    Programming
                    </label> 
                    <label>
                    <input type="checkbox" id="Art_Design" name="interests[]" value="Art & Design">
                    Art & Design
                    </label> 
                    <label>
                    <input type="checkbox" id="Sports" name="interests[]" value="Musical & Cultural Events">
                        Musical & Cultural Events
                    </label> 
                    <label>
                    <input type="checkbox" id="Hackathon" name="interests[]" value="Hackathons">
                        Hackathons
                    </label> 
                    <label>
                    <input type="checkbox" id="Others" name="interests[]" value="Others">
                        Others
                    </label> <br>
                    <input type="submit" value="Submit" name="check_box_submit">
                    </form>
                </div>
            </div>
    </div> 
</section>
<script src="script.js"></script>
</body>
</html>

<?php
if (isset($_POST['check_box_submit'])) 
    {
        $checkbox1=$_POST['interests'];  
        $chk="";  
        foreach($checkbox1 as $chk1)  
        {  
            $chk .= $chk1.",";  
        }
        $interestsql = "UPDATE students_profile SET interests='$chk' WHERE email='$email'";
        if ($connection->query($interestsql) === TRUE) {
            echo"<script> 
            alert('Interests Updated successfully: $chk<br>');
            window.location.href = 'students.php';
            </script>";
            
        } 
        else 
        {   
            echo"<script> 
            alert('Interests Updated successfully: . $connection->error<br>');
            </script>";
        }
    }
?>