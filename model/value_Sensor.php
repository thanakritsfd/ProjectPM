<?php
class Value_Sensor
{
    //ตัวแปรที่ใช้ในการติดต่อ Database
    private $conn;

    //ตัวแปรที่จะทำงานคู่กับแต่ละฟิวล์ในตาราง
    public $ID;
    public $PM;
    public $PM1;
    public $PM2;
    public $PM3;
    public $PM4;
    public $PM5;
    public $PM6;
    public $PM7;
    public $Temperature;
    public $Temp1;
    public $Temp2;
    public $Temp3;
    public $Temp4;
    public $Temp5;
    public $Temp6;
    public $Temp7;
    public $Humidity;
    public $Humid1;
    public $Humid2;
    public $Humid3;
    public $Humid4;
    public $Humid5;
    public $Humid6;
    public $Humid7;
    public $Air_Pressure;
    public $Air_Pressure1;
    public $Air_Pressure2;
    public $Air_Pressure3;
    public $Air_Pressure4;
    public $Air_Pressure5;
    public $Air_Pressure6;
    public $Air_Pressure7;
    public $Wind_Speed;
    public $Wind_Speed1;
    public $Wind_Speed2;
    public $Wind_Speed3;
    public $Wind_Speed4;
    public $Wind_Speed5;
    public $Wind_Speed6;
    public $Wind_Speed7;
    public $Wind_Direction;
    public $Wind_Direction1;
    public $Wind_Direction2;
    public $Wind_Direction3;
    public $Wind_Direction4;
    public $Wind_Direction5;
    public $Wind_Direction6;
    public $Wind_Direction7;
    public $AQI;
    public $AQI1;
    public $AQI2;
    public $AQI3;
    public $AQI4;
    public $AQI5;
    public $AQI6;
    public $AQI7;
    public $Reading_Time;

    //ตัวแปรที่เก็บข้อความต่าง ๆ เผื่อไว้ใช้งาน เฉย ๆ
    public $message;

    //คอนตรักเตอร์ที่จะมีคำสั่งที่ใช้ในการติดต่อกับ Database
    public function __construct($db)
    {
        $this->conn = $db;
    }

    //ฟังก์ชั่นต่าง ๆ ที่จะทำงานกับ Database ตาม API ที่เราจะทำการสร้างมันขึ้นมา ซึ่งมีมากน้อยแล้วแต่
    //function getValueSensor
    function getValueSensor()
    {
        $strSQL = "SELECT ROUND(PM, 0)as PM, ROUND(Temperature, 2) as Temperature, ROUND(Humidity, 2) as Humidity, ROUND(Air_Pressure, 2) as Air_Pressure, ROUND(Wind_Speed, 2)as Wind_Speed, Wind_Direction,
    CASE
    WHEN AVG_PM <= 15 THEN ROUND((((25 - 0)/(15 - 0))*(AVG_PM - 0)) + 0)
    WHEN AVG_PM <= 25 THEN ROUND((((50 - 26)/(25 - 15.1))*(AVG_PM - 15.1)) + 26)
    WHEN AVG_PM <= 37.5 THEN ROUND((((100 - 51)/(37.5 - 25.1))*(AVG_PM - 25.1)) + 51)
    WHEN AVG_PM <= 75 THEN ROUND((((200 - 101)/(75 - 37.6))*(AVG_PM - 37.6)) + 101)
    ELSE ROUND((((10000000 - 200)/(10000000 - 75.1))*(AVG_PM - 75.1)) + 200)
    END as AQI
         FROM value_tb WHERE PM<>0 AND Humidity<>0 AND Air_Pressure<>0  ORDER BY ID DESC LIMIT 1";

        $stmt = $this->conn->prepare($strSQL);

        $stmt->execute();

        return $stmt;
    }

    function getPM_avg()
    {
        $strSQL = "SELECT AVG(PM) AS PMavg FROM (SELECT PM FROM value_tb WHERE PM<>0 AND Humidity<>0 AND Air_Pressure<>0 ORDER BY ID DESC LIMIT 24)AS t1";

        $stmt = $this->conn->prepare($strSQL);

        $stmt->execute();

        return $stmt;
    }


    //ฟังก์ชั่นต่าง ๆ ที่จะทำงานกับ Database ตาม API ที่เราจะทำการสร้างมันขึ้นมา ซึ่งมีมากน้อยแล้วแต่
    //function getValueSensor_Chart
    function getValueSensor_Chart()
    {
        $strSQL = "SELECT ROUND(PM, 0)as PM, ROUND(Temperature, 2) as Temperature, ROUND(Humidity, 2) as Humidity, ROUND(Air_Pressure, 2) as Air_Pressure, ROUND(Wind_Speed, 2)as Wind_Speed, Wind_Direction,
        CASE
            WHEN AVG_PM <= 15 THEN ROUND((((25 - 0)/(15 - 0))*(AVG_PM - 0)) + 0)
            WHEN AVG_PM <= 25 THEN ROUND((((50 - 26)/(25 - 15.1))*(AVG_PM - 15.1)) + 26)
            WHEN AVG_PM <= 37.5 THEN ROUND((((100 - 51)/(37.5 - 25.1))*(AVG_PM - 25.1)) + 51)
            WHEN AVG_PM <= 75 THEN ROUND((((200 - 101)/(75 - 37.6))*(AVG_PM - 37.6)) + 101)
            ELSE ROUND((((10000000 - 200)/(10000000 - 75.1))*(AVG_PM - 75.1)) + 200)
        END as AQI,
        Reading_Time FROM(SELECT * FROM value_tb WHERE PM<>0 AND Humidity<>0 AND Air_Pressure<>0 ORDER BY ID DESC LIMIT 6)AS T1 ORDER BY T1.ID";

        $stmt = $this->conn->prepare($strSQL);

        $stmt->execute();

        return $stmt;
    }

