<?php
include("studentsheader.php");

// Establish a database connection
$connection = new mysqli("localhost", "root", "", "eventful");
if ($connection->connect_errno != 0) {
    die("Connection failed");
}

// Fetch events data from the database
$sql = "SELECT * FROM events";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Cards</title>
    
    <style>
        /* Your existing styles here... */

        /* Add new styles for the grid layout */
        .event-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr); /* Display three columns */
            gap: 20px; /* Add some gap between event items */
        }

        .event-card {
            border: 1px solid #ccc;
            padding: 20px;
            display: flex;
            flex-direction: column;
        }

        .event-banner img {
            max-width: 100%;
            height: auto;
        }

        .event-title {
            font-size: 1.5rem;
            margin: 10px 0;
        }

        .event-description {
            margin: 10px 0;
        }

        .event-date {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="dash-content">
        <div class="overview">
            <div class="title">
                <i class="uil uil-tachometer-fast-alt"></i>
                <span class="text">Events</span> <br>    
            </div>
            <!-- New event container with grid layout -->
            <div class="event-container">
                <?php
                if ($result = $connection->query($sql)) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<div class='event-card'>";
                        echo "<div class='event-banner'>";
                        if ($row['event_banner'] != '') {
                            echo "<img src='".$row['event_banner']."' alt='Event Banner'>";
                        } else {
                            echo "<img src='../banners/default.png' alt='Default Banner'>";
                        }
                        echo "</div>";
                        echo "<div class='event-details'>";
                        echo "<h2 class='event-title'>".$row['event_name']."</h2>";
                        echo "<p class='event-description'>".$row['event_description']."</p> <br>";
                        echo "<p class='event-date'>Start Date: ".$row['event_startdate']."</p><br>";
                        echo "<p class='event-date'>End Date: ".$row['event_enddate']."</p><br>";
                        echo "<p class='event-organizer'>Organizer: ".$row['event_organizers']."</p>";
                        echo "<form action='participate.php' method='post'> <br>"; 
                        echo "<input type='hidden' value='".$email."' name='student_id'>";
                        echo "<input type='hidden' value='".$row['event_id']."' name='event_id'>";
                        echo "<input type='submit' value='View' name='interest'>";
                        echo "</form>";
                        echo "</div>";
                        echo "</div>";
                    }
                }
                ?>
            </div>
        </div>
    </div>
    </section>
    <script src="script.js"></script>
</body>
</html>