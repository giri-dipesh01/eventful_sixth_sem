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
                <div class="card-container">
                    <?php
                    $sql="SELECT * FROM events ORDER BY event_startdate ASC";
                    $result=$connection->query($sql);
                    foreach($result as $row)
                    {
                        echo("
                        <div class='card'>
                        <img src='Images/logo2.png' alt='Avatar' style='width:100%'>
                        <div class='container'>
                        <h4><b>".$row['event_name']."</b></h4> 
                        <h4>Event Category: <b>".$row['event_category']."</b></h4>
                        <h4>Event Date: <b>".$row['event_startdate']." - ".$row['event_enddate']."</b></h4> 
                        <h4>Event Organizers: <b>".$row['event_organizers']."</b></h4>
                        </div>

                        <form action='updateevents.php' method='post'>
                        <input type='submit' name='view' value='View'>
                        <input type='hidden' name='eid' id='eid' value=".$row['event_id'].">
                        </form>
                        </div>
                        ");
                    }
                    ?> 
                </div>
            </fieldset>
        </div>
    </div>
</section>
<script src="script.js"></script>
</body>
</html>