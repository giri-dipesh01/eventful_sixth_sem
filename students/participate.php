<?php
include("studentsheader.php");
// Establish a database connection
$connection = new mysqli("localhost", "root", "", "eventful");
if ($connection->connect_errno != 0) {
    die("Connection failed");
}
if (isset($_POST['participate'])) {
    $event_id = $_POST['event_id'];
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];

    
    if (isset($_SESSION['students'])) {
        $row = $_SESSION['students'];
        $email = $row['email'];
    } else {
        die("Session data not found");
    }

    // Check if the student has already reviewed the event
    $sql_check_review = "SELECT * FROM participation WHERE event_id = ? AND student_email = ?";
    $stmt_check_review = $connection->prepare($sql_check_review);

    if ($stmt_check_review) {
        $stmt_check_review->bind_param('ss', $event_id, $email);
        $stmt_check_review->execute();
        $result_check_review = $stmt_check_review->get_result();

        if ($result_check_review->num_rows > 0) {
            // The student has already reviewed this event
            echo "<br><br><br>You have already reviewed this event. Your Rating: $rating"."<br>";
            
            // Fetch and display event details
            $sql_fetch_event = "SELECT * FROM events WHERE event_id = ?";
            $stmt_fetch_event = $connection->prepare($sql_fetch_event);

            if ($stmt_fetch_event) {
                $stmt_fetch_event->bind_param('s', $event_id);
                $stmt_fetch_event->execute();
                $result_fetch_event = $stmt_fetch_event->get_result();

                if ($result_fetch_event->num_rows > 0) {
                    while ($event_row = $result_fetch_event->fetch_assoc()) {
                        // Display event details
                        echo "<div class='event-details'>";
                        echo "<h2 class='event-title'>".$event_row['event_name']."</h2>";
                        echo "<p class='event-description'>".$event_row['event_description']."</p>";
                        echo "<p class='event-organizer'>Organizer: ".$event_row['event_organizers']."</p>";
                        echo "<p class='event-date'>Start Date: ".$event_row['event_startdate']."</p>";
                        echo "<p class='event-date'>End Date: ".$event_row['event_enddate']."</p>";
                        echo "<p class='event-category'>Category: ".$event_row['event_category']."</p>";
                        echo "</div>"; // event-details
                    }
                } else {
                    echo "Event details not found.";
                }

                $stmt_fetch_event->close();
            } else {
                echo "Error preparing statement for fetching event details: " . $connection->error;
            }
        } else {
            // The student has not reviewed this event, so insert the review
            $sql_insert_review = "INSERT INTO participation (event_id, student_email, rating,comment) VALUES (?, ?, ?,?)";
            $stmt_insert_review = $connection->prepare($sql_insert_review);

            if ($stmt_insert_review) {
                $stmt_insert_review->bind_param('ssds', $event_id, $email, $rating,$comment);

                if ($stmt_insert_review->execute()) {
                    echo "Review recorded successfully. Your Rating: $rating";
                    
                    // Fetch and display event details
                    $sql_fetch_event = "SELECT * FROM events WHERE event_id = ?";
                    $stmt_fetch_event = $connection->prepare($sql_fetch_event);

                    if ($stmt_fetch_event) {
                        $stmt_fetch_event->bind_param('s', $event_id);
                        $stmt_fetch_event->execute();
                        $result_fetch_event = $stmt_fetch_event->get_result();

                        if ($result_fetch_event->num_rows > 0) {
                            while ($event_row = $result_fetch_event->fetch_assoc()) {
                                // Display event details
                                echo "<div class='event-details'>";
                                echo "<h2 class='event-title'>".$event_row['event_name']."</h2>";
                                echo "<p class='event-description'>".$event_row['event_description']."</p>";
                                echo "<p class='event-organizer'>Organizer: ".$event_row['event_organizers']."</p>";
                                echo "<p class='event-date'>Start Date: ".$event_row['event_startdate']."</p>";
                                echo "<p class='event-date'>End Date: ".$event_row['event_enddate']."</p>";
                                echo "<p class='event-category'>Category: ".$event_row['event_category']."</p>";
                                echo "</div>"; // event-details
                            }
                        } else {
                            echo "Event details not found.";
                        }

                        $stmt_fetch_event->close();
                    } else {
                        echo "Error preparing statement for fetching event details: " . $connection->error;
                    }
                } else {
                    echo "Error recording review: " . $stmt_insert_review->error;
                }

                $stmt_insert_review->close();
            } else {
                echo "Error preparing statement for review: " . $connection->error;
            }
        }

        $stmt_check_review->close();
    } else {
        echo "Error preparing statement for review check: " . $connection->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<style>
    /* Your existing styles... */

    /* Add new styles for the event cards */
    .event-card {
        border: 1px solid #ccc;
        padding: 20px;
        display: flex;
        flex-direction: column;
        background-color: #f7f7f7;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s, box-shadow 0.2s;
        margin-bottom: 20px;
    }

    .event-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
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

    .event-organizer,
    .event-date,
    .event-category {
        margin: 5px 0;
    }

    .participate-form {
        display: flex;
        align-items: center;
    }

    .rating-label {
        margin-right: 10px;
    }

    .rating-input {
        width: 40px;
    }

    .participate-button {
        background-color: #9784bb;
        color: white;
        border: none;
        padding: 5px 10px;
        cursor: pointer;
        transition: background-color 0.2s;
    }

    .participate-button:hover {
        background-color: #7767a4;
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
        </div>
        
        <!-- Event Information -->
<div class="event-container">
    <?php
    if (isset($_POST['interest'])) 
    {
        $event_id = $_POST['event_id'];
        $sql = "SELECT * FROM events WHERE event_id='$event_id'";
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
                echo "<p class='event-description'>".$row['event_description']."</p>";
                echo "<p class='event-organizer'>Organizer: ".$row['event_organizers']."</p>";
                echo "<p class='event-date'>Start Date: ".$row['event_startdate']."</p>";
                echo "<p class='event-date'>End Date: ".$row['event_enddate']."</p>";
                echo "<p class='event-category'>Category: ".$row['event_category']."</p>";

                // Form for participating and rating
                echo "<form action='participate.php' method='post'>";
                echo "<input type='hidden' name='event_id' value='".$row['event_id']."'>";
                echo"Comment <br><textarea name='comment' rows='4' cols='100'></textarea><br><br>";
                echo "<label for='rating'>Rate the Event-  </label>";
                echo "<input type='number' name='rating' min='1' max='5' required> <br>";
                echo "<input type='submit' name='participate' value='Participate'> <br>";
                echo "</form>";

                echo "</div>"; // event-details
                echo "</div>"; // event-card
            }
        }
    }
    ?>
</div>
        
    </div>
    </section>
    <script src="script.js"></script>
</body>
</html>