    //function insertValue ที่ทำงานกับ api_insertValue.php
    function insertValue()
    {
        if ($this->Humidity != 0 && !is_null($this->Humidity) && $this->Humidity !== '') {
            $strSQL = "INSERT INTO value_tb (PM, Temperature, Humidity, Air_Pressure, Wind_Speed, Wind_Direction) VALUES(:PM, :Temperature, :Humidity, :Air_Pressure, :Wind_Speed, :Wind_Direction);
		CREATE TEMPORARY TABLE t3 AS
        SELECT ID, PM
        FROM value_tb
        WHERE PM != 0 AND Air_Pressure != 0
        ORDER BY ID DESC
        LIMIT 24;
      
		CREATE TEMPORARY TABLE t4 AS
        SELECT ID, PM
        FROM value_tb
        WHERE PM != 0 AND Air_Pressure != 0
        ORDER BY ID DESC
        LIMIT 24;
        
        CREATE TEMPORARY TABLE t5 AS
        SELECT ID, PM
        FROM value_tb
        WHERE PM != 0 AND Air_Pressure != 0
        ORDER BY ID DESC
        LIMIT 24;
        
        CREATE TEMPORARY TABLE t6 AS
        SELECT ID, PM
        FROM value_tb
        WHERE PM != 0 AND Air_Pressure != 0
        ORDER BY ID DESC
        LIMIT 24;
      
      UPDATE value_tb
      SET AVG_PM = (SELECT AVG(PM) FROM t3),
      Start_ID = (SELECT MIN(ID) FROM t4),
      End_ID = (SELECT MAX(ID) FROM t5)
      WHERE ID = (SELECT MAX(ID) FROM t6);
      
      DROP TEMPORARY TABLE IF EXISTS t3;
      DROP TEMPORARY TABLE IF EXISTS t4;
      DROP TEMPORARY TABLE IF EXISTS t5;
      DROP TEMPORARY TABLE IF EXISTS t6;";

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
            if ($stmt->execute()) {
                //สำเร็จ
                return true;
            } else {
                //ไม่สำเร็จ
                return false;
            }
        }
    }

    //function insertValue ที่ทำงานกับ api_insertValue.php
    function insertValuetest()
    {
        $strSQL = "INSERT INTO value_test (PM, Temperature, Humidity, Air_Pressure, Wind_Speed, Wind_Direction) VALUES(:PM, :Temperature, :Humidity, :Air_Pressure, :Wind_Speed, :Wind_Direction);
            CREATE TEMPORARY TABLE t7 AS
            SELECT ID, PM
            FROM value_tb
            WHERE PM != 0 AND Air_Pressure != 0
            ORDER BY ID DESC
            LIMIT 24;
          
            CREATE TEMPORARY TABLE t8 AS
            SELECT ID, PM
            FROM value_tb
            WHERE PM != 0 AND Air_Pressure != 0
            ORDER BY ID DESC
            LIMIT 24;
            
            CREATE TEMPORARY TABLE t9 AS
            SELECT ID, PM
            FROM value_tb
            WHERE PM != 0 AND Air_Pressure != 0
            ORDER BY ID DESC
            LIMIT 24;
            
            CREATE TEMPORARY TABLE t10 AS
            SELECT ID, PM
            FROM value_tb
            WHERE Air_Pressure != 0
            ORDER BY ID DESC LIMIT 1
          
          UPDATE value_tb
          SET AVG_PM = (SELECT AVG(PM) FROM t7),
          Start_ID = (SELECT MIN(ID) FROM t8),
          End_ID = (SELECT MAX(ID) FROM t9)
          WHERE ID = (SELECT MAX(ID) FROM t10);
          
          DROP TEMPORARY TABLE IF EXISTS t7;
          DROP TEMPORARY TABLE IF EXISTS t8;
          DROP TEMPORARY TABLE IF EXISTS t9;
          DROP TEMPORARY TABLE IF EXISTS t10;";

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
        if ($stmt->execute()) {
            //สำเร็จ
            return true;
        } else {
            //ไม่สำเร็จ
            return false;
        }
    }

    function getPMChartCompare()
    {
        $strSQL = "SELECT t1.PM AS PM1,
        t2.PM AS PM2,
        t3.PM AS PM3,
        t4.PM AS PM4,
        t5.PM AS PM5,
        t6.PM AS PM6,
        t7.PM AS PM7, 
        t1.Reading_Time AS Reading_Time
            FROM
            (SELECT ID, ROUND(PM, 0) AS PM, TIME_FORMAT(t.Reading_Time, '%H:%i') AS Reading_Time
                FROM (
                    SELECT ID, ROUND(PM, 0) AS PM, TIME_FORMAT(Reading_Time, '%H:%i') AS Reading_Time
                    FROM value_tb
                    WHERE DATE_FORMAT(Reading_Time, '%Y-%m-%d') = (
                            SELECT DATE_FORMAT(MAX(Reading_Time), '%Y-%m-%d')
                            FROM value_tb
                        )
                        AND PM <> 0 AND Humidity <> 0 AND Air_Pressure <> 0
                    ORDER BY ID DESC
                    LIMIT 6
                ) AS t
                ORDER BY t.ID
            ) AS t1
            
            LEFT JOIN
            (SELECT ROUND(PM, 0) AS PM, DATE_FORMAT(Reading_Time, '%H:%i') AS Reading_Time
                FROM value_tb
                WHERE DATE_FORMAT(Reading_Time,'%Y-%m-%d') = (SELECT DATE_FORMAT(MAX(Reading_Time) - INTERVAL 1 DAY,'%Y-%m-%d')
                                                            FROM value_tb)
                AND PM<>0 AND Humidity<>0 AND Air_Pressure<>0) AS t2 ON t1.Reading_Time = t2.Reading_Time
            
            LEFT JOIN
            (SELECT ROUND(PM, 0) AS PM, DATE_FORMAT(Reading_Time, '%H:%i') AS Reading_Time
                FROM value_tb
                WHERE DATE_FORMAT(Reading_Time,'%Y-%m-%d') = (SELECT DATE_FORMAT(MAX(Reading_Time) - INTERVAL 2 DAY,'%Y-%m-%d')
                                                            FROM value_tb)
                AND PM<>0 AND Humidity<>0 AND Air_Pressure<>0) AS t3 ON t1.Reading_Time = t3.Reading_Time
            
            LEFT JOIN
            (SELECT ROUND(PM, 0) AS PM, DATE_FORMAT(Reading_Time, '%H:%i') AS Reading_Time
                FROM value_tb
                WHERE DATE_FORMAT(Reading_Time,'%Y-%m-%d') = (SELECT DATE_FORMAT(MAX(Reading_Time) - INTERVAL 3 DAY,'%Y-%m-%d')
                                                            FROM value_tb)
                AND PM<>0 AND Humidity<>0 AND Air_Pressure<>0) AS t4 ON t1.Reading_Time = t4.Reading_Time
            
            LEFT JOIN
            (SELECT ROUND(PM, 0) AS PM, DATE_FORMAT(Reading_Time, '%H:%i') AS Reading_Time
                FROM value_tb
                WHERE DATE_FORMAT(Reading_Time,'%Y-%m-%d') = (SELECT DATE_FORMAT(MAX(Reading_Time) - INTERVAL 4 DAY,'%Y-%m-%d')
                                                            FROM value_tb)
                AND PM<>0 AND Humidity<>0 AND Air_Pressure<>0) AS t5 ON t1.Reading_Time = t5.Reading_Time
            
            LEFT JOIN
            (SELECT ROUND(PM, 0) AS PM, DATE_FORMAT(Reading_Time, '%H:%i') AS Reading_Time
                FROM value_tb
                WHERE DATE_FORMAT(Reading_Time,'%Y-%m-%d') = (SELECT DATE_FORMAT(MAX(Reading_Time) - INTERVAL 5 DAY,'%Y-%m-%d')
                                                            FROM value_tb)
                AND PM<>0 AND Humidity<>0 AND Air_Pressure<>0) AS t6 ON t1.Reading_Time = t6.Reading_Time
            
            LEFT JOIN
            (SELECT ROUND(PM, 0) AS PM, DATE_FORMAT(Reading_Time, '%H:%i') AS Reading_Time
                FROM value_tb
                WHERE DATE_FORMAT(Reading_Time,'%Y-%m-%d') = (SELECT DATE_FORMAT(MAX(Reading_Time) - INTERVAL 6 DAY,'%Y-%m-%d')
                                                            FROM value_tb)
                AND PM<>0 AND Humidity<>0 AND Air_Pressure<>0) AS t7 ON t1.Reading_Time = t7.Reading_Time
            ORDER BY t1.ID;";

        $stmt = $this->conn->prepare($strSQL);

        $stmt->execute();

        return $stmt;
    }

