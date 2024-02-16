import pandas as pd
from sklearn.model_selection import train_test_split
from sklearn.ensemble import RandomForestClassifier
from sklearn.metrics import accuracy_score, classification_report
import numpy as np
from datetime import datetime, timedelta
import pymysql
# เอาขึ้น Linux ห้าม Comment TH ############################################################################

# อ่านข้อมูลจากไฟล์ CSV
df = pd.read_csv('model/dataset/dataset.csv')

# เลือก features และ target variable
X = df[['Temperature', 'Humidity', 'Air_Pressure', 'Wind_Speed', 'Wind_Direction', 'Day', 'Month', 'Year', 'Time']]
y = df['Status']
 
# แบ่งข้อมูลเป็นชุดฝึกและทดสอบ
X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.3, random_state=101)

# สร้างและฝึกโมเดล RandomForestClassifier
rf_classifier = RandomForestClassifier(n_estimators=100)
rf_classifier.fit(X_train, y_train)

# ทำนาย
y_pred = rf_classifier.predict(X_test)

# DMYT
D = df['Day'].iloc[-1]
M = df['Month'].iloc[-1]
Y = df['Year'].iloc[-1]
T = df['Time'].iloc[-1]
# สร้างวันที่และเวลาจากคอลัมน์ที่มีข้อมูลล่าสุด
Date = datetime.strptime(f"{Y}-{M}-{D} {T}", "%Y-%m-%d %H")

# เพิ่ม 6 ชั่วโมง
Date_6 = Date + timedelta(hours=6)
Date_12 = Date + timedelta(hours=12)
Date_24 = Date + timedelta(hours=24)

D_6 = Date_6.day
M_6 = Date_6.month
Y_6 = Date_6.year
T_6 = Date_6.hour

D_12 = Date_12.day
M_12 = Date_12.month
Y_12 = Date_12.year
T_12 = Date_12.hour

D_24 = Date_24.day
M_24 = Date_24.month
Y_24 = Date_24.year
T_24 = Date_24.hour

# อ่านข้อมูลจากไฟล์ CSV
dfm = pd.read_csv('model/dataset/MVA.csv')

# จำนวนข้อมูล None ที่ต้องการเพิ่ม
# ตั้งค่า window size
window_size = 120 # 120 = 5 วัน วันละ 24 hr. 24 * 5 = 120

# เพิ่มข้อมูล None ในคอลัมน์ 'Temperature'
for _ in range(window_size):
    dfm.loc[len(dfm)] = [None] * len(dfm.columns)
    
# คำนวณ Moving Average
dfm['Temp Average'] = dfm['Temperature'].rolling(window=window_size, min_periods=1).mean()
dfm['Humidity Average'] = dfm['Humidity'].rolling(window=window_size, min_periods=1).mean()
dfm['Air_Pressure Average'] = dfm['Air_Pressure'].rolling(window=window_size, min_periods=1).mean()
dfm['Wind_Speed Average'] = dfm['Wind_Speed'].rolling(window=window_size, min_periods=1).mean()
dfm['Wind_Direction Average'] = dfm['Wind_Direction'].rolling(window=window_size, min_periods=1).mean()

#ต้องการให้ไปข้างหน้ากี่ frame
hr_24 = 24

for x in range(window_size-hr_24):
    i = 1
    Rows = len(dfm.index)-i
    dfm = dfm.drop(Rows)
    i += 1

hr_6_temp = dfm['Temp Average'].iloc[-19]
hr_12_temp = dfm['Temp Average'].iloc[-13]
hr_24_temp = dfm['Temp Average'].iloc[-1]

hr_6_Humidity = dfm['Humidity Average'].iloc[-19]
hr_12_Humidity = dfm['Humidity Average'].iloc[-13]
hr_24_Humidity = dfm['Humidity Average'].iloc[-1]

