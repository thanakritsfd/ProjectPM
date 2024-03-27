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

$sql = "SELECT 
            ID,
            ROW_NUMBER() OVER (ORDER BY Reading_Time) AS No, 
            PM, 
            Temperature, 
            Humidity, 
            Air_Pressure, 
            Wind_Speed, 
            Wind_Direction,
            CASE
                WHEN AVG_PM <= 15 THEN ROUND((((25 - 0)/(15 - 0))*(AVG_PM - 0)) + 0)
                WHEN AVG_PM <= 25 THEN ROUND((((50 - 26)/(25 - 15.1))*(AVG_PM - 15.1)) + 26)
                WHEN AVG_PM <= 37.5 THEN ROUND((((100 - 51)/(37.5 - 25.1))*(AVG_PM - 25.1)) + 51)
                WHEN AVG_PM <= 75 THEN ROUND((((200 - 101)/(75 - 37.6))*(AVG_PM - 37.6)) + 101)
                ELSE ROUND((((10000000 - 200)/(10000000 - 75.1))*(AVG_PM - 75.1)) + 200)
            END as AQI,
            DAYOFWEEK(Reading_Time) DW,
            day(Reading_Time) Day,
            month(Reading_Time) Month,
            year(Reading_Time) Year,
            hour(Reading_Time) Time,
            DATE_FORMAT(Reading_Time, '%Y-%m-%d') AS Formatted_Reading_Time,
            CASE
                WHEN AVG_PM <= 15 THEN '5'
                WHEN AVG_PM <= 25 THEN '4'
                WHEN AVG_PM <= 37.5 THEN '3'
                WHEN AVG_PM <= 75 THEN '2'
                ELSE '1'
            END AS Status,
            CASE
                WHEN AVG_PM <= 15 THEN 'Very Good'
                WHEN AVG_PM <= 25 THEN 'Good'
                WHEN AVG_PM <= 37.5 THEN 'Mid'
                WHEN AVG_PM <= 75 THEN 'Bad'
                ELSE 'Very Bad'
            END AS Status_Nom
            FROM 
            value_tb 
            WHERE 
            PM<>0 AND Humidity<>0 AND Air_Pressure<>0 
            AND AVG_PM IS NOT NULL AND Reading_Time BETWEEN STR_TO_DATE('20231122 21:49:00', '%Y%m%d %H:%i:%s') AND '$endDate 23:59:59'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Create CSV file
    $filename = 'exported_data.csv';
    $fp = fopen($filename, 'w');

    // Add CSV headers
    fputcsv($fp, ['ID', 'No', 'PM', 'Temperature', 'Humidity', 'Air_Pressure', 'Wind_Speed', 'Wind_Direction', 'AQI', 'DW', 'Day', 'Month', 'Year', 'Time', 'Formatted_Reading_Time', 'Status', 'Status_Nom']);

    while ($row = $result->fetch_assoc()) {
        // Write data to CSV
        fputcsv($fp, [$row["ID"], $row["No"], $row["PM"], $row["Temperature"], $row["Humidity"], $row["Air_Pressure"], $row["Wind_Speed"], $row["Wind_Direction"], $row["AQI"], $row["DW"], $row["Day"], $row["Month"], $row["Year"], $row["Time"], $row["Formatted_Reading_Time"], $row["Status"], $row["Status_Nom"]]);
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