    function getTempChartCompare()
    {
        $strSQL = "SELECT t1.Temperature AS Temp1,
        t2.Temperature AS Temp2,
        t3.Temperature AS Temp3,
        t4.Temperature AS Temp4,
        t5.Temperature AS Temp5,
        t6.Temperature AS Temp6,
        t7.Temperature AS Temp7, 
        t1.Reading_Time AS Reading_Time
            FROM
            (SELECT ID, ROUND(Temperature, 2) AS Temperature, TIME_FORMAT(t.Reading_Time, '%H:%i') AS Reading_Time
                FROM (
                    SELECT ID, ROUND(Temperature, 2) AS Temperature, TIME_FORMAT(Reading_Time, '%H:%i') AS Reading_Time
                    FROM value_tb
                    WHERE DATE_FORMAT(Reading_Time, '%Y-%m-%d') = (
                            SELECT DATE_FORMAT(MAX(Reading_Time), '%Y-%m-%d')
                            FROM value_tb
                        )
                        AND Temperature <> 0 AND Humidity <> 0 AND Air_Pressure <> 0
                    ORDER BY ID DESC
                    LIMIT 6
                ) AS t
                ORDER BY t.ID
            ) AS t1
            
            LEFT JOIN
            (SELECT ROUND(Temperature, 2) AS Temperature, DATE_FORMAT(Reading_Time, '%H:%i') AS Reading_Time
                FROM value_tb
                WHERE DATE_FORMAT(Reading_Time,'%Y-%m-%d') = (SELECT DATE_FORMAT(MAX(Reading_Time) - INTERVAL 1 DAY,'%Y-%m-%d')
                                                            FROM value_tb)
                AND Temperature <> 0 AND Humidity <> 0 AND Air_Pressure <> 0) AS t2 ON t1.Reading_Time = t2.Reading_Time
            
            LEFT JOIN
            (SELECT ROUND(Temperature, 2) AS Temperature, DATE_FORMAT(Reading_Time, '%H:%i') AS Reading_Time
                FROM value_tb
                WHERE DATE_FORMAT(Reading_Time,'%Y-%m-%d') = (SELECT DATE_FORMAT(MAX(Reading_Time) - INTERVAL 2 DAY,'%Y-%m-%d')
                                                            FROM value_tb)
                AND Temperature <> 0 AND Humidity <> 0 AND Air_Pressure <> 0) AS t3 ON t1.Reading_Time = t3.Reading_Time
            
            LEFT JOIN
            (SELECT ROUND(Temperature, 2) AS Temperature, DATE_FORMAT(Reading_Time, '%H:%i') AS Reading_Time
                FROM value_tb
                WHERE DATE_FORMAT(Reading_Time,'%Y-%m-%d') = (SELECT DATE_FORMAT(MAX(Reading_Time) - INTERVAL 3 DAY,'%Y-%m-%d')
                                                            FROM value_tb)
                AND Temperature <> 0 AND Humidity <> 0 AND Air_Pressure <> 0) AS t4 ON t1.Reading_Time = t4.Reading_Time
            
            LEFT JOIN
            (SELECT ROUND(Temperature, 2) AS Temperature, DATE_FORMAT(Reading_Time, '%H:%i') AS Reading_Time
                FROM value_tb
                WHERE DATE_FORMAT(Reading_Time,'%Y-%m-%d') = (SELECT DATE_FORMAT(MAX(Reading_Time) - INTERVAL 4 DAY,'%Y-%m-%d')
                                                            FROM value_tb)
                AND Temperature <> 0 AND Humidity <> 0 AND Air_Pressure <> 0) AS t5 ON t1.Reading_Time = t5.Reading_Time
            
            LEFT JOIN
            (SELECT ROUND(Temperature, 2) AS Temperature, DATE_FORMAT(Reading_Time, '%H:%i') AS Reading_Time
                FROM value_tb
                WHERE DATE_FORMAT(Reading_Time,'%Y-%m-%d') = (SELECT DATE_FORMAT(MAX(Reading_Time) - INTERVAL 5 DAY,'%Y-%m-%d')
                                                            FROM value_tb)
                AND Temperature <> 0 AND Humidity <> 0 AND Air_Pressure <> 0) AS t6 ON t1.Reading_Time = t6.Reading_Time
            
            LEFT JOIN
            (SELECT ROUND(Temperature, 2) AS Temperature, DATE_FORMAT(Reading_Time, '%H:%i') AS Reading_Time
                FROM value_tb
                WHERE DATE_FORMAT(Reading_Time,'%Y-%m-%d') = (SELECT DATE_FORMAT(MAX(Reading_Time) - INTERVAL 6 DAY,'%Y-%m-%d')
                                                            FROM value_tb)
                AND Temperature <> 0 AND Humidity <> 0 AND Air_Pressure <> 0) AS t7 ON t1.Reading_Time = t7.Reading_Time
            ORDER BY t1.ID;";

        $stmt = $this->conn->prepare($strSQL);

        $stmt->execute();

        return $stmt;
    }

