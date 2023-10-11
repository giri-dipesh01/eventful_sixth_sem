<?php
include("adminheader.php");
    if(isset($_POST['updateReview']))
    {   
        $status=$_POST['status'];
        $update_id=$_POST['update_id'];         
        $connection= new mysqli("localhost","root","","eventful");
        // Checking Database Connection
        if($connection->connect_errno!=0)
        // 0 means connected 
        {
            die("Database Connectivity Error");
        }
        $updatesql="UPDATE participation SET participation_status='$status' WHERE participation_id='$update_id'";
        if($updateresult=$connection->query($updatesql))
        {
            header("Location:readreviews.php");
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
                <span class="text">Review's Information</span> 
            </div>
        </div>
    </div>
    <table border='1' width="100%" align="center">
        <tr>
            <th style="width:1%">#</th>
            <th style="width:25%">Title</th>
            <th style="width:25%">Information</th>
            <th style="width:5%">Event Banner</th>
        </tr>
        <?php
            if(isset($_POST['review_update']))
            {
                $id=$_POST['participation_id'];
                
                $connection= new mysqli("localhost","root","","eventful");
                
                // Checking Database Connection
                if($connection->connect_errno!=0)
                // 0 means connected 
                {
                die("Database Connectivity Error");
                }
                $sql = "SELECT 
                *
                FROM 
                `participation` p
                INNER JOIN 
                `students` s ON p.`student_email` = s.`email`
                INNER JOIN 
                `events` e ON p.`event_id` = e.`event_id`
                WHERE p.participation_id=$id";
                if($result=$connection->query($sql))
                {
                    foreach($result as $row){}
                } 
        ?>
            <tr>
            <td>1</td>    
            <td>Event Name</td>
            <td><?php echo($row['event_name'])?></td>
            <td rowspan="7"><?php
                        if (empty($row['event_banner'])) {
                            echo('<img class="banner" src="../banners/default.png" width="300px" height="300px">');
                        } else {
                            echo("<img class='banner' src='" . $row['event_banner'] . "'>");
                        }
                        ?>
                        </td>
            </tr>
            <tr>
            <td>2</td>    
            <td>Event Category</td>
            <td><?php echo($row['event_category'])?></td>
            </tr>
            <td>3</td>    
            <td>Organizers</td>
            <td><?php echo($row['event_organizers'])?></td>  
            <tr>
            <td>3</td>    
            <td>Student Name</td>
            <td><?php echo($row['full_name'])?></td>
            </tr>
            <td>4</td>    
            <td>Email</td>
            <td><?php echo($row['email'])?></td>
            </tr>
            <td>5</td>    
            <td>Batch</td>
            <td><?php echo($row['batch'])?></td>
            </tr> 
            <td>6</td>        
            <td>Given Rating</td>
            <td><?php echo($row['rating'])?></td>
            </tr> 
            </tr> 
            <td>6</td>        
            <td>Comment</td>
            <td><?php if(($row['comment'])!=' '){
                echo(" No Comment was added by Student");}
                else{
                    echo($row['comment']);
                }
                ?></td>
            </tr> 
            <td>7</td>    
            <td>Rated Date</td>
            <td><?php echo($row['rated_date'])?></td>
            </tr> 
            
            <tr>
            <td>8</td>    
            <td>Status</td>
            <td><?php echo($row['participation_status'])?></td>
            </tr>
    </table>
            <div class="input-box address">
                <?php
                if(($row['participation_status'])!='Approved')
                {
                ?>
                 <form action="updatereviews.php" method="post">
            <label>Update Student Status</label> <br> <br>
            <div class="column">
                <div class="select-box">
                    <select name="status" >
                        <option hidden>Update Status</option>
                        <option value="Approved">Approved</option>
                        <option value="Rejected">Rejected</option>
                    </select>
                </div>
            </div> <br> <br>
            <input type="hidden" name="update_id" value="<?php echo($row['participation_id']);?>">
            <button type="submit" name="updateReview">Update</button>
            </form>
                    <?php
                   }?>
                
               
        </div>
        <?php
            }
            else
            {
            echo("No Review Selected");
            echo("
            <a href='readreviews.php'>Here is the list of Student's Reviews</a>
            <br><br>
            ");
            }
        ?>     
</section>
<script src="script.js"></script>
</body>
</html>