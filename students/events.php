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

        /* New styles for the star rating */
        .star-rating {
            display: flex;
            align-items: center;
            margin-top: 10px;
        }

        .star {
            font-size: 1.5rem;
            color: #ccc; /* Empty star color */
            cursor: pointer;
        }

        .star.filled {
            color: goldenrod; /* Filled star color */
        }

        .reviews {
            margin-top: 5px;
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
                // Fetch event details and calculate average rating
                if ($result = $connection->query($sql)) {
                    while ($row = $result->fetch_assoc()) {
                        // Calculate the average rating
                        $event_id = $row['event_id'];
                        $sql_avg_rating = "SELECT AVG(rating) AS avg_rating, COUNT(*) AS review_count FROM participation WHERE event_id = '$event_id' AND participation_status='Approved'";
                        $result_avg_rating = $connection->query($sql_avg_rating);
                        $row_avg_rating = $result_avg_rating->fetch_assoc();
                        $averageRating = $row_avg_rating['avg_rating'];
                        $reviewCount = $row_avg_rating['review_count'];

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

                        // Display the average rating as a number
                        echo "<p class='average-rating'>Average Rating: ".number_format($averageRating, 1)."</p>";

                        // Display the number of reviews
                        echo "<p class='reviews'>Number of Reviews: ".$reviewCount."</p>";

                        // Display the 5-star rating
                        echo "<div class='star-rating' data-rating='".$averageRating."'>";
                        for ($i = 1; $i <= 5; $i++) {
                            // Highlight stars based on the average rating
                            $starClass = ($i <= $averageRating) ? 'star filled' : 'star';
                            echo "<span class='".$starClass."' data-rating='".$i."'>★</span>";
                        }
                        echo "</div>";

                        // Add the form for viewing event details
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
    <script>
        // JavaScript code for handling star rating interactions
        const starContainers = document.querySelectorAll(".star-rating");

        starContainers.forEach((starContainer) => {
            const stars = starContainer.querySelectorAll(".star");
            let currentRating = starContainer.getAttribute("data-rating");

            stars.forEach((star) => {
                star.addEventListener("mouseover", () => {
                    const rating = star.getAttribute("data-rating");
                    highlightStars(stars, rating);
                });

                star.addEventListener("mouseout", () => {
                    highlightStars(stars, currentRating);
                });

                star.addEventListener("click", () => {
                    currentRating = star.getAttribute("data-rating");
                    starContainer.setAttribute("data-rating", currentRating);
                });
            });

            starContainer.addEventListener("mouseout", () => {
                highlightStars(stars, currentRating);
            });

            // Initial highlighting on page load
            highlightStars(stars, currentRating);
        });

        function highlightStars(stars, rating) {
            stars.forEach((star) => {
                const starRating = parseInt(star.getAttribute("data-rating"));
                if (starRating <= rating) {
                    star.classList.add("filled");
                } else {
                    star.classList.remove("filled");
                }
            });
        }
    </script>
</body>
</html>