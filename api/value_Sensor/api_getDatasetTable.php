<?php
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

// รับวันที่จาก URL
$startDate = $_GET['start_date']; // เช่น '2023-09-09'
$endDate = $_GET['end_date']; // เช่น '2023-09-14'

// แปลงวันที่เพื่อป้องกัน SQL Injection
$startDate = $conn->real_escape_string($startDate);
$endDate = $conn->real_escape_string($endDate);

$sql = "SELECT ROW_NUMBER() OVER (ORDER BY Reading_Time) No, PM, Temperature, Humidity, Air_Pressure, Wind_Speed, Wind_Direction,
CASE
    WHEN AVG_PM <= 15 THEN ROUND((((25 - 0)/(15 - 0))*(AVG_PM - 0)) + 0)
    WHEN AVG_PM <= 25 THEN ROUND((((50 - 26)/(25 - 15.1))*(AVG_PM - 15.1)) + 26)
    WHEN AVG_PM <= 37.5 THEN ROUND((((100 - 51)/(37.5 - 25.1))*(AVG_PM - 25.1)) + 51)
    WHEN AVG_PM <= 75 THEN ROUND((((200 - 101)/(75 - 37.6))*(AVG_PM - 37.6)) + 101)
    ELSE ROUND((((10000000 - 200)/(10000000 - 75.1))*(AVG_PM - 75.1)) + 200)
END as AQI,
UNIX_TIMESTAMP(Reading_Time) AS Unix FROM value_tb WHERE PM<>0 AND Humidity<>0 AND Air_Pressure<>0 AND  Reading_Time BETWEEN '$startDate 00:00:00' AND '$endDate 23:59:59'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    echo "<tr><td>".$row["No"]."</td><td>".$row["PM"]."</td><td>".$row["Temperature"]."</td><td>".$row["Humidity"]."</td><td>".$row["Air_Pressure"]."</td><td>".$row["Wind_Speed"]."</td><td>".$row["Wind_Direction"]."</td><td>".$row["AQI"]."</td><td>".$row["Unix"]."</td></tr>";
  }
} else {
  return "";
}
$conn->close();
?>