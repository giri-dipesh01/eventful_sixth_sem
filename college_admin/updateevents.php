<?php
include("adminheader.php"); 
// Update Operation Main Code
if(isset($_POST['update_event']))
{
        $un=$_POST["un"]; 
        $ud=$_POST["ud"]; 
        $usd=$_POST["usd"]; 
        $ued=$_POST["ued"]; 
        $uo=$_POST["uo"]; 
        $uc=$_POST["uc"]; 
        $update_id=$_POST["update_id"];
        echo $update_id;
        echo($un);
        
        $sql="UPDATE events SET event_name='$un',
        event_description='$ud',
        event_organizers='$uo',
        event_startdate='$usd',
        event_enddate='$ued',event_category='$uc' 
        WHERE event_id='$update_id'";

        if($result = $connection->query($sql))
        {
            header("Location:events.php");
        }

        else
        {
        echo("Error");
        } 
}
?>
<style>
    fieldset {
        border: 1px solid #ccc;
        padding: 20px;
        margin-bottom: 20px;
    }

    legend {
        font-size: 1.2em;
        font-weight: bold;
        margin-bottom: 10px;
    }

    label {
        display: block;
        margin-bottom: 15px;
    }

    input[type="text"],
    textarea,
    select {
        width: 100%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
        margin-bottom: 10px;
    }

    input[type="date"] {
        width: 100%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
        margin-bottom: 10px;
    }

    input[type="submit"] {
        background-color: #9784bb;
        color: #fff;
        border: none;
        padding: 10px 20px;
        border-radius: 4px;
        cursor: pointer;
    }

    input[type="submit"]:hover {
        background-color: #7f679e;
    }
</style>
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
                <span class="text">Add Events</span> 
            </div>
            <fieldset>
                <legend> Update Event</legend>
                <?php
    if(isset($_POST['update']))
    {
    ?>
    <form action="updateevents.php" method="POST">
                <?php
                 $conn= new mysqli("localhost","root","","eventful");
                if($conn->connect_errno!=0)
                {
                    die("connection failed");
                }
                $id=$_POST['event_updateid'];
                $sql="SELECT * FROM events WHERE event_id='$id'";
                 if($result = $conn->query($sql))
                { $row = $result->fetch_assoc();}
       
                ?>
        
                 <label for="un">Event Name:- 
                    <input type="text" name="un" id="un" size="100" value="<?php echo $row['event_name']?>" >
                </label>
                <br> <br>
                <label for="ud">Event Description:- 
                    <textarea name="ud" id="ud" cols="100" rows="5" value="<?php echo $row['event_description']?>" >
                    </textarea>
                </label>
                <br> <br>
                <label for="uo">Event Organizer:- 
                    <select name="uo" id="uo" required>
                        <?php
                            $connection= new mysqli("localhost","root","","eventful");
                            if($connection->connect_errno!=0)
                            {
                            die("Connection Error!");
                            }
                            $sql="SELECT * FROM categories WHERE type='organizer'";
                            $categories=$connection->query($sql);
                            foreach($categories as $category)
                            {
                            echo("<option value=".$category['category_name'].">".$category['category_name']."</option>");
                            }
                        ?>
                    </select>
                </label>
                <br> <br>
                <label for="uc">Event Category:- 
                   <select name="uc" id="uc">
                        <?php
                            $connection= new mysqli("localhost","root","","eventful");
                            if($connection->connect_errno!=0)
                            {
                            die("Connection Error!");
                            }
                            $sql="SELECT * FROM categories WHERE type='event'";
                            $categories=$connection->query($sql);
                            foreach($categories as $category)
                            {
                            echo("<option value=".$category['category_name'].">".$category['category_name']."</option>");
                            }
                        ?>     
                    </select>
                </label>
                <br> <br>
                <label for="usd">Event Start Date:- 
                <input type="date" name="usd" id="usd" size="100" min="<?php echo date("Y-m-d");?>" value="<?php echo $row['event_startdate']?>" >
                </label>
                <br> <br>
                <label for="ued">Event End Date:- 
                <input type="date" name="ued" id="ued" size="100" min="<?php echo date("Y-m-d");?>"  value="<?php echo $row['event_enddate']?>">
                </label>
                <br> <br>
                <input type="submit" name="update_event" id="update_event" >
                <input type='hidden' name='update_id' id='update_id' value="<?php echo $row['event_id'];?>">
        
        
    </form>
    <form action='deleteevents.php' method='post'>
                <input type='hidden' name='delete_id' value="<?php echo $row['event_id'];?>" >
                <input type='submit'value = 'Delete' name='delete'>
        </form> 
    </form>
    <?php
    }
    ?>
            </fieldset>   
        </div>
    </div>
</section>
<script src="script.js"></script>
</body>
</html>