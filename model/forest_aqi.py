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

def calculate_metrics(df, target_column, features_columns):
    df = pd.read_csv(df)

    X = df[features_columns]
    y = df[target_column]

    rf_regressor = RandomForestRegressor(n_estimators=100)
    rf_regressor.fit(X, y)

    custom_6 = pd.DataFrame({
        'Day': [D_6],
        'Month': [M_6],
        'Year': [Y_6],
        'Time': [T_6]
    })

    custom_12 = pd.DataFrame({
        'Day': [D_12],
        'Month': [M_12],
        'Year': [Y_12],
        'Time': [T_12]
    })

    custom_24 = pd.DataFrame({
        'Day': [D_24],
        'Month': [M_24],
        'Year': [Y_24],
        'Time': [T_24]
    })

    predicted_6 = rf_regressor.predict(custom_6)[0]
    predicted_12 = rf_regressor.predict(custom_12)[0]
    predicted_24 = rf_regressor.predict(custom_24)[0]

    result_dict = {
        f'Predicted {target_column} in 6 hours': predicted_6,
        f'Predicted {target_column} in 12 hours': predicted_12,
        f'Predicted {target_column} in 24 hours': predicted_24
    }

    return result_dict

result_AQI = calculate_metrics('model/dataset/dataset.csv', 'AQI', ['Day', 'Month', 'Year', 'Time'])

print(f"Predicted AQI in 6 hours: {result_AQI[f'Predicted AQI in 6 hours']}")
print(f"Predicted AQI in 12 hours: {result_AQI[f'Predicted AQI in 12 hours']}")
print(f"Predicted AQI in 24 hours: {result_AQI[f'Predicted AQI in 24 hours']}")

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

predicted_aqi_6_hours = result_AQI[f'Predicted AQI in 6 hours'].item()
predicted_aqi_12_hours = result_AQI[f'Predicted AQI in 12 hours'].item()
predicted_aqi_24_hours = result_AQI[f'Predicted AQI in 24 hours'].item()

# Map predicted AQI values to actual values
actual_value_6_hours = map_actual_value(predicted_aqi_6_hours)
actual_value_12_hours = map_actual_value(predicted_aqi_12_hours)
actual_value_24_hours = map_actual_value(predicted_aqi_24_hours)

print(actual_value_6_hours)
print(actual_value_12_hours)
print(actual_value_24_hours)

host = 'localhost'
user = 'root'
password = '123456789'
database = 'pm_db'


connection = pymysql.connect(host=host, user=user, password=password, database=database)

cursor = connection.cursor()


sql_insert_query = "INSERT INTO predicted_tb_fr_aqi (prediction_6_hours, prediction_12_hours, prediction_24_hours) VALUES (%s, %s, %s)"

data_to_insert = (actual_value_6_hours, actual_value_12_hours, actual_value_24_hours)

cursor.execute(sql_insert_query, data_to_insert)

connection.commit()

cursor.close()
connection.close()