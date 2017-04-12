#!/usr/bin/python

# Programa principal para agregar nuevas celdas. Cuando se trate de una celda 2G/3G,
# se comprobara que existe la BSC/RNC, de no ser asi tambien se creara.
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
cells_file = 'examples/new_cells.csv'

# Delimitador del fichero de entrada.
delimiter = ';'

# Configuracion base de datos.
dbname = 'rtm'
host = 'localhost'
user = 'postgres'
password = 'secret'

# Esquema/Tabla de las tablas de celdas y controladores.
cells_table = 'public.cells'
controllers_table = 'public.controllers'

# Numero maximo de elementos a incluir en cada sentencia.
# Si hay mas elementos se ejecutara mas de una sentencia.
page_size = 100
#################################################################


import sys
import psycopg2, psycopg2.extras


def get_cells(cursor):
	"""
	Devuelve un diccionario de celdas existentes.
	"""
	cursor.execute('SELECT id, name FROM ' + cells_table)
	cells = cursor.fetchall()
	response = {}
	for cell in cells:
		response[cell[1]] = cell[0]
	return response


def get_controllers(cursor):
	"""
	Devuelve los controladores existentes.
	"""
	cursor.execute('SELECT id, name FROM ' + controllers_table)
	controllers = cursor.fetchall()
	response = {}
	for controller in controllers:
		response[controller[1]] =  controller[0] #{'id': controller[0], 'vendor': controller[2], 'tech': controller[3]}

	return response

def create_new_cell(cursor, cell, vendor, tech, controller_id, province_id):
	"""
	Añado una nueva celda celda.
	"""
	try:
		cursor.execute(
			'INSERT INTO ' + cells_table + ' (name, vendor, tech, controller_id, province_id) VALUES (%s, %s, %s, %s, %s) RETURNING id',
			(cell, vendor, tech, controller_id, province_id)
		)
		return cursor.fetchone()[0]
	except:
		print('Error creating a new cell.')
		print('Cell: ' + cell + ', Vendor: ' + vendor + ', Tech: ' + tech + ', Controller ID: ' + str(controller_id) + ', Province ID: ' + str(province_id))
		return None


def create_new_controller(cursor, controller, vendor, tech, province_id):
	"""
	Añado un nuevo controlador.
	"""
	try:
		cursor.execute(
			'INSERT INTO ' + controllers_table + ' (name, province_id, vendor, tech) VALUES (%s, %s, %s, %s) RETURNING id',
			(controller, province_id, vendor, tech)
		)
		return cursor.fetchone()[0]
	except:
		print('Error creating a new controller.')
		print('Controller: ' + controller + ', Vendor: ' + vendor + ', Tech: ' + tech + ', Province Id: ' + str(province_id))
		return None


if __name__=='__main__':

	# Muestro la version de psycopg2
	#print("psycopg2 version: " + psycopg2.__version__)

	# Mapeo el fichero de celdas.
	new_cells = []
	with open(cells_file, "r") as file:
		for line in file:
			words = line.split(delimiter)
			if len(words) == 4:
				new_cells.append({
					'name': words[0].upper().strip(),
					'vendor': words[1].lower().strip(),
					'tech': words[2].lower().strip(),
					'controller': words[3].upper().strip()
				})

	# Establezco la conexion a la base de datos y creo el cursor.
	try:
		conn = psycopg2.connect(dbname=dbname, user=user, host=host, password=password)
		conn.autocommit = True
		cursor = conn.cursor()
	except:
		print("Unable to connect to the database.")
		sys.exit()

	# Obtengo las celdas existentes en la base de datos.
	cells = get_cells(cursor)

	# Obrtengo los controladores (BSC/RNC) existentes en la base de datos.
	controllers = get_controllers(cursor)

	# Recorro las celdas nuevas.
	for cell in new_cells:

		# Si no existe la celda actual en el listado de celdas de la base de datos procedo a crearla.
		if not cell['name'] in cells:

			controller_id = None

			# Compruebo si existe la BSC/RNC de la celda nueva, si no la creo
			if not cell['controller'] in controllers:
				if cell['tech'] != '4g' and cell['controller'] != '':
					controller_id = create_new_controller(
						cursor,
						cell['controller'],
						cell['vendor'],
						cell['tech'],
						1
					)
					controllers[cell['controller']] = controller_id
			else:
				controller_id = controllers[cell['controller']]
				
			cell_id = create_new_cell(cursor, cell['name'], cell['vendor'], cell['tech'], controller_id, 1)
