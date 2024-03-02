import pandas as pd
from sklearn.model_selection import train_test_split
from sklearn.ensemble import RandomForestClassifier
from sklearn.metrics import accuracy_score, classification_report
import numpy as np
from datetime import datetime, timedelta
import pymysql

dfm = pd.read_csv('model/dataset/MVA.csv')

window_size = 120

for _ in range(window_size):
    dfm.loc[len(dfm)] = [None] * len(dfm.columns)
    
dfm['AQI Average'] = dfm['AQI'].rolling(window=window_size, min_periods=1).mean()

hr_24 = 24

for x in range(window_size-hr_24):
    i = 1
    Rows = len(dfm.index)-i
    dfm = dfm.drop(Rows)
    i += 1

hr_6_AQI = dfm['AQI Average'].iloc[-19]
hr_12_AQI = dfm['AQI Average'].iloc[-13]
hr_24_AQI = dfm['AQI Average'].iloc[-1]

def map_actual_value(AQI):
    if AQI <= 25:
        return 5
    elif AQI <= 50:
        return 4
    elif AQI <= 100:
        return 3
    elif AQI <= 200:
        return 2
    else:
        return 1

# Map predicted AQI values to actual values
actual_value_6_hours = map_actual_value(hr_6_AQI)
actual_value_12_hours = map_actual_value(hr_12_AQI)
actual_value_24_hours = map_actual_value(hr_24_AQI)

host = 'localhost'
user = 'root'
password = '123456789'
database = 'pm_db'

connection = pymysql.connect(host=host, user=user, password=password, database=database)

cursor = connection.cursor()

sql_insert_query = "INSERT INTO predicted_tb_mva_aqi (prediction_6_hours, prediction_12_hours, prediction_24_hours) VALUES (%s, %s, %s)"

data_to_insert = (actual_value_6_hours, actual_value_12_hours, actual_value_24_hours)

cursor.execute(sql_insert_query, data_to_insert)

connection.commit()

cursor.close()
connection.close()