    function getHumidChartCompare()
    {
        $strSQL = "SELECT t1.Humidity AS Humid1,
        t2.Humidity AS Humid2,
        t3.Humidity AS Humid3,
        t4.Humidity AS Humid4,
        t5.Humidity AS Humid5,
        t6.Humidity AS Humid6,
        t7.Humidity AS Humid7, 
        t1.Reading_Time AS Reading_Time
            FROM
            (SELECT ID, ROUND(Humidity, 2) AS Humidity, TIME_FORMAT(t.Reading_Time, '%H:%i') AS Reading_Time
                FROM (
                    SELECT ID, ROUND(Humidity, 2) AS Humidity, TIME_FORMAT(Reading_Time, '%H:%i') AS Reading_Time
                    FROM value_tb
                    WHERE DATE_FORMAT(Reading_Time, '%Y-%m-%d') = (
                            SELECT DATE_FORMAT(MAX(Reading_Time), '%Y-%m-%d')
                            FROM value_tb
                        )
                        AND Humidity <> 0 AND Temperature <> 0 AND Air_Pressure <> 0
                    ORDER BY ID DESC
                    LIMIT 6
                ) AS t
                ORDER BY t.ID
            ) AS t1
            
            LEFT JOIN
            (SELECT ROUND(Humidity, 2) AS Humidity, DATE_FORMAT(Reading_Time, '%H:%i') AS Reading_Time
                FROM value_tb
                WHERE DATE_FORMAT(Reading_Time,'%Y-%m-%d') = (SELECT DATE_FORMAT(MAX(Reading_Time) - INTERVAL 1 DAY,'%Y-%m-%d')
                                                            FROM value_tb)
                AND Humidity<>0 AND Temperature<>0 AND Air_Pressure<>0) AS t2 ON t1.Reading_Time = t2.Reading_Time
            
            LEFT JOIN
            (SELECT ROUND(Humidity, 2) AS Humidity, DATE_FORMAT(Reading_Time, '%H:%i') AS Reading_Time
                FROM value_tb
                WHERE DATE_FORMAT(Reading_Time,'%Y-%m-%d') = (SELECT DATE_FORMAT(MAX(Reading_Time) - INTERVAL 2 DAY,'%Y-%m-%d')
                                                            FROM value_tb)
                AND Humidity<>0 AND Temperature<>0 AND Air_Pressure<>0) AS t3 ON t1.Reading_Time = t3.Reading_Time
            
            LEFT JOIN
            (SELECT ROUND(Humidity, 2) AS Humidity, DATE_FORMAT(Reading_Time, '%H:%i') AS Reading_Time
                FROM value_tb
                WHERE DATE_FORMAT(Reading_Time,'%Y-%m-%d') = (SELECT DATE_FORMAT(MAX(Reading_Time) - INTERVAL 3 DAY,'%Y-%m-%d')
                                                            FROM value_tb)
                AND Humidity<>0 AND Temperature<>0 AND Air_Pressure<>0) AS t4 ON t1.Reading_Time = t4.Reading_Time
            
            LEFT JOIN
            (SELECT ROUND(Humidity, 2) AS Humidity, DATE_FORMAT(Reading_Time, '%H:%i') AS Reading_Time
                FROM value_tb
                WHERE DATE_FORMAT(Reading_Time,'%Y-%m-%d') = (SELECT DATE_FORMAT(MAX(Reading_Time) - INTERVAL 4 DAY,'%Y-%m-%d')
                                                            FROM value_tb)
                AND Humidity<>0 AND Temperature<>0 AND Air_Pressure<>0) AS t5 ON t1.Reading_Time = t5.Reading_Time
            
            LEFT JOIN
            (SELECT ROUND(Humidity, 2) AS Humidity, DATE_FORMAT(Reading_Time, '%H:%i') AS Reading_Time
                FROM value_tb
                WHERE DATE_FORMAT(Reading_Time,'%Y-%m-%d') = (SELECT DATE_FORMAT(MAX(Reading_Time) - INTERVAL 5 DAY,'%Y-%m-%d')
                                                            FROM value_tb)
                AND Humidity<>0 AND Temperature<>0 AND Air_Pressure<>0) AS t6 ON t1.Reading_Time = t6.Reading_Time
            
            LEFT JOIN
            (SELECT ROUND(Humidity, 2) AS Humidity, DATE_FORMAT(Reading_Time, '%H:%i') AS Reading_Time
                FROM value_tb
                WHERE DATE_FORMAT(Reading_Time,'%Y-%m-%d') = (SELECT DATE_FORMAT(MAX(Reading_Time) - INTERVAL 6 DAY,'%Y-%m-%d')
                                                            FROM value_tb)
                AND Humidity<>0 AND Temperature<>0 AND Air_Pressure<>0) AS t7 ON t1.Reading_Time = t7.Reading_Time
            ORDER BY t1.ID;";

        $stmt = $this->conn->prepare($strSQL);

        $stmt->execute();

        return $stmt;
    }

