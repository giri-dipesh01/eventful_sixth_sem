<?php
include("adminheader.php");
?>

<section class="dashboard">
    <div class="top">
        <i class="uil uil-bars sidebar-toggle"></i>
        <img src="images/profile.jpg" alt="">
    </div>

    <div class="dash-content">
        <div class="overview">
            <div class="title">
                <i class="uil uil-tachometer-fast-alt"></i>
                <span class="text">
                <?php 
                    date_default_timezone_set("Asia/Kathmandu");  
                    $h = date('G');
                    if($h>=5 && $h<=11)
                    {
                        echo ("Good Morning Admin!");
                    }
                    else if($h>=12 && $h<=15)
                    {
                        echo ("Good Afternoon Admin!");
                    }
                    else
                    {
                        echo ("Good Evening Admin!");
                    }
                ?>
                </span>
            </div>
        </div>
            <div class="activity">
                <div class="title">
                    <i class="uil uil-clock-three"></i>
                    <span class="text">List of Students</span> 
                </div>
            </div>
    </div>
    <table border='1' width="100%">
        <tr>
            <th style="width:1%">#</th>
            <th style="width:20%">Name</th>
            <th style="width:20%">Email</th>
            <th style="width:10%">Gender</th>
            <th style="width:10%">Phone No</th>
            <th style="width:10%">Batch</th>
            <th style="width:10%">Semester</th>
            <th style="width:10%">Status</th>
            <th>Action</th> 
        </tr>
        <?php
            $connection = new mysqli("localhost","root","","eventful");
            if($connection->connect_errno != 0){
                die("Connection failed");
            }
            
            $sql = "SELECT * FROM students";
            $i = 1;
            if($result = $connection->query($sql))
            {
                while($row = $result->fetch_assoc())
                {
                    echo 
                    "
                        <tr>
                            <td>".$i++."</td>
                            <td>".$row['full_name']."</td>
                            <td>".$row['email']."</td>
                            <td>".$row['gender']."</td>
                            <td>".$row['phone']."</td>
                            <td>".$row['batch']."</td>
                            <td>".$row['semester']."</td> 
                            <td>".$row['verification']."</td>
                            <td>
                                <form action='readstudents.php' method='post'>
                                    <input type='hidden' value='".$row['email']."' name='student_update'>
                                    <input type='submit' value='View' name='update'>
                                </form>  
                            </td>           
                        </tr>
                    ";
                }
            }
        ?>  
        <tr>
            <th style="width:1%">#</th>
            <th style="width:20%">Name</th>
            <th style="width:20%">Email</th>
            <th style="width:10%">Gender</th>
            <th style="width:10%">Phone No</th>
            <th style="width:10%">Batch</th>
            <th style="width:10%">Semester</th>
            <th style="width:10%">Status</th>
            <th>Action</th> 
        </tr>    
    </table>
</section>
<script src="script.js"></script>
</body>
</html>