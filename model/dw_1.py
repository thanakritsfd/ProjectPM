from sklearn.metrics import mean_squared_error
import numpy as np
import pandas as pd
from sklearn.ensemble import RandomForestRegressor
from datetime import datetime, timedelta
from sklearn.model_selection import train_test_split
from sklearn.ensemble import RandomForestClassifier
from sklearn.metrics import accuracy_score, classification_report
import pymysql

x = 319; # round dataset
dd = 319; # round dataset
r = 335; # round predict
i = 1; # added hr
# DW_1
df = pd.read_csv('model/dataset/dataset.csv')
D_df = df['Day'].iloc[-dd]
M_df = df['Month'].iloc[-dd]
Y_df = df['Year'].iloc[-dd]
T_df = df['Time'].iloc[-dd]

Date_df = datetime.strptime(f"{Y_df}-{M_df}-{D_df} {T_df}", "%Y-%m-%d %H")

for i in range(r):
    df = pd.read_csv('model/dataset/dataset.csv')
    dw = pd.read_csv('model/dataset/dataset_1_dw.csv')

    D = dw['Day'].iloc[-1]
    M = dw['Month'].iloc[-1]
    Y = dw['Year'].iloc[-1]
    T = dw['Time'].iloc[-1]
    
    # print("dw",dw['ID'].iloc[-1])
    # print("df",df['ID'].iloc[-x])

    Date = datetime.strptime(f"{Y}-{M}-{D} {T}", "%Y-%m-%d %H")

    Date_1 = Date + timedelta(hours=1)
    Date_3 = Date + timedelta(hours=3)
    Date_6 = Date + timedelta(hours=6)
    Date_12 = Date + timedelta(hours=12)
    Date_24 = Date + timedelta(hours=24)

    # python day of week to mysql format
    def python_to_mysql_day(python_day):
        # Python: 0 (Monday) -> MySQL: 2 (Monday)
        # Python: 1 (Tuesday) -> MySQL: 3 (Tuesday)
        # Python: 2 (Wednesday) -> MySQL: 4 (Wednesday)
        # Python: 3 (Thursday) -> MySQL: 5 (Thursday)
        # Python: 4 (Friday) -> MySQL: 6 (Friday)
        # Python: 5 (Saturday) -> MySQL: 7 (Saturday)
        # Python: 6 (Sunday) -> MySQL: 1 (Sunday)
        return (python_day + 1) % 7 + 1

    DW_1 = python_to_mysql_day(Date_1.weekday())
    T_1 = Date_1.hour

    DW_3 = python_to_mysql_day(Date_3.weekday())
    T_3 = Date_3.hour

    DW_6 = python_to_mysql_day(Date_6.weekday())
    T_6 = Date_6.hour

    DW_12 = python_to_mysql_day(Date_12.weekday())
    T_12 = Date_12.hour

    DW_24 = python_to_mysql_day(Date_24.weekday())
    T_24 = Date_24.hour

    def calculate_metrics(dw, target_column, features_columns):
        dw = pd.read_csv(dw)

        X = dw[features_columns]
        y = dw[target_column]

        rf_classifier = RandomForestClassifier(n_estimators=100)
        rf_classifier.fit(X, y)

        custom_1 = pd.DataFrame({
            'DW': [DW_1],
            'Time': [T_1]
        })

        custom_3 = pd.DataFrame({
            'DW' : [DW_3],
            'Time': [T_3]
        })

        custom_6 = pd.DataFrame({
            'DW' : [DW_6],
            'Time': [T_6]
        })

        custom_12 = pd.DataFrame({
            'DW' : [DW_12],
            'Time': [T_12]
        })

        custom_24 = pd.DataFrame({
            'DW' : [DW_24],
            'Time': [T_24]
        })

        predicted_1 = rf_classifier.predict(custom_1)[0]
        predicted_3 = rf_classifier.predict(custom_3)[0]
        predicted_6 = rf_classifier.predict(custom_6)[0]
        predicted_12 = rf_classifier.predict(custom_12)[0]
        predicted_24 = rf_classifier.predict(custom_24)[0]

        result_dict = {
            f'Predicted {target_column} in 1 hours': predicted_1,
            f'Predicted {target_column} in 3 hours': predicted_3,
            f'Predicted {target_column} in 6 hours': predicted_6,
            f'Predicted {target_column} in 12 hours': predicted_12,
            f'Predicted {target_column} in 24 hours': predicted_24
        }

        return result_dict

    result_AQI = calculate_metrics('model/dataset/dataset_1_dw.csv', 'Status', ['DW', 'Time'])

    predicted_aqi_1_hours = result_AQI[f'Predicted Status in 1 hours'].item()
    predicted_aqi_3_hours = result_AQI[f'Predicted Status in 3 hours'].item()
    predicted_aqi_6_hours = result_AQI[f'Predicted Status in 6 hours'].item()
    predicted_aqi_12_hours = result_AQI[f'Predicted Status in 12 hours'].item()
    predicted_aqi_24_hours = result_AQI[f'Predicted Status in 24 hours'].item()


    Date_predict = Date_df + timedelta(hours=i)

    host = 'localhost'
    user = 'root'
    password = '123456789'
    database = 'pm_db'


    connection = pymysql.connect(host=host, user=user, password=password, database=database)

    cursor = connection.cursor()

    sql_insert_query = "INSERT INTO predicted_tb_fr_aqi_dw (prediction_1_hour, prediction_3_hours, prediction_6_hours, prediction_12_hours, prediction_24_hours, datatime) VALUES (%s, %s, %s, %s, %s, %s)"

    data_to_insert = (predicted_aqi_1_hours, predicted_aqi_3_hours, predicted_aqi_6_hours, predicted_aqi_12_hours, predicted_aqi_24_hours, Date_predict)

    cursor.execute(sql_insert_query, data_to_insert)

    connection.commit()

    cursor.close()
    connection.close()   
    
    if(x >= 1):
        # ดึง record ล่าสุดของ DataFrame df
        latest_record = df.iloc[-x]

        # เพิ่ม record ล่าสุดของ df ลงใน DataFrame dw
        dw = pd.concat([dw, latest_record.to_frame().T], ignore_index=True)

        # แปลงประเภทของคอลัมน์เป็น integer
        dw['ID'] = dw['ID'].astype(int)
        dw['No'] = dw['No'].astype(int)
        dw['Day'] = dw['Day'].astype(int)
        dw['Month'] = dw['Month'].astype(int)
        dw['Year'] = dw['Year'].astype(int)
        dw['Time'] = dw['Time'].astype(int)
        dw['Status'] = dw['Status'].astype(int)
        
        # เรียงลำดับข้อมูลตาม ID
        dw = dw.sort_values(by='ID', ignore_index=True)

        # สามารถเขียนลงไฟล์ CSV ได้ถ้าต้องการ
        dw.to_csv('model/dataset/dataset_1_dw.csv', index=False)
        x = x-1
    i += 1
    # print(Date_predict)
    
    