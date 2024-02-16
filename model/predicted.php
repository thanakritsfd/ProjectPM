<?php
class predicted{
    //ตัวแปรที่ใช้ในการติดต่อ Database
    private $conn;

    //ตัวแปรที่จะทำงานคู่กับแต่ละฟิวล์ในตาราง
    public $id;
    public $PM;
    public $prediction_6_hours;
    public $prediction_12_hours;
    public $prediction_24_hours;

    //ตัวแปรที่เก็บข้อความต่าง ๆ เผื่อไว้ใช้งาน เฉย ๆ
    public $message;

    //คอนตรักเตอร์ที่จะมีคำสั่งที่ใช้ในการติดต่อกับ Database
    public function __construct($db)
    {
        $this->conn = $db;
    }

    function getPredicted()
    {
        $strSQL = "SELECT prediction_6_hours, prediction_12_hours, prediction_24_hours FROM predicted_tb ORDER BY ID DESC LIMIT 1";

        $stmt = $this->conn->prepare($strSQL);

        $stmt->execute();

        return $stmt;
    }
        
}