<?php
include("adminheader.php");  
?>
<style>
    fieldset {
        border: none;
        padding: 0;
        margin-bottom: 20px;
    }
    .card-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: flex-start;
    }

    .card {
        flex: 0 0 calc(33.33% - 10px);
        margin: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        padding: 10px;
        box-sizing: border-box;
        width: 100%;
        margin-bottom: 20px;
    }

    .event-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
    }

    .card img {
        width: 100%;
        border-radius: 4px 4px 0 0;
    }

    .card .container {
        padding: 10px;
    }

    .card h4 {
        margin: 0;
        font-size: 16px;
        font-weight: bold;
    }

    .card b {
        font-weight: normal;
    }

    .card form {
        padding: 10px;
        text-align: right;
    }

    .card form input[type="submit"] {
        background-color: #9784bb;
        color: #fff;
        border: none;
        padding: 5px 10px;
        border-radius: 4px;
        cursor: pointer;
        text-decoration: none;
    }

    .card form input[type="submit"]:hover {
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
                <span class="text">View Events</span> 
            </div>
            <fieldset>
                <a href="insertevents.php"><button>New</button></a>
                <br> <br>
                <table border='1' width="100%">
        <tr>
            <th style="width:1%">#</th>
            <th style="width:20%">Name</th>
            <th style="width:20%">Organizer</th>
            <th style="width:10%">Start Date</th>
            <th style="width:10%">End Date</th>
            <th style="width:10%">Category</th>
            <th>Action</th> 
        </tr>
        <?php
            $connection = new mysqli("localhost","root","","eventful");
            if($connection->connect_errno != 0){
                die("Connection failed");
            }
            
            $sql = "SELECT * FROM events";
            $i = 1;
            if($result = $connection->query($sql))
            {
                while($row = $result->fetch_assoc())
                {
                    echo 
                    "
                        <tr>
                            <td>".$i++."</td>
                            <td>".$row['event_name']."</td>
                            <td>".$row['event_organizers']."</td>
                            <td>".$row['event_startdate']."</td>
                            <td>".$row['event_enddate']."</td>
                            <td>".$row['event_category']."</td>
                            <td>
                                <form action='updateevents.php' method='post'>
                                    <input type='hidden' value='".$row['event_id']."' name='event_updateid'>
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
            <th style="width:20%">Organizer</th>
            <th style="width:10%">Start Date</th>
            <th style="width:10%">End Date</th>
            <th style="width:10%">Category</th>
            <th>Action</th> 
        </tr>    
    </table>
        </div>
    </div>
</section>
<script src="script.js"></script>
</body>
</html>