    function getAirPressureChartCompare()
    {
        $strSQL = "SELECT t1.Air_Pressure AS Air_Pressure1,
        t2.Air_Pressure AS Air_Pressure2,
        t3.Air_Pressure AS Air_Pressure3,
        t4.Air_Pressure AS Air_Pressure4,
        t5.Air_Pressure AS Air_Pressure5,
        t6.Air_Pressure AS Air_Pressure6,
        t7.Air_Pressure AS Air_Pressure7, 
        t1.Reading_Time AS Reading_Time
            FROM
            (SELECT ID, ROUND(Air_Pressure, 2) AS Air_Pressure, TIME_FORMAT(t.Reading_Time, '%H:%i') AS Reading_Time
                FROM (
                    SELECT ID, ROUND(Air_Pressure, 2) AS Air_Pressure, TIME_FORMAT(Reading_Time, '%H:%i') AS Reading_Time
                    FROM value_tb
                    WHERE DATE_FORMAT(Reading_Time, '%Y-%m-%d') = (
                            SELECT DATE_FORMAT(MAX(Reading_Time), '%Y-%m-%d')
                            FROM value_tb
                        )
                        AND Air_Pressure <> 0 AND Humidity <> 0 AND Temperature <> 0
                    ORDER BY ID DESC
                    LIMIT 6
                ) AS t
                ORDER BY t.ID
            ) AS t1
            
            LEFT JOIN
            (SELECT ROUND(Air_Pressure, 2) AS Air_Pressure, DATE_FORMAT(Reading_Time, '%H:%i') AS Reading_Time
                FROM value_tb
                WHERE DATE_FORMAT(Reading_Time,'%Y-%m-%d') = (SELECT DATE_FORMAT(MAX(Reading_Time) - INTERVAL 1 DAY,'%Y-%m-%d')
                                                            FROM value_tb)
                AND Air_Pressure <> 0 AND Humidity <> 0 AND Temperature <> 0) AS t2 ON t1.Reading_Time = t2.Reading_Time
            
            LEFT JOIN
            (SELECT ROUND(Air_Pressure, 2) AS Air_Pressure, DATE_FORMAT(Reading_Time, '%H:%i') AS Reading_Time
                FROM value_tb
                WHERE DATE_FORMAT(Reading_Time,'%Y-%m-%d') = (SELECT DATE_FORMAT(MAX(Reading_Time) - INTERVAL 2 DAY,'%Y-%m-%d')
                                                            FROM value_tb)
                AND Air_Pressure <> 0 AND Humidity <> 0 AND Temperature <> 0) AS t3 ON t1.Reading_Time = t3.Reading_Time
            
            LEFT JOIN
            (SELECT ROUND(Air_Pressure, 2) AS Air_Pressure, DATE_FORMAT(Reading_Time, '%H:%i') AS Reading_Time
                FROM value_tb
                WHERE DATE_FORMAT(Reading_Time,'%Y-%m-%d') = (SELECT DATE_FORMAT(MAX(Reading_Time) - INTERVAL 3 DAY,'%Y-%m-%d')
                                                            FROM value_tb)
                AND Air_Pressure <> 0 AND Humidity <> 0 AND Temperature <> 0) AS t4 ON t1.Reading_Time = t4.Reading_Time
            
            LEFT JOIN
            (SELECT ROUND(Air_Pressure, 2) AS Air_Pressure, DATE_FORMAT(Reading_Time, '%H:%i') AS Reading_Time
                FROM value_tb
                WHERE DATE_FORMAT(Reading_Time,'%Y-%m-%d') = (SELECT DATE_FORMAT(MAX(Reading_Time) - INTERVAL 4 DAY,'%Y-%m-%d')
                                                            FROM value_tb)
                AND Air_Pressure <> 0 AND Humidity <> 0 AND Temperature <> 0) AS t5 ON t1.Reading_Time = t5.Reading_Time
            
            LEFT JOIN
            (SELECT ROUND(Air_Pressure, 2) AS Air_Pressure, DATE_FORMAT(Reading_Time, '%H:%i') AS Reading_Time
                FROM value_tb
                WHERE DATE_FORMAT(Reading_Time,'%Y-%m-%d') = (SELECT DATE_FORMAT(MAX(Reading_Time) - INTERVAL 5 DAY,'%Y-%m-%d')
                                                            FROM value_tb)
                AND Air_Pressure <> 0 AND Humidity <> 0 AND Temperature <> 0) AS t6 ON t1.Reading_Time = t6.Reading_Time
            
            LEFT JOIN
            (SELECT ROUND(Air_Pressure, 2) AS Air_Pressure, DATE_FORMAT(Reading_Time, '%H:%i') AS Reading_Time
                FROM value_tb
                WHERE DATE_FORMAT(Reading_Time,'%Y-%m-%d') = (SELECT DATE_FORMAT(MAX(Reading_Time) - INTERVAL 6 DAY,'%Y-%m-%d')
                                                            FROM value_tb)
                AND Air_Pressure <> 0 AND Humidity <> 0 AND Temperature <> 0) AS t7 ON t1.Reading_Time = t7.Reading_Time
            ORDER BY t1.ID;";

        $stmt = $this->conn->prepare($strSQL);

        $stmt->execute();

        return $stmt;
    }

