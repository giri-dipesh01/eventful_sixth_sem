<?php
include("adminheader.php");
$connection = new mysqli("localhost", "root", "", "eventful");
if ($connection->connect_errno != 0) {
    die("Connection failed");
}

$sql = "SELECT 
            p.`participation_id`, 
            s.`full_name` AS student_name, 
            s.`batch`,
            p.`rated_date`, 
            p.`participation_status`, 
            e.`event_name`, 
            e.`event_organizers`, 
            CONCAT(e.`event_startdate`, ' ', e.`event_enddate`) AS event_date, 
            p.`rating`, 
            p.`comment`
        FROM 
            `participation` p
        INNER JOIN 
            `students` s ON p.`student_email` = s.`email`
        INNER JOIN 
            `events` e ON p.`event_id` = e.`event_id`";
?>

<section class="dashboard">
    <div class="top">
        <i class="uil uil-bars sidebar-toggle"></i>
        <img src="images/profile.jpg" alt="">
    </div>

    <div class="dash-content">
        <div class="overview">
        </div>
            <div class="activity">
                <div class="title">
                    <i class="uil uil-clock-three"></i>
                    <span class="text">List of Reviews</span> 
                </div>
            </div>
    </div>
     <!-- Review Information -->
     <table border='1' width="100%">
        <tr>
            <th style="width:1%">#</th>
            <th style="width:20%">Name</th>
            <th style="width:10%">Event Organizers</th>
            <th style="width:5%">Event Date</th>
            <th style="width:10%">Rated Date</th>
            <th style="width:5%">Rating</th>
            <th style="width:5%">Rating Status</th>
            <th style="width:25%">Student(Batch)</th>
            <th>Action</th> 
        </tr>
        <?php
                $i = 1;

                if ($result = $connection->query($sql)) {
                    while ($row = $result->fetch_assoc()) {
                        echo
                        "
                            <tr>
                                <td>" . $i++ . "</td>
                                <td>" . $row['event_name'] . "</td>
                                <td>" . $row['event_organizers'] . "</td>
                                <td>" . $row['event_date'] . "</td>
                                <td>" . $row['rated_date'] . "</td>
                                <td>" . $row['rating'] . "</td>
                                <td>" . $row['participation_status'] . "</td>
                                <td>" . $row['student_name'] . " (" . $row['batch'] . ")</td>
                                <td>
                                    <form action='updatereviews.php' method='post'>
                                        <input type='hidden' value='" . $row['participation_id'] . "' name='participation_id'>
                                        <input type='submit' value='View' name='review_update'>
                                    </form>  
                                </td>           
                            </tr>
                        ";
                    }
                }
                ?>
        <tr>
            <th style="width:1%">#</th>
            <th style="width:15%">Name</th>
            <th style="width:10%">Event Organizers</th>
            <th style="width:10%">Event Date</th>
            <th style="width:10%">Rated Date</th>
            <th style="width:5%">Rating</th>
            <th style="width:5%">Rating Status</th>
            <th style="width:25%">Student(Batch)</th>
            <th>Action</th> 
        </tr>    
    </table>
</section>
<script src="script.js"></script>
</body>
</html>
