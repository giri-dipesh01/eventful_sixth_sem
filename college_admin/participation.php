<?php
include("adminheader.php");  
?>
<style>
    fieldset {
        border: none;
        padding: 0;
        margin-bottom: 20px;
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
                <span class="text">View Participation</span> 
            </div>
            <fieldset>
                <table border='1' width="100%">
        <tr>
            <th style="width:1%">#</th>
            <th style="width:20%">Event Name</th>
            <th style="width:20%">Date</th>
            <th style="width:10%">Organizer</th>
            <th style="width:20%">Category</th>
            <th style="width:30%">Student Name</th>
            <th style="width:10%">Semester</th>
            <th>Action</th>
        </tr>
        <?php
            $connection = new mysqli("localhost", "root", "", "eventful");
                if ($connection->connect_errno != 0) {
                die("Connection failed");
                }

            $sql = "SELECT * FROM events";
            $i = 1;
            if ($result = $connection->query($sql)) {
            $i = 1; // Initialize a counter for the table rows

            while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>".$i++."</td>";
            echo "<td>";

            if ($row['event_banner'] != '') {
                echo "<img class='profile-pic' src='".$row['event_banner']."' width='160px' height='90px'>";
            } else {
                echo "<img class='profile-pic' src='../banners/default.png' width='160px' height='90px'>";
            }

            echo "</td>";
            echo "<td>".$row['event_name']."</td>";
            echo "<td>".$row['event_organizers']."</td>";
            echo "<td>".$row['event_startdate']."</td>";
            echo "<td>".$row['event_enddate']."</td>";
            echo "<td>".$row['event_category']."</td>";
            echo "<td>
                    <form action='updateevents.php' method='post'>
                        <input type='hidden' value='".$row['event_id']."' name='event_updateid'>
                        <input type='submit' value='View' name='update'>
                    </form>
                </td>";
            echo "</tr>";
            }
        }
        ?>        
        <tr>
            <th style="width:1%">#</th>
            <th style="width:20%">Event Name</th>
            <th style="width:20%">Date</th>
            <th style="width:20%">Organizer</th>
            <th style="width:10%">Category</th>
            <th style="width:30%">Student Name</th>
            <th style="width:10%">Semester</th>
            <th>Action</th>
        </tr>   
    </table>
        </div>
    </div>
</section>
<script src="script.js"></script>
</body>
</html>