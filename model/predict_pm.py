from datetime import datetime
import pandas as pd
import pymysql
import os
import subprocess

current_time = datetime.now()
current_time_query = current_time.strftime("%Y%m%d %H:%M:%S")
host = 'localhost'
user = 'root'
password = '123456789'
database = 'pm_db'

# SQL query
query = f'''
    SELECT 
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
        day(Reading_Time) Day,
        month(Reading_Time) Month,
        year(Reading_Time) Year,
        hour(Reading_Time) Time,
        CASE
            WHEN AVG_PM <= 15 THEN 5
            WHEN AVG_PM <= 25 THEN 4
            WHEN AVG_PM <= 37.5 THEN 3
            WHEN AVG_PM <= 75 THEN 2
            ELSE 1
        END AS Status
    FROM 
        value_tb 
    WHERE 
        PM<>0 AND Humidity<>0 AND Air_Pressure<>0 
        AND AVG_PM IS NOT NULL
        AND Reading_Time BETWEEN STR_TO_DATE('20231122 21:49:00', '%Y%m%d %H:%i:%s') AND STR_TO_DATE('{current_time_query}', '%Y%m%d %H:%i:%s');
    '''

query2 = f'''
    SELECT * FROM
        (SELECT
            ID,
            Temperature, 
            Humidity, 
            Air_Pressure, 
            Wind_Speed, 
            Wind_Direction
        FROM 
            value_tb 
        WHERE 
            PM<>0 AND Humidity<>0 AND Air_Pressure<>0 
            AND AVG_PM IS NOT NULL
            ORDER BY ID DESC
            LIMIT 120)AS t1
    ORDER BY t1.ID;
    '''

# Create a connection to MySQL
connection = pymysql.connect(host=host, user=user, password=password, database=database)

# Execute the query and fetch the results into a DataFrame
df = pd.read_sql(query, connection)
df2 = pd.read_sql(query2, connection)

# Close the MySQL connection
connection.close()

def get_script_directory():
    return os.path.dirname(os.path.abspath(__file__))
# Get the script directory
script_directory = get_script_directory()

# Specify the relative path for the CSV file within the script directory
csv_file_relative_path = os.path.join('dataset', 'dataset.csv')
csv_file_relative_path2 = os.path.join('dataset', 'MVA.csv')

# Save the DataFrame to a CSV file
df.to_csv(os.path.join(script_directory, csv_file_relative_path), index=False)
df2.to_csv(os.path.join(script_directory, csv_file_relative_path2), index=False)

# Use subprocess to call the script
subprocess.run(['python', 'model/random_forest.py'])
subprocess.run(['python', 'model/forest_regression.py'])
subprocess.run(['python', 'model/forest_aqi.py'])