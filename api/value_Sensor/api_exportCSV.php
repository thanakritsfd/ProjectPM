<?php
require './../../vendor/autoload.php'; // Adjust the path to autoload.php as per your PhpSpreadsheet installation

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

$servername = "localhost";
$username = "root";
$password = "123456789";
$dbname = "pm_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Receive dates from URL
$startDate = $_GET['start_date']; // e.g., '2023-09-09'
$endDate = $_GET['end_date']; // e.g., '2023-09-14'

// Escape dates to prevent SQL Injection
$startDate = $conn->real_escape_string($startDate);
$endDate = $conn->real_escape_string($endDate);

$sql = "SELECT ROW_NUMBER() OVER (ORDER BY Reading_Time) No, PM, Temperature, Humidity, Air_Pressure, Wind_Speed, Wind_Direction,
    CASE
        WHEN AVG_PM < 16 THEN ROUND((((25 - 0)/(15 - 0))*(AVG_PM - 0)) + 0)
        WHEN AVG_PM < 26 THEN ROUND((((50 - 26)/(25 - 15.1))*(AVG_PM - 15.1)) + 26)
        WHEN AVG_PM < 37.6 THEN ROUND((((100 - 51)/(37.5 - 25.1))*(AVG_PM - 25.1)) + 51)
        WHEN AVG_PM < 76 THEN ROUND((((200 - 101)/(75 - 37.6))*(AVG_PM - 37.6)) + 101)
        ELSE ROUND((((10000000 - 200)/(10000000 - 75.1))*(AVG_PM - 75.1)) + 200)
    END as AQI,
    UNIX_TIMESTAMP(Reading_Time) AS Unix
    FROM value_tb WHERE PM<>0 AND Humidity<>0 AND Air_Pressure<>0 AND Reading_Time BETWEEN '$startDate 00:00:00' AND '$endDate 23:59:59'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Create CSV file
    $filename = 'exported_data.csv';
    $fp = fopen($filename, 'w');

    // Add CSV headers
    fputcsv($fp, ['No', 'PM', 'Temperature', 'Humidity', 'Air Pressure', 'Wind Speed', 'Wind Direction', 'AQI', 'Date & Time']);

    while ($row = $result->fetch_assoc()) {
        // Write data to CSV
        fputcsv($fp, [$row["No"], $row["PM"], $row["Temperature"], $row["Humidity"], $row["Air_Pressure"], $row["Wind_Speed"], $row["Wind_Direction"], $row["AQI"], $row["Unix"]]);
    }

    fclose($fp);

    // Send CSV file to user for download
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    readfile($filename);

    // Delete CSV file after sending
    unlink($filename);
} else {
    echo "No data matching the specified conditions.";
}

$conn->close();
?>
