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

result_temperature = calculate_metrics('model/dataset/dataset.csv', 'Temperature', ['Day', 'Month', 'Year', 'Time'])
result_humidity = calculate_metrics('model/dataset/dataset.csv', 'Humidity', ['Day', 'Month', 'Year', 'Time'])
result_air_pressure = calculate_metrics('model/dataset/dataset.csv', 'Air_Pressure', ['Day', 'Month', 'Year', 'Time'])
result_wind_speed = calculate_metrics('model/dataset/dataset.csv', 'Wind_Speed', ['Day', 'Month', 'Year', 'Time'])
result_wind_direction = calculate_metrics('model/dataset/dataset.csv', 'Wind_Direction', ['Day', 'Month', 'Year', 'Time'])

df = pd.read_csv('model/dataset/dataset.csv')

X = df[['Temperature', 'Humidity', 'Air_Pressure', 'Wind_Speed', 'Wind_Direction', 'Day', 'Month', 'Year', 'Time']]
y = df['Status']
 
X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.3, random_state=101)

rf_classifier = RandomForestClassifier(n_estimators=100)
rf_classifier.fit(X_train, y_train)

y_pred = rf_classifier.predict(X_test)

accuracy = accuracy_score(y_test, y_pred)
classification_report_result = classification_report(y_test, y_pred)
accuracy = round(accuracy * 100, 4)

print(f"Accuracy: {accuracy}%")

custom_6_hr = pd.DataFrame({
    'Temperature': [result_temperature[f'Predicted Temperature in 6 hours']],
    'Humidity': [result_humidity[f'Predicted Humidity in 6 hours']],
    'Air_Pressure': [result_air_pressure[f'Predicted Air_Pressure in 6 hours']],
    'Wind_Speed': [result_wind_speed[f'Predicted Wind_Speed in 6 hours']],
    'Wind_Direction': [result_wind_direction[f'Predicted Wind_Direction in 6 hours']],
    'Day': [D_6],
    'Month': [M_6],
    'Year': [Y_6],
    'Time': [T_6]
})

custom_12_hr = pd.DataFrame({
    'Temperature': [result_temperature[f'Predicted Temperature in 12 hours']],
    'Humidity': [result_humidity[f'Predicted Humidity in 12 hours']],
    'Air_Pressure': [result_air_pressure[f'Predicted Air_Pressure in 12 hours']],
    'Wind_Speed': [result_wind_speed[f'Predicted Wind_Speed in 12 hours']],
    'Wind_Direction': [result_wind_direction[f'Predicted Wind_Direction in 12 hours']],
    'Day': [D_12],
    'Month': [M_12],
    'Year': [Y_12],
    'Time': [T_12]
})

custom_24_hr = pd.DataFrame({
    'Temperature': [result_temperature[f'Predicted Temperature in 24 hours']],
    'Humidity': [result_humidity[f'Predicted Humidity in 24 hours']],
    'Air_Pressure': [result_air_pressure[f'Predicted Air_Pressure in 24 hours']],
    'Wind_Speed': [result_wind_speed[f'Predicted Wind_Speed in 24 hours']],
    'Wind_Direction': [result_wind_direction[f'Predicted Wind_Direction in 24 hours']],
    'Day': [D_24],
    'Month': [M_24],
    'Year': [Y_24],
    'Time': [T_24]
})

predicted_6 = rf_classifier.predict(custom_6_hr)
print('')
print(f'Predicted 6 hr : {predicted_6[0]}')
print('')
predicted_12 = rf_classifier.predict(custom_12_hr)
print(f'Predicted 12 hr : {predicted_12[0]}')
print('')
predicted_24 = rf_classifier.predict(custom_24_hr)
print(f'Predicted 24 hr : {predicted_24[0]}')

host = 'localhost'
user = 'root'
password = '123456789'
database = 'pm_db'


connection = pymysql.connect(host=host, user=user, password=password, database=database)

cursor = connection.cursor()


sql_insert_query = "INSERT INTO predicted_tb_fr (prediction_6_hours, prediction_12_hours, prediction_24_hours) VALUES (%s, %s, %s)"

data_to_insert = (predicted_6[0], predicted_12[0], predicted_24[0])

cursor.execute(sql_insert_query, data_to_insert)

connection.commit()

cursor.close()
connection.close()