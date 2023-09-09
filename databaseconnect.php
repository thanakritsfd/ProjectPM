<?php 
    //เป็นไฟล์กลางที่จะใช้ร่วมกับ Api ต่าง ๆ เพื่อที่จะใช้ติดต่อ และทำงานกับ Database
    class DatabaseConnect
{
    //ประกาศตัวแปรเก็บค่าต่างๆ ที่จะต้องใช้ในกาติดต่อกับฐานข้อมูล
    private $host = "localhost";   //ชื่อ Server ของ DB Server
    private $uname = "root";  //username ที่เข้าใช้งานฐานข้อมูล
    private $pword = "123456789";   //password ที่เข้าใช้งานฐานข้อมูล
    private $dbname = "aqi_db";  //ชื่อฐานข้อมูลที่จะทำงานด้วย
 
    //ประกาศตัวแปรเพื่อใช้สำหรับการติดต่อกับฐานข้อมูล
    public $conn;
 
    //ฟังก์ชันสำหรับการติดต่อไปยังฐานข้อมูล
    public function getConnection()
    {
        $this->conn = null;
 
        try
        {
            //ติดต่อฐานข้อมูล
            $this->conn = new PDO("mysql:host={$this->host};dbname={$this->dbname}" , $this->uname, $this->pword);
            //log ดูผลว่าติดต่อฐานข้อมูลได้หรือไม่ได้ แล้วอย่าลืม comment
            // echo "Connect OK";
        }
        catch(PDOException $ex)
        {
            //log ดูผลว่าติดต่อฐานข้อมูลได้หรือไม่ได้ แล้วอย่าลืม comment
            // echo "Connect NOT OK";
        }
 
        return $this->conn;
    }
}

// สร้างอ็อบเจ็กต์ของคลาส DatabaseConnect
// $db = new DatabaseConnect();

// เรียกใช้งานฟังก์ชัน getConnection() เพื่อเชื่อมต่อกับฐานข้อมูล
// $connection = $db->getConnection();
