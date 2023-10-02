<?php
include("studentsheader.php");
$connection = new mysqli("localhost", "root", "", "eventful");

$selectsql = "SELECT * FROM `students_profile` WHERE email='$email'";

if ($connection->connect_errno != 0) {
    die("Database Connectivity Error");
}

$result = mysqli_query($connection, $selectsql);

if ($result) {
    // Fetch the result into an associative array
    $row = $result->fetch_assoc();

    // Check if the 'interests' column exists in the result
    if (isset($row['interests'])) {
        // Explode the interests string into an array using a delimiter (e.g., comma)
        $interestsArray = explode(',', $row['interests']);

        // Trim each element to remove leading/trailing whitespaces
        $interestsArray = array_map('trim', $interestsArray);

        // Now, $interestsArray contains individual interests
        // You can access them like $interestsArray[0], $interestsArray[1], etc.

        // Example: Display interests
        foreach ($interestsArray as $index => $interest) {
            echo "<p>Interest " . ($index + 1) . ": $interest</p>";
            $sql = "SELECT * FROM `events WHERE event_category='$interest';";
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
                        </tr>
                    ";
                }
            }
        }
    } else {
        echo "No interests found.";
    }
} else {
    echo "Error: " . mysqli_error($connection);
}

// Close the database connection
$connection->close();
?>
