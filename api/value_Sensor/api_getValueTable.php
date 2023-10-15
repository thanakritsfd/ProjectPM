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

$sql = "SELECT ROW_NUMBER() OVER (ORDER BY Reading_Time) No, PM, Temperature, Humidity, Air_Pressure, Wind_Speed, Wind_Direction, DATE_FORMAT(Reading_Time, '%d/%m/%Y %H:%i') AS Reading_Time FROM value_tb WHERE Reading_Time BETWEEN '$startDate 00:00:00' AND '$endDate 23:59:59'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    echo "<tr><td>".$row["No"]."</td><td>".$row["PM"]."</td><td>".$row["Temperature"]."</td><td>".$row["Humidity"]."</td><td>".$row["Air_Pressure"]."</td><td>".$row["Wind_Speed"]."</td><td>".$row["Wind_Direction"]."</td><td>".$row["Reading_Time"]."</td></tr>";
  }
} else {
  // echo "0 Results";
}
$conn->close();
?>