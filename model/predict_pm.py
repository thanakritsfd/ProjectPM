from datetime import datetime
import pandas as pd
import pymysql
import os
import subprocess

class PredictController:
    def __init__(self, host, user, password, database):
        self.host = host
        self.user = user
        self.password = password
        self.database = database

    def execute_query(self, query):
        connection = pymysql.connect(host=self.host, user=self.user, password=self.password, database=self.database)
        df = pd.read_sql(query, connection)
        connection.close()
        return df

    def createDataset(self, df, file_name):
        script_directory = os.path.dirname(os.path.abspath(__file__))
        csv_file_path = os.path.join(script_directory, 'dataset', file_name)
        df.to_csv(csv_file_path, index=False)

    def Predict(self):
        subprocess.run(['python', 'model/random_forest_norminal.py'])
        subprocess.run(['python', 'model/random_forest.py'])
        subprocess.run(['python', 'model/forest_regression.py'])
        subprocess.run(['python', 'model/forest_aqi.py'])
        subprocess.run(['python', 'model/mva_aqi.py'])

if __name__ == "__main__":
    # Parameters
    host = 'localhost'
    user = 'root'
    password = '123456789'
    database = 'pm_db'

    # SQL queries
    query1 = '''
        SELECT 
            ID,
            ROW_NUMBER() OVER (ORDER BY Reading_Time) AS No, 
    PM,
    Temperature,
    Humidity,
    Air_Pressure,
    Wind_Speed,
            Wind_Direction,
            CASE
                WHEN AVG_PM <= 15 THEN ROUND((((25 - 0)/(15 - 0))*(AVG_PM - 0)) + 0)
                WHEN AVG_PM <= 25 THEN ROUND((((50 - 26)/(25 - 15.1))*(AVG_PM - 15.1)) + 26)
                WHEN AVG_PM <= 37.5 THEN ROUND((((100 - 51)/(37.5 - 25.1))*(AVG_PM - 25.1)) + 51)
                WHEN AVG_PM <= 75 THEN ROUND((((200 - 101)/(75 - 37.6))*(AVG_PM - 37.6)) + 101)
                ELSE ROUND((((10000000 - 200)/(10000000 - 75.1))*(AVG_PM - 75.1)) + 200)
            END as AQI,
                CASE 
        WHEN DAYOFWEEK(Reading_Time) = 1 THEN 'One'
        WHEN DAYOFWEEK(Reading_Time) = 2 THEN 'Two'
        WHEN DAYOFWEEK(Reading_Time) = 3 THEN 'Three'
        WHEN DAYOFWEEK(Reading_Time) = 4 THEN 'Four'
        WHEN DAYOFWEEK(Reading_Time) = 5 THEN 'Five'
        WHEN DAYOFWEEK(Reading_Time) = 6 THEN 'Six'
        WHEN DAYOFWEEK(Reading_Time) = 7 THEN 'Seven'
    END AS DW,
            day(Reading_Time) Day,
            month(Reading_Time) Month,
    CASE 
        WHEN day(Reading_Time) = 1 THEN 'One'
        WHEN day(Reading_Time) = 2 THEN 'Two'
        WHEN day(Reading_Time) = 3 THEN 'Three'
        WHEN day(Reading_Time) = 4 THEN 'Four'
        WHEN day(Reading_Time) = 5 THEN 'Five'
        WHEN day(Reading_Time) = 6 THEN 'Six'
        WHEN day(Reading_Time) = 7 THEN 'Seven'
        WHEN day(Reading_Time) = 8 THEN 'Eight'
        WHEN day(Reading_Time) = 9 THEN 'Nine'
        WHEN day(Reading_Time) = 10 THEN 'Ten'
        WHEN day(Reading_Time) = 11 THEN 'Eleven'
        WHEN day(Reading_Time) = 12 THEN 'Twelve'
        WHEN day(Reading_Time) = 13 THEN 'Thirteen'
        WHEN day(Reading_Time) = 14 THEN 'Fourteen'
        WHEN day(Reading_Time) = 15 THEN 'Fifteen'
        WHEN day(Reading_Time) = 16 THEN 'Sixteen'
        WHEN day(Reading_Time) = 17 THEN 'Seventeen'
        WHEN day(Reading_Time) = 18 THEN 'Eighteen'
        WHEN day(Reading_Time) = 19 THEN 'Nineteen'
        WHEN day(Reading_Time) = 20 THEN 'Twenty'
        WHEN day(Reading_Time) = 21 THEN 'Twenty-One'
        WHEN day(Reading_Time) = 22 THEN 'Twenty-Two'
        WHEN day(Reading_Time) = 23 THEN 'Twenty-Three'
        WHEN day(Reading_Time) = 24 THEN 'Twenty-Four'
        WHEN day(Reading_Time) = 25 THEN 'Twenty-Five'
        WHEN day(Reading_Time) = 26 THEN 'Twenty-Six'
        WHEN day(Reading_Time) = 27 THEN 'Twenty-Seven'
        WHEN day(Reading_Time) = 28 THEN 'Twenty-Eight'
        WHEN day(Reading_Time) = 29 THEN 'Twenty-Nine'
        WHEN day(Reading_Time) = 30 THEN 'Thirty'
        WHEN day(Reading_Time) = 31 THEN 'Thirty-One'
    END AS Day_Nom,
    CASE 
        WHEN month(Reading_Time) = 1 THEN 'One'
        WHEN month(Reading_Time) = 2 THEN 'Two'
        WHEN month(Reading_Time) = 3 THEN 'Three'
        WHEN month(Reading_Time) = 4 THEN 'Four'
        WHEN month(Reading_Time) = 5 THEN 'Five'
        WHEN month(Reading_Time) = 6 THEN 'Six'
        WHEN month(Reading_Time) = 7 THEN 'Seven'
        WHEN month(Reading_Time) = 8 THEN 'Eight'
        WHEN month(Reading_Time) = 9 THEN 'Nine'
        WHEN month(Reading_Time) = 10 THEN 'Ten'
        WHEN month(Reading_Time) = 11 THEN 'Eleven'
        WHEN month(Reading_Time) = 12 THEN 'Twelve'
    END AS Month_Nom,
            year(Reading_Time) Year,
            hour(Reading_Time) Time,
    CASE
                WHEN hour(Reading_Time) >= 6 AND hour(Reading_Time) < 18 THEN 'Day'
        ELSE 'Night'
    END AS Time_Nom,
            DATE_FORMAT(Reading_Time, '%m-%d') AS Formatted_Reading_Time,
            CASE
                WHEN AVG_PM <= 15 THEN '5'
                WHEN AVG_PM <= 25 THEN '4'
                WHEN AVG_PM <= 37.5 THEN '3'
                WHEN AVG_PM <= 75 THEN '2'
                ELSE '1'
            END AS Status,
            CASE
                WHEN AVG_PM <= 15 THEN 'Very Good'
                WHEN AVG_PM <= 25 THEN 'Good'
                WHEN AVG_PM <= 37.5 THEN 'Moderate'
                WHEN AVG_PM <= 75 THEN 'Bad'
                ELSE 'Very Bad'
            END AS Status_Nom
            FROM 
            value_tb 
            WHERE 
            PM<>0 AND Humidity<>0 AND Air_Pressure<>0 AND Temperature <>0
            AND AVG_PM IS NOT NULL
    '''

    query2 = '''
        SELECT * FROM
        (SELECT
            ID,
            Temperature, 
            
            Humidity, 
            Air_Pressure, 
            Wind_Speed, 
            Wind_Direction,
        CASE
            WHEN AVG_PM <= 15 THEN ROUND((((25 - 0)/(15 - 0))*(AVG_PM - 0)) + 0)
            WHEN AVG_PM <= 25 THEN ROUND((((50 - 26)/(25 - 15.1))*(AVG_PM - 15.1)) + 26)
            WHEN AVG_PM <= 37.5 THEN ROUND((((100 - 51)/(37.5 - 25.1))*(AVG_PM - 25.1)) + 51)
            WHEN AVG_PM <= 75 THEN ROUND((((200 - 101)/(75 - 37.6))*(AVG_PM - 37.6)) + 101)
            ELSE ROUND((((10000000 - 200)/(10000000 - 75.1))*(AVG_PM - 75.1)) + 200)
        END as AQI
        FROM 
            value_tb 
        WHERE 
            PM<>0 AND Humidity<>0 AND Air_Pressure<>0 
            AND AVG_PM IS NOT NULL
            ORDER BY ID DESC
            LIMIT 120)AS t1
    ORDER BY t1.ID;
    '''

    query3 = '''
        SELECT * FROM
        (SELECT
            ID,
        CASE
            WHEN AVG_PM <= 15 THEN ROUND((((25 - 0)/(15 - 0))*(AVG_PM - 0)) + 0)
            WHEN AVG_PM <= 25 THEN ROUND((((50 - 26)/(25 - 15.1))*(AVG_PM - 15.1)) + 26)
            WHEN AVG_PM <= 37.5 THEN ROUND((((100 - 51)/(37.5 - 25.1))*(AVG_PM - 25.1)) + 51)
            WHEN AVG_PM <= 75 THEN ROUND((((200 - 101)/(75 - 37.6))*(AVG_PM - 37.6)) + 101)
            ELSE ROUND((((10000000 - 200)/(10000000 - 75.1))*(AVG_PM - 75.1)) + 200)
        END as AQI
        FROM 
            value_tb 
        WHERE 
            PM<>0 AND Humidity<>0 AND Air_Pressure<>0 
            AND AVG_PM IS NOT NULL
            ORDER BY ID DESC
            LIMIT 48)AS t1
    ORDER BY t1.ID;
    '''

    data_processor = PredictController(host, user, password, database)

    df1 = data_processor.execute_query(query1)
    df2 = data_processor.execute_query(query2)
    df3 = data_processor.execute_query(query3)

    data_processor.createDataset(df1, 'dataset.csv')
    data_processor.createDataset(df2, 'MVA.csv')
    data_processor.createDataset(df3, 'MVA_AQI.csv')

    data_processor.Predict()
