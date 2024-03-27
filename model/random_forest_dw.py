import pandas as pd
from sklearn.model_selection import train_test_split
from sklearn.ensemble import RandomForestClassifier
from sklearn.metrics import accuracy_score, classification_report
import numpy as np
from datetime import datetime, timedelta
import pymysql

df = pd.read_csv('model/dataset/dataset.csv')

X = df[['Temperature', 'Humidity', 'Air_Pressure', 'Wind_Speed', 'Wind_Direction', 'DW','Time']]
y = df['Status']

X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.3, random_state=101)

rf_classifier = RandomForestClassifier(n_estimators=100)
rf_classifier.fit(X_train, y_train)

y_pred = rf_classifier.predict(X_test)

# DMYT
D = df['Day'].iloc[-1]
M = df['Month'].iloc[-1]
Y = df['Year'].iloc[-1]
T = df['Time'].iloc[-1]

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

dfm = pd.read_csv('model/dataset/MVA.csv')

window_size = 120 

for _ in range(window_size):
    dfm.loc[len(dfm)] = [None] * len(dfm.columns)
    
dfm['Temp Average'] = dfm['Temperature'].rolling(window=window_size, min_periods=1).mean()
dfm['Humidity Average'] = dfm['Humidity'].rolling(window=window_size, min_periods=1).mean()
dfm['Air_Pressure Average'] = dfm['Air_Pressure'].rolling(window=window_size, min_periods=1).mean()
dfm['Wind_Speed Average'] = dfm['Wind_Speed'].rolling(window=window_size, min_periods=1).mean()
dfm['Wind_Direction Average'] = dfm['Wind_Direction'].rolling(window=window_size, min_periods=1).mean()

hr_24 = 24

for x in range(window_size-hr_24):
    i = 1
    Rows = len(dfm.index)-i
    dfm = dfm.drop(Rows)
    i += 1

hr_1_temp = dfm['Temp Average'].iloc[-24]
hr_3_temp = dfm['Temp Average'].iloc[-22]
hr_6_temp = dfm['Temp Average'].iloc[-19]
hr_12_temp = dfm['Temp Average'].iloc[-13]
hr_24_temp = dfm['Temp Average'].iloc[-1]

hr_1_Humidity = dfm['Humidity Average'].iloc[-24]
hr_3_Humidity = dfm['Humidity Average'].iloc[-22]
hr_6_Humidity = dfm['Humidity Average'].iloc[-19]
hr_12_Humidity = dfm['Humidity Average'].iloc[-13]
hr_24_Humidity = dfm['Humidity Average'].iloc[-1]

hr_1_Air_Pressure = dfm['Air_Pressure Average'].iloc[-24]
hr_3_Air_Pressure = dfm['Air_Pressure Average'].iloc[-22]
hr_6_Air_Pressure = dfm['Air_Pressure Average'].iloc[-19]
hr_12_Air_Pressure = dfm['Air_Pressure Average'].iloc[-13]
hr_24_Air_Pressure = dfm['Air_Pressure Average'].iloc[-1]

hr_1_Wind_Speed = dfm['Wind_Speed Average'].iloc[-24]
hr_3_Wind_Speed = dfm['Wind_Speed Average'].iloc[-22]
hr_6_Wind_Speed = dfm['Wind_Speed Average'].iloc[-19]
hr_12_Wind_Speed = dfm['Wind_Speed Average'].iloc[-13]
hr_24_Wind_Speed = dfm['Wind_Speed Average'].iloc[-1]

hr_1_Wind_Direction = dfm['Wind_Direction Average'].iloc[-24]
hr_3_Wind_Direction = dfm['Wind_Direction Average'].iloc[-22]
hr_6_Wind_Direction = dfm['Wind_Direction Average'].iloc[-19]
hr_12_Wind_Direction = dfm['Wind_Direction Average'].iloc[-13]
hr_24_Wind_Direction = dfm['Wind_Direction Average'].iloc[-1]

accuracy = accuracy_score(y_test, y_pred)
classification_report_result = classification_report(y_test, y_pred)
accuracy = round(accuracy * 100, 4)


print(f"Accuracy: {accuracy}%")

custom_1 = pd.DataFrame({
    'Temperature': [hr_1_temp],
    'Humidity': [hr_1_Humidity],
    'Air_Pressure': [hr_1_Air_Pressure],
    'Wind_Speed': [hr_1_Wind_Speed],
    'Wind_Direction': [hr_1_Wind_Direction],
    'DW' : [DW_1],
    'Time' : [T_1]
})

custom_3 = pd.DataFrame({
    'Temperature': [hr_3_temp],
    'Humidity': [hr_3_Humidity],
    'Air_Pressure': [hr_3_Air_Pressure],
    'Wind_Speed': [hr_3_Wind_Speed],
    'Wind_Direction': [hr_3_Wind_Direction],
    'DW' : [DW_3],
    'Time' : [T_3]
})

custom_6 = pd.DataFrame({
    'Temperature': [hr_6_temp],
    'Humidity': [hr_6_Humidity],
    'Air_Pressure': [hr_6_Air_Pressure],
    'Wind_Speed': [hr_6_Wind_Speed],
    'Wind_Direction': [hr_6_Wind_Direction],
    'DW' : [DW_6],
    'Time' : [T_6]
})

custom_12 = pd.DataFrame({
    'Temperature': [hr_12_temp],
    'Humidity': [hr_12_Humidity],
    'Air_Pressure': [hr_12_Air_Pressure],
    'Wind_Speed': [hr_12_Wind_Speed],
    'Wind_Direction': [hr_12_Wind_Direction],
    'DW' : [DW_12],
    'Time' : [T_12]
})

custom_24 = pd.DataFrame({
    'Temperature': [hr_24_temp],
    'Humidity': [hr_24_Humidity],
    'Air_Pressure': [hr_24_Air_Pressure],
    'Wind_Speed': [hr_24_Wind_Speed],
    'Wind_Direction': [hr_24_Wind_Direction],
    'DW' : [DW_24],
    'Time' : [T_24]
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

host = 'localhost'
user = 'root'
password = '123456789'
database = 'pm_db'

connection = pymysql.connect(host=host, user=user, password=password, database=database)

cursor = connection.cursor()

sql_insert_query = "INSERT INTO predicted_tb_dw  (prediction_1_hour, prediction_3_hours, prediction_6_hours, prediction_12_hours, prediction_24_hours) VALUES (%s, %s, %s, %s, %s)"

data_to_insert = (predicted_1[0], predicted_3[0], predicted_6[0], predicted_12[0], predicted_24[0])

cursor.execute(sql_insert_query, data_to_insert)

connection.commit()

cursor.close()
connection.close()

