#!/usr/bin/python

# Programa principal para agregar alarmas por nodo.
#
# DEPENDENCIAS:
# - psycopg2 (2.7 o superior)
# 
# Instalar pip para python3:
# sudo apt-get install python3-pip
# pip3 install psycopg2

# Configuracion
#################################################################
# Fichero de alarmas que procesar.
alarms_file = 'examples/node_alarms.csv'

# Delimitador del fichero de entrada.
delimiter = ';'

# Configuracion base de datos.
dbname = 'rtm'
host = 'localhost'
user = 'postgres'
password = 'secret'

# Esquema/Tabla en la que guardar las alarmas.
table = 'public.node_alarms'

# Numero maximo de elementos a incluir en cada sentencia.
# Si hay mas elementos se ejecutara mas de una sentencia.
page_size = 100
#################################################################


import sys
from datetime import datetime
import psycopg2, psycopg2.extras


if __name__=='__main__':

	# Muestro la version de psycopg2
	#print("psycopg2 version: " + psycopg2.__version__)
	
	# Hora de incicio del proceso.
	now = datetime.now().strftime('%Y-%m-%d %H:%M:%S')

	# Mapeo el fichero de alarmas.
	alarms = []
	with open(alarms_file, "r") as file:
		for line in file:
			words = line.split(delimiter)
			if len(words) == 9:
				alarms.append([
					words[0].upper().strip(),
					words[1].lower().strip(),
					words[2].lower().strip(),
					now,
					words[3].strip(),
					words[4].strip(),
					words[5].strip(),
					words[6].strip(),
					words[7].strip(),
					words[8].strip()
				])

	# Establezco la conexion a la base de datos y creo el cursor.
	try:
		conn = psycopg2.connect(dbname=dbname, user=user, host=host, password=password)
		# conn.autocommit = True
		cursor = conn.cursor()
	except:
		print("Unable to connect to the database.")
		sys.exit()

	try:
		# Guardo las alarmas en la base de datos.
		psycopg2.extras.execute_values(cursor,
			"INSERT INTO " + table + " (node, vendor, tech, created_at, alarm_date, severity, type, name, information, cause) VALUES %s",
			alarms,
			page_size=page_size
		)
		conn.commit()
	except psycopg2.OperationalError as e:
		print("Could not update the node alarms table!")

	cursor.close()
