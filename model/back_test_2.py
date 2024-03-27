from sklearn.metrics import mean_squared_error
import numpy as np
import pandas as pd
from sklearn.ensemble import RandomForestClassifier
from datetime import datetime, timedelta
from sklearn.model_selection import train_test_split
from sklearn.ensemble import RandomForestClassifier
from sklearn.metrics import accuracy_score, classification_report
import pymysql

x = 540; # round dataset
dd = 540; # round dataset
r = 564; # round predict
h = 1; # added hr
# DW_1
df = pd.read_csv('model/dataset/dataset.csv')
D_df = df['Day'].iloc[-dd]
M_df = df['Month'].iloc[-dd]
Y_df = df['Year'].iloc[-dd]
T_df = df['Time'].iloc[-dd]

Date_df = datetime.strptime(f"{Y_df}-{M_df}-{D_df} {T_df}", "%Y-%m-%d %H")

for h in range(r):
    df = pd.read_csv('model/dataset/dataset.csv')
    dw = pd.read_csv('model/dataset/dataset_1_dw.csv')

    X_encoded = pd.get_dummies(dw[['Day_Nom', 'Month_Nom', 'Time_Nom']])

    other_features = dw[['Temperature', 'Humidity', 'Air_Pressure', 'Wind_Speed', 'Wind_Direction']]

    X = pd.concat([other_features, X_encoded], axis=1)
    y = dw['Status']
    
    X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.3, random_state=101)

    rf_classifier = RandomForestClassifier(n_estimators=100)
    rf_classifier.fit(X_train, y_train)

    y_pred = rf_classifier.predict(X_test)
       
    Temperature = dw['Temperature'].iloc[-1]
    Humidity = dw['Humidity'].iloc[-1]
    Air_Pressure = dw['Air_Pressure'].iloc[-1]
    Wind_Speed = dw['Wind_Speed'].iloc[-1]
    Wind_Direction = dw['Wind_Direction'].iloc[-1]
    
    # DMYT
    D = dw['Day'].iloc[-1]
    M = dw['Month'].iloc[-1]
    T = dw['Time'].iloc[-1]
    # สร้างวันที่และเวลาจากคอลัมน์ที่มีข้อมูลล่าสุด
    Date = datetime.strptime(f"{M}-{D} {T}", "%m-%d %H")
    Date_1 = Date + timedelta(hours=1)
    Date_3 = Date + timedelta(hours=3)
    Date_6 = Date + timedelta(hours=6)
    Date_12 = Date + timedelta(hours=12)
    Date_24 = Date + timedelta(hours=24)

    D_1 = Date_1.day
    M_1 = Date_1.month
    T_1 = Date_1.hour

    D_3 = Date_3.day
    M_3 = Date_3.month
    T_3 = Date_3.hour

    D_6 = Date_6.day
    M_6 = Date_6.month
    T_6 = Date_6.hour

    D_12 = Date_12.day
    M_12 = Date_12.month
    T_12 = Date_12.hour

    D_24 = Date_24.day
    M_24 = Date_24.month
    T_24 = Date_24.hour

    def determine_day_night(reading_time):
        if 6 <= reading_time < 18:
            return 'Day'
        else:
            return 'Night'

    accuracy = accuracy_score(y_test, y_pred)
    classification_report_result = classification_report(y_test, y_pred)
    accuracy = round(accuracy * 100, 4)

    print(f"Accuracy: {accuracy}%") 

    custom_1 = pd.DataFrame({
        'Temperature': [Temperature],
        'Humidity': [Humidity],
        'Air_Pressure': [Air_Pressure],
        'Wind_Speed': [Wind_Speed],
        'Wind_Direction': [Wind_Direction],
        'Day_Nom_Eight': [D_1 == 8],
        'Day_Nom_Eighteen': [D_1 == 18],
        'Day_Nom_Eleven': [D_1 == 11],
        'Day_Nom_Fifteen': [D_1 == 15],
        'Day_Nom_Five': [D_1 == 5],
        'Day_Nom_Four': [D_1 == 4],
        'Day_Nom_Fourteen': [D_1 == 14],
        'Day_Nom_Nine': [D_1 == 9],
        'Day_Nom_Nineteen': [D_1 == 19],
        'Day_Nom_One': [D_1 == 1],
        'Day_Nom_Seven': [D_1 == 7],
        'Day_Nom_Seventeen': [D_1 == 17],
        'Day_Nom_Six': [D_1 == 6],
        'Day_Nom_Sixteen': [D_1 == 16],
        'Day_Nom_Ten': [D_1 == 10],
        'Day_Nom_Thirteen': [D_1 == 13],
        'Day_Nom_Thirty': [D_1 == 30],
        'Day_Nom_Thirty-One': [D_1 == 31],
        'Day_Nom_Three': [D_1 == 3],
        'Day_Nom_Twelve': [D_1 == 12],
        'Day_Nom_Twenty': [D_1 == 20],
        'Day_Nom_Twenty-Eight': [D_1 == 28],
        'Day_Nom_Twenty-Five': [D_1 == 25],
        'Day_Nom_Twenty-Four': [D_1 == 24],
        'Day_Nom_Twenty-Nine': [D_1 == 29],
        'Day_Nom_Twenty-One': [D_1 == 21],
        'Day_Nom_Twenty-Seven': [D_1 == 27],
        'Day_Nom_Twenty-Six': [D_1 == 26],
        'Day_Nom_Twenty-Three': [D_1 == 23],
        'Day_Nom_Twenty-Two': [D_1 == 22],
        'Day_Nom_Two': [D_1 == 2],
        # 'Month_Nom_Eight': [M_1 == 8],
        'Month_Nom_Eleven': [M_1 == 11],
        # 'Month_Nom_Five': [M_1 == 5],
        # 'Month_Nom_Four': [M_1 == 4],
        # 'Month_Nom_Nine': [M_1 == 9],
        'Month_Nom_One': [M_1 == 1],
        # 'Month_Nom_Seven': [M_1 == 7],
        # 'Month_Nom_Six': [M_1 == 6],
        # 'Month_Nom_Ten': [M_1 == 10],
        'Month_Nom_Three': [M_1 == 3],
        'Month_Nom_Twelve': [M_1 == 12],
        'Month_Nom_Two': [M_1 == 2],
        'Time_Nom_Day': [determine_day_night(T_1)=="Day"],
        'Time_Nom_Night': [determine_day_night(T_1)=="Night"]
    })

    custom_3 = pd.DataFrame({
        'Temperature': [Temperature],
        'Humidity': [Humidity],
        'Air_Pressure': [Air_Pressure],
        'Wind_Speed': [Wind_Speed],
        'Wind_Direction': [Wind_Direction],
        'Day_Nom_Eight': [D_3 == 8],
        'Day_Nom_Eighteen': [D_3 == 18],
        'Day_Nom_Eleven': [D_3 == 11],
        'Day_Nom_Fifteen': [D_3 == 15],
        'Day_Nom_Five': [D_3 == 5],
        'Day_Nom_Four': [D_3 == 4],
        'Day_Nom_Fourteen': [D_3 == 14],
        'Day_Nom_Nine': [D_3 == 9],
        'Day_Nom_Nineteen': [D_3 == 19],
        'Day_Nom_One': [D_3 == 1],
        'Day_Nom_Seven': [D_3 == 7],
        'Day_Nom_Seventeen': [D_3 == 17],
        'Day_Nom_Six': [D_3 == 6],
        'Day_Nom_Sixteen': [D_3 == 16],
        'Day_Nom_Ten': [D_3 == 10],
        'Day_Nom_Thirteen': [D_3 == 13],
        'Day_Nom_Thirty': [D_3 == 30],
        'Day_Nom_Thirty-One': [D_3 == 31],
        'Day_Nom_Three': [D_3 == 3],
        'Day_Nom_Twelve': [D_3 == 12],
        'Day_Nom_Twenty': [D_3 == 20],
        'Day_Nom_Twenty-Eight': [D_3 == 28],
        'Day_Nom_Twenty-Five': [D_3 == 25],
        'Day_Nom_Twenty-Four': [D_3 == 24],
        'Day_Nom_Twenty-Nine': [D_3 == 29],
        'Day_Nom_Twenty-One': [D_3 == 21],
        'Day_Nom_Twenty-Seven': [D_3 == 27],
        'Day_Nom_Twenty-Six': [D_3 == 26],
        'Day_Nom_Twenty-Three': [D_3 == 23],
        'Day_Nom_Twenty-Two': [D_3 == 22],
        'Day_Nom_Two': [D_3 == 2],
        # 'Month_Nom_Eight': [M_3 == 8],
        'Month_Nom_Eleven': [M_3 == 11],
        # 'Month_Nom_Five': [M_3 == 5],
        # 'Month_Nom_Four': [M_3 == 4],
        # 'Month_Nom_Nine': [M_3 == 9],
        'Month_Nom_One': [M_3 == 1],
        # 'Month_Nom_Seven': [M_3 == 7],
        # 'Month_Nom_Six': [M_3 == 6],
        # 'Month_Nom_Ten': [M_3 == 10],
        'Month_Nom_Three': [M_3 == 3],
        'Month_Nom_Twelve': [M_3 == 12],
        'Month_Nom_Two': [M_3 == 2],
        'Time_Nom_Day': [determine_day_night(T_3)=="Day"],
        'Time_Nom_Night': [determine_day_night(T_3)=="Night"]
    })

    custom_6 = pd.DataFrame({
        'Temperature': [Temperature],
        'Humidity': [Humidity],
        'Air_Pressure': [Air_Pressure],
        'Wind_Speed': [Wind_Speed],
        'Wind_Direction': [Wind_Direction],
        'Day_Nom_Eight': [D_6 == 8],
        'Day_Nom_Eighteen': [D_6 == 18],
        'Day_Nom_Eleven': [D_6 == 11],
        'Day_Nom_Fifteen': [D_6 == 15],
        'Day_Nom_Five': [D_6 == 5],
        'Day_Nom_Four': [D_6 == 4],
        'Day_Nom_Fourteen': [D_6 == 14],
        'Day_Nom_Nine': [D_6 == 9],
        'Day_Nom_Nineteen': [D_6 == 19],
        'Day_Nom_One': [D_6 == 1],
        'Day_Nom_Seven': [D_6 == 7],
        'Day_Nom_Seventeen': [D_6 == 17],
        'Day_Nom_Six': [D_6 == 6],
        'Day_Nom_Sixteen': [D_6 == 16],
        'Day_Nom_Ten': [D_6 == 10],
        'Day_Nom_Thirteen': [D_6 == 13],
        'Day_Nom_Thirty': [D_6 == 30],
        'Day_Nom_Thirty-One': [D_6 == 31],
        'Day_Nom_Three': [D_6 == 3],
        'Day_Nom_Twelve': [D_6 == 12],
        'Day_Nom_Twenty': [D_6 == 20],
        'Day_Nom_Twenty-Eight': [D_6 == 28],
        'Day_Nom_Twenty-Five': [D_6 == 25],
        'Day_Nom_Twenty-Four': [D_6 == 24],
        'Day_Nom_Twenty-Nine': [D_6 == 29],
        'Day_Nom_Twenty-One': [D_6 == 21],
        'Day_Nom_Twenty-Seven': [D_6 == 27],
        'Day_Nom_Twenty-Six': [D_6 == 26],
        'Day_Nom_Twenty-Three': [D_6 == 23],
        'Day_Nom_Twenty-Two': [D_6 == 22],
        'Day_Nom_Two': [D_6 == 2],
        # 'Month_Nom_Eight': [M_6 == 8],
        'Month_Nom_Eleven': [M_6 == 11],
        # 'Month_Nom_Five': [M_6 == 5],
        # 'Month_Nom_Four': [M_6 == 4],
        # 'Month_Nom_Nine': [M_6 == 9],
        'Month_Nom_One': [M_6 == 1],
        # 'Month_Nom_Seven': [M_6 == 7],
        # 'Month_Nom_Six': [M_6 == 6],
        # 'Month_Nom_Ten': [M_6 == 10],
        'Month_Nom_Three': [M_6 == 3],
        'Month_Nom_Twelve': [M_6 == 12],
        'Month_Nom_Two': [M_6 == 2],
        'Time_Nom_Day': [determine_day_night(T_6)=="Day"],
        'Time_Nom_Night': [determine_day_night(T_6)=="Night"]
    })

    custom_12 = pd.DataFrame({
        'Temperature': [Temperature],
        'Humidity': [Humidity],
        'Air_Pressure': [Air_Pressure],
        'Wind_Speed': [Wind_Speed],
        'Wind_Direction': [Wind_Direction],
        'Day_Nom_Eight': [D_12 == 8],
        'Day_Nom_Eighteen': [D_12 == 18],
        'Day_Nom_Eleven': [D_12 == 11],
        'Day_Nom_Fifteen': [D_12 == 15],
        'Day_Nom_Five': [D_12 == 5],
        'Day_Nom_Four': [D_12 == 4],
        'Day_Nom_Fourteen': [D_12 == 14],
        'Day_Nom_Nine': [D_12 == 9],
        'Day_Nom_Nineteen': [D_12 == 19],
        'Day_Nom_One': [D_12 == 1],
        'Day_Nom_Seven': [D_12 == 7],
        'Day_Nom_Seventeen': [D_12 == 17],
        'Day_Nom_Six': [D_12 == 6],
        'Day_Nom_Sixteen': [D_12 == 16],
        'Day_Nom_Ten': [D_12 == 10],
        'Day_Nom_Thirteen': [D_12 == 13],
        'Day_Nom_Thirty': [D_12 == 30],
        'Day_Nom_Thirty-One': [D_12 == 31],
        'Day_Nom_Three': [D_12 == 3],
        'Day_Nom_Twelve': [D_12 == 12],
        'Day_Nom_Twenty': [D_12 == 20],
        'Day_Nom_Twenty-Eight': [D_12 == 28],
        'Day_Nom_Twenty-Five': [D_12 == 25],
        'Day_Nom_Twenty-Four': [D_12 == 24],
        'Day_Nom_Twenty-Nine': [D_12 == 29],
        'Day_Nom_Twenty-One': [D_12 == 21],
        'Day_Nom_Twenty-Seven': [D_12 == 27],
        'Day_Nom_Twenty-Six': [D_12 == 26],
        'Day_Nom_Twenty-Three': [D_12 == 23],
        'Day_Nom_Twenty-Two': [D_12 == 22],
        'Day_Nom_Two': [D_12 == 2],
        # 'Month_Nom_Eight': [M_12 == 8],
        'Month_Nom_Eleven': [M_12 == 11],
        # 'Month_Nom_Five': [M_12 == 5],
        # 'Month_Nom_Four': [M_12 == 4],
        # 'Month_Nom_Nine': [M_12 == 9],
        'Month_Nom_One': [M_12 == 1],
        # 'Month_Nom_Seven': [M_12 == 7],
        # 'Month_Nom_Six': [M_12 == 6],
        # 'Month_Nom_Ten': [M_12 == 10],
        'Month_Nom_Three': [M_12 == 3],
        'Month_Nom_Twelve': [M_12 == 12],
        'Month_Nom_Two': [M_12 == 2],
        'Time_Nom_Day': [determine_day_night(T_12)=="Day"],
        'Time_Nom_Night': [determine_day_night(T_12)=="Night"]
    })

    # สร้าง DataFrame จากข้อมูลที่ให้มา
    custom_24 = pd.DataFrame({
        'Temperature': [Temperature],
        'Humidity': [Humidity],
        'Air_Pressure': [Air_Pressure],
        'Wind_Speed': [Wind_Speed],
        'Wind_Direction': [Wind_Direction],
        'Day_Nom_Eight': [D_24 == 8],
        'Day_Nom_Eighteen': [D_24 == 18],
        'Day_Nom_Eleven': [D_24 == 11],
        'Day_Nom_Fifteen': [D_24 == 15],
        'Day_Nom_Five': [D_24 == 5],
        'Day_Nom_Four': [D_24 == 4],
        'Day_Nom_Fourteen': [D_24 == 14],
        'Day_Nom_Nine': [D_24 == 9],
        'Day_Nom_Nineteen': [D_24 == 19],
        'Day_Nom_One': [D_24 == 1],
        'Day_Nom_Seven': [D_24 == 7],
        'Day_Nom_Seventeen': [D_24 == 17],
        'Day_Nom_Six': [D_24 == 6],
        'Day_Nom_Sixteen': [D_24 == 16],
        'Day_Nom_Ten': [D_24 == 10],
        'Day_Nom_Thirteen': [D_24 == 13],
        'Day_Nom_Thirty': [D_24 == 30],
        'Day_Nom_Thirty-One': [D_24 == 31],
        'Day_Nom_Three': [D_24 == 3],
        'Day_Nom_Twelve': [D_24 == 12],
        'Day_Nom_Twenty': [D_24 == 20],
        'Day_Nom_Twenty-Eight': [D_24 == 28],
        'Day_Nom_Twenty-Five': [D_24 == 25],
        'Day_Nom_Twenty-Four': [D_24 == 24],
        'Day_Nom_Twenty-Nine': [D_24 == 29],
        'Day_Nom_Twenty-One': [D_24 == 21],
        'Day_Nom_Twenty-Seven': [D_24 == 27],
        'Day_Nom_Twenty-Six': [D_24 == 26],
        'Day_Nom_Twenty-Three': [D_24 == 23],
        'Day_Nom_Twenty-Two': [D_24 == 22],
        'Day_Nom_Two': [D_24 == 2],
        # 'Month_Nom_Eight': [M_24 == 8],
        'Month_Nom_Eleven': [M_24 == 11],
        # 'Month_Nom_Five': [M_24 == 5],
        # 'Month_Nom_Four': [M_24 == 4],
        # 'Month_Nom_Nine': [M_24 == 9],
        'Month_Nom_One': [M_24 == 1],
        # 'Month_Nom_Seven': [M_24 == 7],
        # 'Month_Nom_Six': [M_24 == 6],
        # 'Month_Nom_Ten': [M_24 == 10],
        'Month_Nom_Three': [M_24 == 3],
        'Month_Nom_Twelve': [M_24 == 12],
        'Month_Nom_Two': [M_24 == 2],
        'Time_Nom_Day': [determine_day_night(T_24)=="Day"],
        'Time_Nom_Night': [determine_day_night(T_24)=="Night"]
    })

    predicted_1 = rf_classifier.predict(custom_1)
    print('')
    print(f'Predicted 1 hr : {predicted_1[0]}')
    predicted_3 = rf_classifier.predict(custom_3)
    print('')
    print(f'Predicted 3 hr : {predicted_3[0]}')
    predicted_6 = rf_classifier.predict(custom_6)
    print('')
    print(f'Predicted 6 hr : {predicted_6[0]}')
    print('')
    predicted_12 = rf_classifier.predict(custom_12)
    print(f'Predicted 12 hr : {predicted_12[0]}')
    print('')
    predicted_24 = rf_classifier.predict(custom_24)
    print(f'Predicted 24 hr : {predicted_24[0]}')

    Date_predict = Date_df + timedelta(hours=h)

    host = 'localhost'
    user = 'root'
    password = '123456789'
    database = 'pm_db'
    connection = pymysql.connect(host=host, user=user, password=password, database=database)
    cursor = connection.cursor()
    sql_insert_query = "INSERT INTO prediction_tb (prediction_1_hour, prediction_3_hours, prediction_6_hours, prediction_12_hours, prediction_24_hours, datatime) VALUES (%s, %s, %s, %s, %s, %s)"
    data_to_insert = (predicted_1[0], predicted_3[0], predicted_6[0], predicted_12[0], predicted_24[0], Date_predict)
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
    h += 1
    print(Date_predict)
    


    
    