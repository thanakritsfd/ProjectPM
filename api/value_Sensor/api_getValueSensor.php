<?php
header("Access-control-allow-origin: *");
header("content-type: application/json; charset=UTF-8");//ทำให้ไม่อ่าน html

// include_once "databaseconnect.php";
// include_once "model/value_Sensor.php";
include_once "./../../databaseconnect.php";
 include_once "./../../model/value_Sensor.php"; //พอ include หรือ Require ไปใช้ต้องเปลี่ยน พาท

$databaseConnect = new DatabaseConnect();
$connDB = $databaseConnect->getConnection();

$value_Sensor = new value_Sensor($connDB);

//เรียกใช้ Function ตามวัตถุประสงค์ของ API ตัวนี้
$stmt = $value_Sensor->getValueSensor();

//นับแถวเพื่อดูว่าได้ข้อมูลมาไหม 
$numrow = $stmt->rowCount();

//สร้างตัวแปรมาเก็บข้อมูลที่ได้จากการเรียกใช้ function เพื่อส่งกับไปยังส่วนที่เรียกใช้ API
$value_Sensor_arr = array();

//ตรวจสอบผล และส่งกลับไปยังส่วนที่เรียกใช้ API
if ($numrow > 0) {
    //มีข้อมูล เอาข้อมูลใสาตัวแปร และเตรียมส่งกลับ
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $value_Sensor_item = array(
            "message" => "1",  
            "PM" => $PM,
            "Temperature" => $Temperature,
            "Humidity" => $Humidity,
            "Air_Pressure" => $Air_Pressure,
            "Wind_Speed" => $Wind_Speed,
            "Wind_Direction" => $Wind_Direction,
            "AQI" => $AQI,
        );

        array_push($value_Sensor_arr, $value_Sensor_item);
    }
} else {
    //ไม่มีข้อมูล เอาข้อมูลใสาตัวแปร และเตรียมส่งกลับ
    $value_Sensor_item = array(
        "massage" => "0"
    );
        array_push($value_Sensor_arr, $value_Sensor_item);
}

//คำสั่งจัดการข้อมูลให้เป็น JSON เพื่อส่งกลับ
http_response_code(200);
echo json_encode($value_Sensor_arr[0]);
// $data = json_encode($value_Sensor_arr);
// $value_Sensor_arr = json_decode($data);

    // $pmValue = $value_Sensor_arr[0]->PM;
    // $tempValue = $value_Sensor_arr[0]->Temperature;
    // $humidValue = $value_Sensor_arr[0]->Humidity;
    // $airValue = $value_Sensor_arr[0]->Air_Pressure;
    // $speedValue = $value_Sensor_arr[0]->Wind_Speed;
    // $windValue = $value_Sensor_arr[0]->Wind_Direction;
