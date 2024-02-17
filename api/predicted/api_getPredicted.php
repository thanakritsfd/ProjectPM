<?php
header("Access-control-allow-origin: *");
header("content-type: application/json; charset=UTF-8");//ทำให้ไม่อ่าน html

// include_once "databaseconnect.php";
// include_once "model/predicted.php";
include_once "./../../databaseconnect.php";
 include_once "./../../model/predicted.php"; //พอ include หรือ Require ไปใช้ต้องเปลี่ยน พาท

$databaseConnect = new DatabaseConnect();
$connDB = $databaseConnect->getConnection();

$predicted = new predicted($connDB);

//เรียกใช้ Function ตามวัตถุประสงค์ของ API ตัวนี้
$stmt = $predicted->getPredicted();

//นับแถวเพื่อดูว่าได้ข้อมูลมาไหม 
$numrow = $stmt->rowCount();

//สร้างตัวแปรมาเก็บข้อมูลที่ได้จากการเรียกใช้ function เพื่อส่งกับไปยังส่วนที่เรียกใช้ API
$predicted_arr = array();

//ตรวจสอบผล และส่งกลับไปยังส่วนที่เรียกใช้ API
if ($numrow > 0) {
    //มีข้อมูล เอาข้อมูลใสาตัวแปร และเตรียมส่งกลับ
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $predicted_item = array(
            "message" => "1",  
            "prediction_6_hours" => $prediction_6_hours,
            "prediction_12_hours" => $prediction_12_hours,
            "prediction_24_hours" => $prediction_24_hours,
            "datatime6" => $datatime6,
            "datatime12" => $datatime12,
            "datatime24" => $datatime24,
        );

        array_push($predicted_arr, $predicted_item);
    }
} else {
    //ไม่มีข้อมูล เอาข้อมูลใสาตัวแปร และเตรียมส่งกลับ
    $predicted_item = array(
        "massage" => "0"
    );
        array_push($predicted_arr, $predicted_item);
}

//คำสั่งจัดการข้อมูลให้เป็น JSON เพื่อส่งกลับ
http_response_code(200);
echo json_encode($predicted_arr[0]);
