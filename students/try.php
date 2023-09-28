<?php
$data = array(
    5 => 40,   // 40 data points with a value of 5
    4.5 => 30, // 30 data points with a value of 4.5
    4 => 20,   // 20 data points with a value of 4
    1 => 10    // 10 data points with a value of 1
);

$totalSum = 0;   // Total sum of data points
$totalCount = 0; // Total count of data points

foreach ($data as $value => $count) {
    $totalSum += $value * $count;
    $totalCount += $count;
    $average = $totalSum / $totalCount;
    echo "Data: $value, Count: $count, Running Average: $average<br>";
}?>
