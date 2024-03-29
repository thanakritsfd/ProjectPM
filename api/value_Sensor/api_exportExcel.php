<?php
require './../../vendor/autoload.php'; // ปรับเส้นทางไปยัง autoload.php ตามที่คุณติดตั้ง PhpSpreadsheet

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
 DATE_FORMAT(Reading_Time, '%d/%m/%Y %H:%i') AS Reading_Time FROM value_tb WHERE PM<>0 AND Humidity<>0 AND Air_Pressure<>0 AND Reading_Time BETWEEN '$startDate 00:00:00' AND '$endDate 23:59:59'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // สร้าง Spreadsheet
    $spreadsheet = new Spreadsheet();

    // เพิ่มข้อมูลลงในหน้างาน
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setCellValue('A1', 'No');
    $sheet->setCellValue('B1', 'PM');
    $sheet->setCellValue('C1', 'Temperature');
    $sheet->setCellValue('D1', 'Humidity');
    $sheet->setCellValue('E1', 'Air Pressure');
    $sheet->setCellValue('F1', 'Wind Speed');
    $sheet->setCellValue('G1', 'Wind Direction');
    $sheet->setCellValue('H1', 'Wind Direction');
    $sheet->setCellValue('I1', 'Date & Time');

    $rowNumber = 2;
    while ($row = $result->fetch_assoc()) {
        $sheet->setCellValue('A' . $rowNumber, $row["No"]);
        $sheet->setCellValue('B' . $rowNumber, $row["PM"]);
        $sheet->setCellValue('C' . $rowNumber, $row["Temperature"]);
        $sheet->setCellValue('D' . $rowNumber, $row["Humidity"]);
        $sheet->setCellValue('E' . $rowNumber, $row["Air_Pressure"]);
        $sheet->setCellValue('F' . $rowNumber, $row["Wind_Speed"]);
        $sheet->setCellValue('G' . $rowNumber, $row["Wind_Direction"]);
        $sheet->setCellValue('H' . $rowNumber, $row["AQI"]);
        $sheet->setCellValue('I' . $rowNumber, $row["Reading_Time"]);
        $rowNumber++;
    }

    // บันทึกไฟล์ Excel
    $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
    $filename = 'exported_data.xlsx';
    $writer->save($filename);

    // ส่งไฟล์ Excelให้ผู้ใช้ดาวน์โหลด
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    readfile($filename);

    // ลบไฟล์ Excel หลังจากส่งเสร็จ
    unlink($filename);
} else {
    echo "ไม่มีข้อมูลที่สอดคล้องกับเงื่อนไขที่ระบุ.";
}

$conn->close();
?>