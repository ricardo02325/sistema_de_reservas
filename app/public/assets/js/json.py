import serial
import json
import mysql.connector
from datetime import datetime

# Conexión a la base de datos
conn = mysql.connector.connect(
    host='localhost',
    user='root',     
    password='123',
    database='sistema_hidroponico'
)
cursor = conn.cursor()

ser = serial.Serial('/dev/ttyUSB0', 9600)

try:
    while True:
        line = ser.readline().decode('utf-8').strip()
        if line:
            try:
                data = json.loads(line)
                ph = float(data['ph'])  # Asegura que sea float
                voltage = data['voltage']
                raw = data['raw']

                print(f"pH: {ph} | Voltage: {voltage} V | Raw: {raw}")

                # Insertar en la base de datos
                insert_query = """
                    INSERT INTO lecturas_sensores (id_sensor, valor, fecha_hora)
                    VALUES (%s, %s, %s)
                """
                now = datetime.now().strftime('%Y-%m-%d %H:%M:%S')
                cursor.execute(insert_query, (1, ph, now))
                conn.commit()

            except json.JSONDecodeError:
                print("Error al decodificar:", line)
            except KeyError as e:
                print(f"Falta una clave esperada en los datos: {e}")
except KeyboardInterrupt:
    print("Finalizando...")
finally:
    cursor.close()
    conn.close()
    ser.close()
