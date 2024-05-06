<?php
class predicted{
    //ตัวแปรที่ใช้ในการติดต่อ Database
    private $conn;

    //ตัวแปรที่จะทำงานคู่กับแต่ละฟิวล์ในตาราง
    public $id;
    public $prediction_1_hour;
    public $prediction_3_hours;
    public $prediction_6_hours;
    public $prediction_12_hours;
    public $prediction_24_hours;
    public $datatime1;
    public $datatime3;
    public $datatime6;
    public $datatime12;
    public $datatime24;

    //ตัวแปรที่เก็บข้อความต่าง ๆ เผื่อไว้ใช้งาน เฉย ๆ
    public $message;

    //คอนตรักเตอร์ที่จะมีคำสั่งที่ใช้ในการติดต่อกับ Database
    public function __construct($db)
    {
        $this->conn = $db;
    }

    function getPredicted()
    {
        $strSQL = "SELECT 
        stb1.status AS prediction_1_hour,
        stb2.status AS prediction_3_hours,
        stb3.status AS prediction_6_hours,
        stb4.status AS prediction_12_hours,
        stb5.status AS prediction_24_hours, 
            DATE_FORMAT(DATE_ADD(datatime, INTERVAL 1 HOUR), '%d/%m/%Y %H:%i') AS datatime1, 
            DATE_FORMAT(DATE_ADD(datatime, INTERVAL 3 HOUR), '%d/%m/%Y %H:%i') AS datatime3, 
            DATE_FORMAT(DATE_ADD(datatime, INTERVAL 6 HOUR), '%d/%m/%Y %H:%i') AS datatime6, 
            DATE_FORMAT(DATE_ADD(datatime, INTERVAL 12 HOUR), '%d/%m/%Y %H:%i') AS datatime12, 
            DATE_FORMAT(DATE_ADD(datatime, INTERVAL 24 HOUR), '%d/%m/%Y %H:%i') AS datatime24
    FROM 
        prediction_tb ptb
    LEFT JOIN 
        status_tb stb1 ON ptb.prediction_1_hour = stb1.id
    LEFT JOIN 
        status_tb stb2 ON ptb.prediction_3_hours = stb2.id
    LEFT JOIN 
        status_tb stb3 ON ptb.prediction_6_hours = stb3.id
    LEFT JOIN 
        status_tb stb4 ON ptb.prediction_12_hours = stb4.id
    LEFT JOIN 
        status_tb stb5 ON ptb.prediction_24_hours = stb5.id
    ORDER BY 
        ptb.ID DESC 
    LIMIT 1;";

        $stmt = $this->conn->prepare($strSQL);

        $stmt->execute();

        return $stmt;
    }
        
}