hr_6_Air_Pressure = dfm['Air_Pressure Average'].iloc[-19]
hr_12_Air_Pressure = dfm['Air_Pressure Average'].iloc[-13]
hr_24_Air_Pressure = dfm['Air_Pressure Average'].iloc[-1]

hr_6_Wind_Speed = dfm['Wind_Speed Average'].iloc[-19]
hr_12_Wind_Speed = dfm['Wind_Speed Average'].iloc[-13]
hr_24_Wind_Speed = dfm['Wind_Speed Average'].iloc[-1]

hr_6_Wind_Direction = dfm['Wind_Direction Average'].iloc[-19]
hr_12_Wind_Direction = dfm['Wind_Direction Average'].iloc[-13]
hr_24_Wind_Direction = dfm['Wind_Direction Average'].iloc[-1]

# คำนวณค่าความแม่นยำ (accuracy) และรายงานผลการจำแนกประเภท
accuracy = accuracy_score(y_test, y_pred)
classification_report_result = classification_report(y_test, y_pred)
accuracy = round(accuracy * 100, 4)

# แสดงผลลัพธ์
print(f"Accuracy: {accuracy}%")
#print("Classification Report:")
#print(classification_report_result)

# แสดงผลลัพธ์ทำนาย  
custom_6 = pd.DataFrame({
    'Temperature': [hr_6_temp],
    'Humidity': [hr_6_Humidity],
    'Air_Pressure': [hr_6_Air_Pressure],
    'Wind_Speed': [hr_6_Wind_Speed],
    'Wind_Direction': [hr_6_Wind_Direction],
    'Day' : [D_6], 
    'Month' : [M_6],
    'Year' : [Y_6],
    'Time' : [T_6]
})

custom_12 = pd.DataFrame({
    'Temperature': [hr_12_temp],
    'Humidity': [hr_12_Humidity],
    'Air_Pressure': [hr_12_Air_Pressure],
    'Wind_Speed': [hr_12_Wind_Speed],
    'Wind_Direction': [hr_12_Wind_Direction],
    'Day' : [D_12], 
    'Month' : [M_12],
    'Year' : [Y_12],
    'Time' : [T_12]
})

custom_24 = pd.DataFrame({
    'Temperature': [hr_24_temp],
    'Humidity': [hr_24_Humidity],
    'Air_Pressure': [hr_24_Air_Pressure],
    'Wind_Speed': [hr_24_Wind_Speed],
    'Wind_Direction': [hr_24_Wind_Direction],
    'Day' : [D_24], 
    'Month' : [M_24],
    'Year' : [Y_24],
    'Time' : [T_24]
})

# ทำนายค่า y ด้วยโมเดลที่ถูกฝึก
predicted_6 = rf_classifier.predict(custom_6)
print('')
print(f'Predicted 6 hr : {predicted_6[0]}')
print('')
predicted_12 = rf_classifier.predict(custom_12)
print(f'Predicted 12 hr : {predicted_12[0]}')
print('')
predicted_24 = rf_classifier.predict(custom_24)
print(f'Predicted 24 hr : {predicted_24[0]}')

# ข้อมูลการเชื่อมต่อ
host = 'localhost'
user = 'root'
password = '123456789'
database = 'pm_db'

# เชื่อมต่อกับ MySQL
connection = pymysql.connect(host=host, user=user, password=password, database=database)

# สร้าง Cursor Object
cursor = connection.cursor()

# SQL Query สำหรับการเพิ่มข้อมูล
sql_insert_query = "INSERT INTO predicted_tb (prediction_6_hours, prediction_12_hours, prediction_24_hours) VALUES (%s, %s, %s)"

# ข้อมูลที่ต้องการเพิ่ม
data_to_insert = (predicted_6[0], predicted_12[0], predicted_24[0])

# Execute Query
cursor.execute(sql_insert_query, data_to_insert)

# Commit การเปลี่ยนแปลง
connection.commit()

# ปิด Cursor และ Connection
cursor.close()
connection.close()

