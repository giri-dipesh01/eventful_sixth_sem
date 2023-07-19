<?php
include("adminheader.php");
    if(isset($_POST['updateStudent']))
    {   
        $status=$_POST['status'];
        $update_id=$_POST['student_updateid'];         
        $connection= new mysqli("localhost","root","","eventful");
        // Checking Database Connection
        if($connection->connect_errno!=0)
        // 0 means connected 
        {
            die("Database Connectivity Error");
        }
        $updatesql="UPDATE students SET verification='$status' 
        WHERE student_id='$update_id'";
        if($updateresult=$connection->query($updatesql))
        {
            header("Location:admin.php");
        } 
        else
        {
            echo("Error");
        }           
    }
?>
<section class="dashboard">
    <div class="top">
        <i class="uil uil-bars sidebar-toggle"></i>
        <div class="search-box">
            <i class="uil uil-search"></i>
            <input type="text" placeholder="Search here...">
        </div>
        <img src="images/profile.jpg" alt="">
    </div>
    <div class="dash-content">
        <div class="activity">
            <div class="title">
                <i class="uil uil-clock-three"></i>
                <span class="text">Student's Information</span> 
            </div>
        </div>
    </div>
    <table border='1' width="100%" align="center">
        <tr>
            <th style="width:1%">#</th>
            <th style="width:15%">Title</th>
            <th style="width:25%">Information</th>
            <th style="width:5%">Photo</th>
        </tr>
        <?php
            if(isset($_POST['update']))
            {
                $id=$_POST['student_update'];
                
                $connection= new mysqli("localhost","root","","eventful");
                
                // Checking Database Connection
                if($connection->connect_errno!=0)
                // 0 means connected 
                {
                die("Database Connectivity Error");
                }
                $sql="SELECT * FROM students NATURAL JOIN students_profile where students_profile.email='$id'";
                if($result=$connection->query($sql))
                {
                        foreach($result as $row){}
                }
                
        ?>
            <tr>
            <td>1</td>    
            <td>Name</td>
            <td><?php echo($row['full_name'])?></td>
            <td rowspan="10"><?php if(($row['photo'])=='')
            {
                echo("<img src='../profile/img.png' name='photo'>");
            }
            else{
                echo ("<img name='photo' src='" . $row['photo'] ."'>");
            }
            ?></td>
            </tr>
            <tr>
            <td>2</td>    
            <td>Phone</td>
            <td><?php echo($row['phone'])?></td>
            </tr>  
            <tr>
            <td>3</td>    
            <td>Email</td>
            <td><?php echo($row['email'])?></td>
            </tr>
            <td>4</td>    
            <td>Gender</td>
            <td><?php echo($row['gender'])?></td>
            </tr>
            <td>5</td>    
            <td>TU Registration Number</td>
            <td><?php echo($row['turegno'])?></td>
            </tr> 
            <td>6</td>    
            <td>Semester</td>
            <td><?php echo($row['semester'])?></td>
            </tr>
            <td>7</td>    
            <td>Batch</td>
            <td><?php echo($row['batch'])?></td>
            </tr> 
            <td>8</td>    
            <td>Registered Date & Time</td>
            <td><?php echo($row['register_date'])?></td>
            </tr> 
            <tr>
            <td>9</td>    
            <td>ID Card</td>
            <td>
                <?php 
                $file = $row['id_card'];
                if ($row['id_card'] == '')
                {
                    echo('<span class="text"> No File Uploaded</span>');
                    
                }
                elseif(!$row['id_card'] == '')
                {
                    $file_path = dirname($_SERVER['PHP_SELF']) . '/' . $file;
                    echo '<a href="' . $file_path . '" target="_blank">View</a>';
                    echo '</div>';
                }
                ?>
            </td>
            </tr>
            <tr>
            <td>10</td>    
            <td>Status</td>
            <td><?php echo($row['verification'])?></td>
            </tr>
    </table>
            <div class="input-box address">
            <form action="readstudents.php" method="post">
            <label>Update Student Status</label> <br> <br>
            <div class="column">
                <div class="select-box">
                    <select name="status" >
                        <option hidden>Update Status</option>
                        <option value="Rejected">Rejected</option>
                        <option value="Completed">Completed</option>
                        <option value="Verified">Verified</option>
                    </select>
                </div>
            </div> <br> <br>
            <input type="hidden" name="student_updateid" value="<?php echo($row['student_id']);?>">
            <button type="submit" name="updateStudent">Update</button>
            </form>    
        </div>
        <?php
            }
            else
            {
            echo("No Student Selected");
            echo("
            <a href='admin.php'>Here is the list of Students</a>
            <br><br>
            ");
            }
        ?>     
</section>
<script src="script.js"></script>
</body>
</html>