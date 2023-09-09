<?php
class Value_Sensor{
    //ตัวแปรที่ใช้ในการติดต่อ Database
    private $conn;

    //ตัวแปรที่จะทำงานคู่กับแต่ละฟิวล์ในตาราง
    public $ID;
    public $PM;
    public $Temperature;
    public $Humidity;
    public $Air_Pressure;
    public $Wind_Speed;
    public $Wind_Direction;
    public $Reading_Time;

    //ตัวแปรที่เก็บข้อความต่าง ๆ เผื่อไว้ใช้งาน เฉย ๆ
    public $message;

    //คอนตรักเตอร์ที่จะมีคำสั่งที่ใช้ในการติดต่อกับ Database
    public function __construct($db)
    {
        $this->conn = $db;
    }

    //function insertValue ที่ทำงานกับ api_insertValue.php
    function insertValue(){
        $strSQL = "INSERT INTO value_tb (PM, Temperature, Humidity, Air_Pressure, Wind_Speed, Wind_Direction) VALUES(:PM, :Temperature, :Humidity, :Air_Pressure, :Wind_Speed, :Wind_Direction)";

        $stmt = $this->conn->prepare($strSQL);

        //ตรวจสอบข้อมูล
        $this->PM = htmlspecialchars(strip_tags($this->PM));
        $this->Temperature = htmlspecialchars(strip_tags($this->Temperature));
        $this->Humidity = htmlspecialchars(strip_tags($this->Humidity));
        $this->Air_Pressure = htmlspecialchars(strip_tags($this->Air_Pressure));
        $this->Wind_Speed = htmlspecialchars(strip_tags($this->Wind_Speed));
        $this->Wind_Direction = htmlspecialchars(strip_tags($this->Wind_Direction));

        //กำหนดข้อมูลให้ Parameter
        $stmt->bindParam(":PM", $this->PM);
        $stmt->bindParam(":Temperature", $this->Temperature);
        $stmt->bindParam(":Humidity", $this->Humidity);
        $stmt->bindParam(":Air_Pressure", $this->Air_Pressure);
        $stmt->bindParam(":Wind_Speed", $this->Wind_Speed);
        $stmt->bindParam(":Wind_Direction", $this->Wind_Direction);

        //สั่งให้ SQL ทำงาน
        if($stmt->execute()){
            //สำเร็จ
            return true;
        }else{
            //ไม่สำเร็จ
            return false;
        }          
    }
}