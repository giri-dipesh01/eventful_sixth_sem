<?php
$connection = new mysqli("localhost", "root", "", "eventful");

// Checking Database Connection
if ($connection->connect_errno != 0) {
    die("Database Connectivity Error");
}

$event_id = 8;

// Fetch events data from the database
$sql = "SELECT rating FROM participation WHERE event_id='$event_id'";

if ($result = $connection->query($sql)) {
    $ratings = array(); // Initialize an array to store ratings

    while ($row = $result->fetch_assoc()) {
        $ratings[] = $row['rating']; // Store each rating in the array
    }

    // Display the ratings
    echo "Ratings: " . implode(', ', $ratings) . "<br>";

    // Display the count of members
    $memberCount = count($ratings);
    echo "Number of Members: $memberCount<br>";

    // Calculate the moving average
    if($memberCount==0)
    {
        $windowSize=1;
    }else{
    $windowSize =3;} // Adjust this value as needed
    $avg_rating=array_sum($ratings)/count($ratings);
    $movingAverage = calculateMovingAverage($ratings, $windowSize);

    // Display the moving average
    echo "Moving Average: " . implode(', ', $movingAverage);
    echo $avg_rating;
}

// Close the database connection
$connection->close();

// Function to calculate the moving average
function calculateMovingAverage($data, $windowSize)
{
    $movingAverage = array();

    for ($i = 0; $i < count($data) - $windowSize + 1; $i++) {
        $sum = array_sum(array_slice($data, $i, $windowSize));
        $average = $sum / $windowSize;
        $movingAverage[] = $average;
    }

    return $movingAverage;
}
?>
