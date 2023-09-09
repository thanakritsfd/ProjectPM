<?php
header("Access-control-allow-origin: *");
header("content-type: application/json; charset=UTF-8");

include_once "./../../databaseconnect.php";
include_once "./../../model/value_Sensor.php";

$databaseConnect = new DatabaseConnect();
$connDB = $databaseConnect->getConnection();

$value_Sensor = new value_Sensor($connDB);

//สร้างตัวแปรเก็บค่าของข้อมูลที่ส่งมาซึ่งเป็น JSON ที่ทำการ decode แล้ว
$data = json_decode(file_get_contents("php://input"));

//เอาข้อมูลที่ถูก Decode ไปเก็บในตัวแปร
$value_Sensor->PM = $data->PM;
$value_Sensor->Temperature = $data->Temperature;
$value_Sensor->Humidity = $data->Humidity;
$value_Sensor->Air_Pressure = $data->Air_Pressure;
$value_Sensor->Wind_Speed = $data->Wind_Speed;
$value_Sensor->Wind_Direction = $data->Wind_Direction;

//เรียกใช้ Function ตามวัตถุประสงค์ของ API ตัวนี้
if($stmt = $value_Sensor->insertValue()){
    //บันทึกข้อมูลสำเร็จ
   http_response_code(200);
   echo json_encode(array("message"=>"1")); 
}else{
    //บันทึกข้อมูลไม่สำเร็จ
    http_response_code(200);
    echo json_encode(array("message"=>"0"));     
}