    function getWindSpeedChartCompare()
    {
        $strSQL = "SELECT t1.Wind_Speed AS Wind_Speed1,
        t2.Wind_Speed AS Wind_Speed2,
        t3.Wind_Speed AS Wind_Speed3,
        t4.Wind_Speed AS Wind_Speed4,
        t5.Wind_Speed AS Wind_Speed5,
        t6.Wind_Speed AS Wind_Speed6,
        t7.Wind_Speed AS Wind_Speed7, 
        t1.Reading_Time AS Reading_Time
            FROM
            (SELECT ID, ROUND(Wind_Speed, 2) AS Wind_Speed, TIME_FORMAT(t.Reading_Time, '%H:%i') AS Reading_Time
                FROM (
                    SELECT ID, ROUND(Wind_Speed, 2) AS Wind_Speed, TIME_FORMAT(Reading_Time, '%H:%i') AS Reading_Time
                    FROM value_tb
                    WHERE DATE_FORMAT(Reading_Time, '%Y-%m-%d') = (
                            SELECT DATE_FORMAT(MAX(Reading_Time), '%Y-%m-%d')
                            FROM value_tb
                        )
                        AND Air_Pressure <> 0 AND Humidity <> 0 AND Temperature <> 0
                    ORDER BY ID DESC
                    LIMIT 6
                ) AS t
                ORDER BY t.ID
            ) AS t1
            
            LEFT JOIN
            (SELECT ROUND(Wind_Speed, 2) AS Wind_Speed, DATE_FORMAT(Reading_Time, '%H:%i') AS Reading_Time
                FROM value_tb
                WHERE DATE_FORMAT(Reading_Time,'%Y-%m-%d') = (SELECT DATE_FORMAT(MAX(Reading_Time) - INTERVAL 1 DAY,'%Y-%m-%d')
                                                            FROM value_tb)
                AND Air_Pressure <> 0 AND Humidity <> 0 AND Temperature <> 0) AS t2 ON t1.Reading_Time = t2.Reading_Time
            
            LEFT JOIN
            (SELECT ROUND(Wind_Speed, 2) AS Wind_Speed, DATE_FORMAT(Reading_Time, '%H:%i') AS Reading_Time
                FROM value_tb
                WHERE DATE_FORMAT(Reading_Time,'%Y-%m-%d') = (SELECT DATE_FORMAT(MAX(Reading_Time) - INTERVAL 2 DAY,'%Y-%m-%d')
                                                            FROM value_tb)
                AND Air_Pressure <> 0 AND Humidity <> 0 AND Temperature <> 0) AS t3 ON t1.Reading_Time = t3.Reading_Time
            
            LEFT JOIN
            (SELECT ROUND(Wind_Speed, 2) AS Wind_Speed, DATE_FORMAT(Reading_Time, '%H:%i') AS Reading_Time
                FROM value_tb
                WHERE DATE_FORMAT(Reading_Time,'%Y-%m-%d') = (SELECT DATE_FORMAT(MAX(Reading_Time) - INTERVAL 3 DAY,'%Y-%m-%d')
                                                            FROM value_tb)
                AND Air_Pressure <> 0 AND Humidity <> 0 AND Temperature <> 0) AS t4 ON t1.Reading_Time = t4.Reading_Time
            
            LEFT JOIN
            (SELECT ROUND(Wind_Speed, 2) AS Wind_Speed, DATE_FORMAT(Reading_Time, '%H:%i') AS Reading_Time
                FROM value_tb
                WHERE DATE_FORMAT(Reading_Time,'%Y-%m-%d') = (SELECT DATE_FORMAT(MAX(Reading_Time) - INTERVAL 4 DAY,'%Y-%m-%d')
                                                            FROM value_tb)
                AND Air_Pressure <> 0 AND Humidity <> 0 AND Temperature <> 0) AS t5 ON t1.Reading_Time = t5.Reading_Time
            
            LEFT JOIN
            (SELECT ROUND(Wind_Speed, 2) AS Wind_Speed, DATE_FORMAT(Reading_Time, '%H:%i') AS Reading_Time
                FROM value_tb
                WHERE DATE_FORMAT(Reading_Time,'%Y-%m-%d') = (SELECT DATE_FORMAT(MAX(Reading_Time) - INTERVAL 5 DAY,'%Y-%m-%d')
                                                            FROM value_tb)
                AND Air_Pressure <> 0 AND Humidity <> 0 AND Temperature <> 0) AS t6 ON t1.Reading_Time = t6.Reading_Time
            
            LEFT JOIN
            (SELECT ROUND(Wind_Speed, 2) AS Wind_Speed, DATE_FORMAT(Reading_Time, '%H:%i') AS Reading_Time
                FROM value_tb
                WHERE DATE_FORMAT(Reading_Time,'%Y-%m-%d') = (SELECT DATE_FORMAT(MAX(Reading_Time) - INTERVAL 6 DAY,'%Y-%m-%d')
                                                            FROM value_tb)
                AND Air_Pressure <> 0 AND Humidity <> 0 AND Temperature <> 0) AS t7 ON t1.Reading_Time = t7.Reading_Time
            ORDER BY t1.ID;";

        $stmt = $this->conn->prepare($strSQL);

        $stmt->execute();

        return $stmt;
    }

    function getWindDirectionChartCompare()
    {
        $strSQL = "SELECT t1.Wind_Direction AS Wind_Direction1,
        t2.Wind_Direction AS Wind_Direction2,
        t3.Wind_Direction AS Wind_Direction3,
        t4.Wind_Direction AS Wind_Direction4,
        t5.Wind_Direction AS Wind_Direction5,
        t6.Wind_Direction AS Wind_Direction6,
        t7.Wind_Direction AS Wind_Direction7, 
        t1.Reading_Time AS Reading_Time
            FROM
            (SELECT ID, ROUND(Wind_Direction, 2) AS Wind_Direction, TIME_FORMAT(t.Reading_Time, '%H:%i') AS Reading_Time
                FROM (
                    SELECT ID, ROUND(Wind_Direction, 2) AS Wind_Direction, TIME_FORMAT(Reading_Time, '%H:%i') AS Reading_Time
                    FROM value_tb
                    WHERE DATE_FORMAT(Reading_Time, '%Y-%m-%d') = (
                            SELECT DATE_FORMAT(MAX(Reading_Time), '%Y-%m-%d')
                            FROM value_tb
                        )
                        AND Air_Pressure <> 0 AND Humidity <> 0 AND Temperature <> 0
                    ORDER BY ID DESC
                    LIMIT 6
                ) AS t
                ORDER BY t.ID
            ) AS t1
            
            LEFT JOIN
            (SELECT ROUND(Wind_Direction, 2) AS Wind_Direction, DATE_FORMAT(Reading_Time, '%H:%i') AS Reading_Time
                FROM value_tb
                WHERE DATE_FORMAT(Reading_Time,'%Y-%m-%d') = (SELECT DATE_FORMAT(MAX(Reading_Time) - INTERVAL 1 DAY,'%Y-%m-%d')
                                                            FROM value_tb)
                AND Air_Pressure <> 0 AND Humidity <> 0 AND Temperature <> 0) AS t2 ON t1.Reading_Time = t2.Reading_Time
            
            LEFT JOIN
            (SELECT ROUND(Wind_Direction, 2) AS Wind_Direction, DATE_FORMAT(Reading_Time, '%H:%i') AS Reading_Time
                FROM value_tb
                WHERE DATE_FORMAT(Reading_Time,'%Y-%m-%d') = (SELECT DATE_FORMAT(MAX(Reading_Time) - INTERVAL 2 DAY,'%Y-%m-%d')
                                                            FROM value_tb)
                AND Air_Pressure <> 0 AND Humidity <> 0 AND Temperature <> 0) AS t3 ON t1.Reading_Time = t3.Reading_Time
            
            LEFT JOIN
            (SELECT ROUND(Wind_Direction, 2) AS Wind_Direction, DATE_FORMAT(Reading_Time, '%H:%i') AS Reading_Time
                FROM value_tb
                WHERE DATE_FORMAT(Reading_Time,'%Y-%m-%d') = (SELECT DATE_FORMAT(MAX(Reading_Time) - INTERVAL 3 DAY,'%Y-%m-%d')
                                                            FROM value_tb)
                AND Air_Pressure <> 0 AND Humidity <> 0 AND Temperature <> 0) AS t4 ON t1.Reading_Time = t4.Reading_Time
            
            LEFT JOIN
            (SELECT ROUND(Wind_Direction, 2) AS Wind_Direction, DATE_FORMAT(Reading_Time, '%H:%i') AS Reading_Time
                FROM value_tb
                WHERE DATE_FORMAT(Reading_Time,'%Y-%m-%d') = (SELECT DATE_FORMAT(MAX(Reading_Time) - INTERVAL 4 DAY,'%Y-%m-%d')
                                                            FROM value_tb)
                AND Air_Pressure <> 0 AND Humidity <> 0 AND Temperature <> 0) AS t5 ON t1.Reading_Time = t5.Reading_Time
            
            LEFT JOIN
            (SELECT ROUND(Wind_Direction, 2) AS Wind_Direction, DATE_FORMAT(Reading_Time, '%H:%i') AS Reading_Time
                FROM value_tb
                WHERE DATE_FORMAT(Reading_Time,'%Y-%m-%d') = (SELECT DATE_FORMAT(MAX(Reading_Time) - INTERVAL 5 DAY,'%Y-%m-%d')
                                                            FROM value_tb)
                AND Air_Pressure <> 0 AND Humidity <> 0 AND Temperature <> 0) AS t6 ON t1.Reading_Time = t6.Reading_Time
            
            LEFT JOIN
            (SELECT ROUND(Wind_Direction, 2) AS Wind_Direction, DATE_FORMAT(Reading_Time, '%H:%i') AS Reading_Time
                FROM value_tb
                WHERE DATE_FORMAT(Reading_Time,'%Y-%m-%d') = (SELECT DATE_FORMAT(MAX(Reading_Time) - INTERVAL 6 DAY,'%Y-%m-%d')
                                                            FROM value_tb)
                AND Air_Pressure <> 0 AND Humidity <> 0 AND Temperature <> 0) AS t7 ON t1.Reading_Time = t7.Reading_Time
            ORDER BY t1.ID;";

        $stmt = $this->conn->prepare($strSQL);

        $stmt->execute();

        return $stmt;
    }

