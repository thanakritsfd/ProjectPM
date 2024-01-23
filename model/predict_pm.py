from datetime import datetime
import pandas as pd
import pymysql
import os
current_time = datetime.now()
current_time_query = current_time.strftime("%Y%m%d %H:%M:%S")
time_now = current_time.strftime("%H:%M")
midnight = datetime.strptime("19:34", "%H:%M").strftime("%H:%M")
if time_now == midnight:
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
            WHEN AVG_PM < 16 THEN ROUND((((25 - 0)/(15 - 0))*(AVG_PM - 0)) + 0)
            WHEN AVG_PM < 26 THEN ROUND((((50 - 26)/(25 - 15.1))*(AVG_PM - 15.1)) + 26)
            WHEN AVG_PM < 37.6 THEN ROUND((((100 - 51)/(37.5 - 25.1))*(AVG_PM - 25.1)) + 51)
            WHEN AVG_PM < 76 THEN ROUND((((200 - 101)/(75 - 37.6))*(AVG_PM - 37.6)) + 101)
            ELSE ROUND((((10000000 - 200)/(10000000 - 75.1))*(AVG_PM - 75.1)) + 200)
        END as AQI,
        UNIX_TIMESTAMP(Reading_Time) AS Unix
    FROM 
        value_tb 
    WHERE 
        PM<>0 AND Humidity<>0 AND Air_Pressure<>0 
        AND Reading_Time BETWEEN '20231122 21:49:00' AND '{current_time_query} 23:59:59';
    '''

    # Create a connection to MySQL
    connection = pymysql.connect(host=host, user=user, password=password, database=database)

    # Execute the query and fetch the results into a DataFrame
    df = pd.read_sql(query, connection)

    # Close the MySQL connection
    connection.close()

    def get_script_directory():
        return os.path.dirname(os.path.abspath(__file__))
    # Get the script directory
    script_directory = get_script_directory()

    # Specify the relative path for the CSV file within the script directory
    csv_file_relative_path = os.path.join('dataset', 'dataset.csv')

    # Save the DataFrame to a CSV file
    df.to_csv(os.path.join(script_directory, csv_file_relative_path), index=False)