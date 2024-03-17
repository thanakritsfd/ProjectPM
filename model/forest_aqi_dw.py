from sklearn.metrics import mean_squared_error
import numpy as np
import pandas as pd
from sklearn.ensemble import RandomForestRegressor
from datetime import datetime, timedelta
from sklearn.model_selection import train_test_split
from sklearn.ensemble import RandomForestClassifier
from sklearn.metrics import accuracy_score, classification_report
import pymysql

df = pd.read_csv('model/dataset/dataset.csv')
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

def calculate_metrics(df, target_column, features_columns):
    df = pd.read_csv(df)

    X = df[features_columns]
    y = df[target_column]

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

result_AQI = calculate_metrics('model/dataset/dataset.csv', 'Status', ['DW', 'Time'])

predicted_aqi_1_hours = result_AQI[f'Predicted Status in 1 hours'].item()
predicted_aqi_3_hours = result_AQI[f'Predicted Status in 3 hours'].item()
predicted_aqi_6_hours = result_AQI[f'Predicted Status in 6 hours'].item()
predicted_aqi_12_hours = result_AQI[f'Predicted Status in 12 hours'].item()
predicted_aqi_24_hours = result_AQI[f'Predicted Status in 24 hours'].item()

print(predicted_aqi_1_hours)
print(predicted_aqi_3_hours)
print(predicted_aqi_6_hours)
print(predicted_aqi_12_hours)
print(predicted_aqi_24_hours)

host = 'localhost'
user = 'root'
password = '123456789'
database = 'pm_db'


connection = pymysql.connect(host=host, user=user, password=password, database=database)

cursor = connection.cursor()

sql_insert_query = "INSERT INTO predicted_tb_fr_aqi_dw (prediction_1_hour, prediction_3_hours, prediction_6_hours, prediction_12_hours, prediction_24_hours) VALUES (%s, %s, %s, %s, %s)"

data_to_insert = (predicted_aqi_1_hours, predicted_aqi_3_hours, predicted_aqi_6_hours, predicted_aqi_12_hours, predicted_aqi_24_hours)

cursor.execute(sql_insert_query, data_to_insert)

connection.commit()

cursor.close()
connection.close()