    function getAQIChartCompare()
    {
        $strSQL = "SELECT t1.AQI AS AQI1,
        t2.AQI AS AQI2,
        t3.AQI AS AQI3,
        t4.AQI AS AQI4,
        t5.AQI AS AQI5,
        t6.AQI AS AQI6,
        t7.AQI AS AQI7, 
        t1.Reading_Time AS Reading_Time
            FROM
            (SELECT ID,
                    CASE
                        WHEN AVG_PM <= 15 THEN ROUND((((25 - 0)/(15 - 0))*(AVG_PM - 0)) + 0)
                        WHEN AVG_PM <= 25 THEN ROUND((((50 - 26)/(25 - 15.1))*(AVG_PM - 15.1)) + 26)
                        WHEN AVG_PM <= 37.5 THEN ROUND((((100 - 51)/(37.5 - 25.1))*(AVG_PM - 25.1)) + 51)
                        WHEN AVG_PM <= 75 THEN ROUND((((200 - 101)/(75 - 37.6))*(AVG_PM - 37.6)) + 101)
                        ELSE ROUND((((10000000 - 200)/(10000000 - 75.1))*(AVG_PM - 75.1)) + 200)
                    END as AQI,
                    TIME_FORMAT(t.Reading_Time, '%H:%i') AS Reading_Time
            FROM (
                SELECT ID, AVG_PM, TIME_FORMAT(Reading_Time, '%H:%i') AS Reading_Time
                FROM value_tb
                WHERE DATE_FORMAT(Reading_Time, '%Y-%m-%d') = (
                        SELECT DATE_FORMAT(MAX(Reading_Time), '%Y-%m-%d')
                        FROM value_tb
                    )
                    AND AVG_PM <> 0 AND Humidity <> 0 AND Temperature <> 0
                ORDER BY ID DESC
                LIMIT 6
            ) AS t
            ORDER BY t.ID
            ) AS t1
            
            LEFT JOIN
            (SELECT 
                    CASE
                        WHEN AVG_PM <= 15 THEN ROUND((((25 - 0)/(15 - 0))*(AVG_PM - 0)) + 0)
                        WHEN AVG_PM <= 25 THEN ROUND((((50 - 26)/(25 - 15.1))*(AVG_PM - 15.1)) + 26)
                        WHEN AVG_PM <= 37.5 THEN ROUND((((100 - 51)/(37.5 - 25.1))*(AVG_PM - 25.1)) + 51)
                        WHEN AVG_PM <= 75 THEN ROUND((((200 - 101)/(75 - 37.6))*(AVG_PM - 37.6)) + 101)
                        ELSE ROUND((((10000000 - 200)/(10000000 - 75.1))*(AVG_PM - 75.1)) + 200)
                    END as AQI,
                    DATE_FORMAT(Reading_Time, '%H:%i') AS Reading_Time
                FROM value_tb
                WHERE DATE_FORMAT(Reading_Time,'%Y-%m-%d') = (SELECT DATE_FORMAT(MAX(Reading_Time) - INTERVAL 1 DAY,'%Y-%m-%d')
                                                            FROM value_tb)
                AND AVG_PM <> 0 AND Humidity <> 0 AND Temperature <> 0) AS t2 ON t1.Reading_Time = t2.Reading_Time
            
            LEFT JOIN
            (SELECT 
                    CASE
                        WHEN AVG_PM <= 15 THEN ROUND((((25 - 0)/(15 - 0))*(AVG_PM - 0)) + 0)
                        WHEN AVG_PM <= 25 THEN ROUND((((50 - 26)/(25 - 15.1))*(AVG_PM - 15.1)) + 26)
                        WHEN AVG_PM <= 37.5 THEN ROUND((((100 - 51)/(37.5 - 25.1))*(AVG_PM - 25.1)) + 51)
                        WHEN AVG_PM <= 75 THEN ROUND((((200 - 101)/(75 - 37.6))*(AVG_PM - 37.6)) + 101)
                        ELSE ROUND((((10000000 - 200)/(10000000 - 75.1))*(AVG_PM - 75.1)) + 200)
                    END as AQI,
                    DATE_FORMAT(Reading_Time, '%H:%i') AS Reading_Time
                FROM value_tb
                WHERE DATE_FORMAT(Reading_Time,'%Y-%m-%d') = (SELECT DATE_FORMAT(MAX(Reading_Time) - INTERVAL 2 DAY,'%Y-%m-%d')
                                                            FROM value_tb)
                AND AVG_PM <> 0 AND Humidity <> 0 AND Temperature <> 0) AS t3 ON t1.Reading_Time = t3.Reading_Time
            
            LEFT JOIN
            (SELECT 
                    CASE
                        WHEN AVG_PM <= 15 THEN ROUND((((25 - 0)/(15 - 0))*(AVG_PM - 0)) + 0)
                        WHEN AVG_PM <= 25 THEN ROUND((((50 - 26)/(25 - 15.1))*(AVG_PM - 15.1)) + 26)
                        WHEN AVG_PM <= 37.5 THEN ROUND((((100 - 51)/(37.5 - 25.1))*(AVG_PM - 25.1)) + 51)
                        WHEN AVG_PM <= 75 THEN ROUND((((200 - 101)/(75 - 37.6))*(AVG_PM - 37.6)) + 101)
                        ELSE ROUND((((10000000 - 200)/(10000000 - 75.1))*(AVG_PM - 75.1)) + 200)
                    END as AQI,
                    DATE_FORMAT(Reading_Time, '%H:%i') AS Reading_Time
                FROM value_tb
                WHERE DATE_FORMAT(Reading_Time,'%Y-%m-%d') = (SELECT DATE_FORMAT(MAX(Reading_Time) - INTERVAL 3 DAY,'%Y-%m-%d')
                                                            FROM value_tb)
                AND AVG_PM <> 0 AND Humidity <> 0 AND Temperature <> 0) AS t4 ON t1.Reading_Time = t4.Reading_Time
            
            LEFT JOIN
            (SELECT 
                    CASE
                        WHEN AVG_PM <= 15 THEN ROUND((((25 - 0)/(15 - 0))*(AVG_PM - 0)) + 0)
                        WHEN AVG_PM <= 25 THEN ROUND((((50 - 26)/(25 - 15.1))*(AVG_PM - 15.1)) + 26)
                        WHEN AVG_PM <= 37.5 THEN ROUND((((100 - 51)/(37.5 - 25.1))*(AVG_PM - 25.1)) + 51)
                        WHEN AVG_PM <= 75 THEN ROUND((((200 - 101)/(75 - 37.6))*(AVG_PM - 37.6)) + 101)
                        ELSE ROUND((((10000000 - 200)/(10000000 - 75.1))*(AVG_PM - 75.1)) + 200)
                    END as AQI,
                    DATE_FORMAT(Reading_Time, '%H:%i') AS Reading_Time
                FROM value_tb
                WHERE DATE_FORMAT(Reading_Time,'%Y-%m-%d') = (SELECT DATE_FORMAT(MAX(Reading_Time) - INTERVAL 4 DAY,'%Y-%m-%d')
                                                            FROM value_tb)
                AND AVG_PM <> 0 AND Humidity <> 0 AND Temperature <> 0) AS t5 ON t1.Reading_Time = t5.Reading_Time
            
            LEFT JOIN
            (SELECT 
                    CASE
                        WHEN AVG_PM <= 15 THEN ROUND((((25 - 0)/(15 - 0))*(AVG_PM - 0)) + 0)
                        WHEN AVG_PM <= 25 THEN ROUND((((50 - 26)/(25 - 15.1))*(AVG_PM - 15.1)) + 26)
                        WHEN AVG_PM <= 37.5 THEN ROUND((((100 - 51)/(37.5 - 25.1))*(AVG_PM - 25.1)) + 51)
                        WHEN AVG_PM <= 75 THEN ROUND((((200 - 101)/(75 - 37.6))*(AVG_PM - 37.6)) + 101)
                        ELSE ROUND((((10000000 - 200)/(10000000 - 75.1))*(AVG_PM - 75.1)) + 200)
                    END as AQI,
                    DATE_FORMAT(Reading_Time, '%H:%i') AS Reading_Time
                FROM value_tb
                WHERE DATE_FORMAT(Reading_Time,'%Y-%m-%d') = (SELECT DATE_FORMAT(MAX(Reading_Time) - INTERVAL 5 DAY,'%Y-%m-%d')
                                                            FROM value_tb)
                AND AVG_PM <> 0 AND Humidity <> 0 AND Temperature <> 0) AS t6 ON t1.Reading_Time = t6.Reading_Time
            
            LEFT JOIN
            (SELECT 
                    CASE
                        WHEN AVG_PM <= 15 THEN ROUND((((25 - 0)/(15 - 0))*(AVG_PM - 0)) + 0)
                        WHEN AVG_PM <= 25 THEN ROUND((((50 - 26)/(25 - 15.1))*(AVG_PM - 15.1)) + 26)
                        WHEN AVG_PM <= 37.5 THEN ROUND((((100 - 51)/(37.5 - 25.1))*(AVG_PM - 25.1)) + 51)
                        WHEN AVG_PM <= 75 THEN ROUND((((200 - 101)/(75 - 37.6))*(AVG_PM - 37.6)) + 101)
                        ELSE ROUND((((10000000 - 200)/(10000000 - 75.1))*(AVG_PM - 75.1)) + 200)
                    END as AQI,
                    DATE_FORMAT(Reading_Time, '%H:%i') AS Reading_Time
                FROM value_tb
                WHERE DATE_FORMAT(Reading_Time,'%Y-%m-%d') = (SELECT DATE_FORMAT(MAX(Reading_Time) - INTERVAL 6 DAY,'%Y-%m-%d')
                                                            FROM value_tb)
                AND AVG_PM <> 0 AND Humidity <> 0 AND Temperature <> 0) AS t7 ON t1.Reading_Time = t7.Reading_Time
            ORDER BY t1.ID;
            ";

        $stmt = $this->conn->prepare($strSQL);

        $stmt->execute();

        return $stmt;
    }
}
