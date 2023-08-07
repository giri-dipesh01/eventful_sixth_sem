<?php
include("adminheader.php");
    if(isset($_POST["event_entry"]))
        {
            $event_name=$_POST["event_name"]; 
            $event_description=$_POST["event_description"]; 
            $event_startdate=$_POST["event_startdate"]; 
            $event_enddate=$_POST["event_enddate"]; 
            $event_organizers=$_POST["event_organizers"]; 
            $event_category=$_POST["event_category"]; 
        
            $sql="INSERT INTO events(event_name,event_description,event_organizers,event_startdate,event_enddate,event_category) 
            VALUES ('$event_name','$event_description','$event_organizers','$event_startdate','$event_enddate','$event_category')";
        
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
    a button {
        background-color: #9784bb;
        color: #fff;
        border: none;
        padding: 5px 10px;
        border-radius: 4px;
        cursor: pointer;
        text-decoration: none;
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
            <a href="events.php"><button>View All Events</button></a>
            <br> <br>
            <fieldset>
            
            <legend> Insert Event</legend>
            
                <form action="insertevents.php" method="post">
                <label for="event_name">Event Name:- 
                    <input type="text" name="event_name" id="event_name" size="100" required>
                </label>
                <br> <br>
                <label for="event_category">Event Category:- 
                    <select name="event_category" id="event_category" required>
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
                <label for="event_description">Event Description:- 
                    <textarea name="event_description" id="event_description" cols="100" rows="5" required>
                    </textarea>
                </label>
                <br> <br>
                <label for="event_organizers">Event Organizer:- 
                    <select name="event_organizers" id="event_organizers" required>
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
                <label for="event_startdate">Event Start Date:- 
                    <input type="date" name="event_startdate" id="event_startdate" size="100" min="<?php echo date("Y-m-d"); ?>" required>
                </label>
                <br> <br>
                <label for="event_enddate">Event End Date:- 
                    <input type="date" name="event_enddate" id="event_enddate" size="100" min="<?php echo date("Y-m-d"); ?>" required>
                </label>
                <br> <br>
                <input type="submit" name="event_entry" id="event_entry" >
                </form>
            </fieldset>
        </div>
    </div>
</section>
<script src="script.js"></script>
</body>
</html>