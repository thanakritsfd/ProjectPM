<?php
require "./../../model/value_Sensor.php";

// สร้าง connection ไปยังฐานข้อมูล
$conn = new mysqli("localhost", "root", "123456789", "pm_db");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// รับวันที่จาก URL
$startDate = $_GET['start_date'] ?? ''; // เช่น '2023-09-09'
$endDate = $_GET['end_date'] ?? ''; // เช่น '2023-09-14'

// แปลงวันที่เพื่อป้องกัน SQL Injection
$startDate = $conn->real_escape_string($startDate);
$endDate = $conn->real_escape_string($endDate);

// สร้าง object จากคลาส Value_Sensor
$valueSensor = new Value_Sensor($conn);

// เรียกใช้เมธอด getLogValue เพื่อดึงข้อมูล
$stmt = $valueSensor->getLogValue($startDate, $endDate);

// ตรวจสอบจำนวนแถว
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    // แสดงผลข้อมูล
    while ($row = $result->fetch_assoc()) {
      echo "<tr><td>".$row["No"]."</td><td>".$row["PM"]."</td><td>".$row["Temperature"]."</td><td>".$row["Humidity"]."</td><td>".$row["Air_Pressure"]."</td><td>".$row["Wind_Speed"]."</td><td>".$row["Wind_Direction"]."</td><td>".$row["AQI"]."</td><td>".$row["Reading_Time"]."</td></tr>";
    }
} else {
    echo "No data";
}

// ปิดการเชื่อมต่อ
$conn->close();

?>