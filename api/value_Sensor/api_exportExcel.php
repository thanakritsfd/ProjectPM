<?php
require './../../vendor/autoload.php';
require "./../../model/value_Sensor.php";

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

$startDate = $_GET['start_date'] ?? '';
$endDate = $_GET['end_date'] ?? '';

// สร้างฟังก์ชันสำหรับสร้างและส่งไฟล์ Excel
function generateAndSendExcel($stmt)
{
    // Create Spreadsheet
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setCellValue('A1', 'No');
    $sheet->setCellValue('B1', 'PM');
    $sheet->setCellValue('C1', 'Temperature');
    $sheet->setCellValue('D1', 'Humidity');
    $sheet->setCellValue('E1', 'Air Pressure');
    $sheet->setCellValue('F1', 'Wind Speed');
    $sheet->setCellValue('G1', 'Wind Direction');
    $sheet->setCellValue('H1', 'AQI');
    $sheet->setCellValue('I1', 'Date & Time');

    $rowNumber = 2;
    while ($row = $stmt->fetch_assoc()) { // เปลี่ยนจาก fetch_assoc() เป็น get_result()
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

    // Save Excel file
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
}

// ตรวจสอบว่ามีการรับค่า startDate และ endDate หรือไม่
if (!empty($startDate) && !empty($endDate)) {
    // สร้าง connection ไปยังฐานข้อมูล
    $conn = new mysqli("localhost", "root", "123456789", "pm_db");

    // แปลงวันที่เพื่อป้องกัน SQL Injection
    $startDate = $conn->real_escape_string($startDate);
    $endDate = $conn->real_escape_string($endDate);

    // ตรวจสอบว่า connection เชื่อมต่อได้หรือไม่
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // สร้าง object จากคลาส Value_Sensor และใช้งานฟังก์ชัน exportLogValue
    $valueSensor = new Value_Sensor($conn);
    $stmt = $valueSensor->exportLogValue($startDate, $endDate);

    // เรียกใช้ฟังก์ชันสร้างและส่งไฟล์ Excel
    generateAndSendExcel($stmt->get_result()); // เรียกใช้ get_result() เพื่อรับผลลัพธ์ในรูปแบบของ mysqli_result

    // ปิด connection หลังใช้งานเสร็จสิ้น
    $conn->close();
} else {
    echo "Please provide startDate and endDate parameters.";
}
?>
