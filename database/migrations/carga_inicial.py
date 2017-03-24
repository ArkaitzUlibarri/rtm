#!/usr/bin/python

import datetime
import psycopg2


def add_days_to_date(date, i):
	"""
	Suma o resta dias a la fecha pasada como argumento.
	"""
	return (date + datetime.timedelta(days=i)) #.strftime('m%md%d')


def add_weeks_to_date(date, i):
	"""
	Suma o resta semanas a la fecha pasada como argumento.
	"""
	return (date + datetime.timedelta(weeks=i)) #.strftime('w%W')


def list_of_days_for_rop_partials():
	"""
	Devuelve un listado de dias para crear parciales a nivel de ROP.
	"""
	date = datetime.datetime.now()
	days = [add_days_to_date(date, 1)]
	for i in range(0,7):
		days.append( add_days_to_date(date, -i) )
	return days


def list_of_weeks_for_hour_partials():
	"""
	Devuelve un listado de semanas para crear parciales a nivel de hora.
	"""
	date = datetime.datetime.now()
	weeks = [add_weeks_to_date(date, 1)]
	for i in range(0,5):
		weeks.append( add_weeks_to_date(date, -i) )
	return weeks


def first_last_day_of_week(date):
	"""
	Devuelve un diccionario con el primer y ultimo dia de la semana del dia dado.
	"""
	return {
		'start': date - datetime.timedelta(days=date.weekday()),
		'end': date - datetime.timedelta(days=date.weekday()) + datetime.timedelta(days=6)
	}


days = list_of_days_for_rop_partials()
weeks = list_of_weeks_for_hour_partials()
vendors = ['eri', 'hua']
technologies = ['2g', '3g', '4g']


try:
	conn = psycopg2.connect(dbname='rtm', user='postgres', host='localhost', password='secret')
	cur = conn.cursor()

	for vendor in vendors:
		for tech in technologies:

			trigger = []
			table = 'counters_' + tech

			for day in days:
				partial_name = table + "_" + day.strftime('m%md%d')

				cur.execute("DROP TABLE IF EXISTS " + vendor + "." + partial_name)
				cur.execute("CREATE TABLE " + vendor + "." + partial_name + " (CHECK ( created_at >= DATE '" + day.strftime('%Y-%m-%d') + "' AND created_at < DATE '" + add_days_to_date(day, 1).strftime('%Y-%m-%d') + "' )) INHERITS (" + vendor + "." + table + ");")
				cur.execute("CREATE INDEX " + partial_name + "_item_id ON " + vendor + "." + partial_name + " USING btree(item_id);")
				cur.execute("CREATE INDEX " + partial_name + "_created_at ON " + vendor + "." + partial_name + " USING btree(created_at);")

				if (len(trigger) == 0):
					trigger.append("IF ( NEW.created_at >= DATE '" + day.strftime('%Y-%m-%d') + "' AND NEW.created_at < DATE '" + add_days_to_date(day, 1).strftime('%Y-%m-%d') + "' ) THEN INSERT INTO " + vendor + "." + partial_name + " VALUES (NEW.*);")
				else:
					trigger.append("ELSIF ( NEW.created_at >= DATE '" + day.strftime('%Y-%m-%d') + "' AND NEW.created_at < DATE '" + add_days_to_date(day, 1).strftime('%Y-%m-%d') + "' ) THEN INSERT INTO " + vendor + "." + partial_name + " VALUES (NEW.*);")
				
				conn.commit()

			texto = " ".join(trigger)
			cur.execute("CREATE OR REPLACE FUNCTION " + vendor + "." + table + "_trigger() RETURNS TRIGGER AS $$ BEGIN " + texto + "ELSE RAISE EXCEPTION 'Date out of range. Fix the " + vendor + "." + table + "._insert_trigger() function!'; END IF; RETURN NULL; END; $$ LANGUAGE plpgsql;")
			conn.commit()

			table = 'counters_' + tech + '_hour'
			trigger = []

			for day in weeks:
				week = first_last_day_of_week(day)

				partial_name = table + "_" + week['start'].strftime('w%W')
				cur.execute("DROP TABLE IF EXISTS " + vendor + "." + partial_name)
				cur.execute("CREATE TABLE " + vendor + "." + partial_name + " (CHECK ( created_at >= DATE '" + week['start'].strftime('%Y-%m-%d') + "' AND created_at < DATE '" + add_days_to_date(week['end'], 1).strftime('%Y-%m-%d') + "' )) INHERITS (" + vendor + "." + table + ");")
				cur.execute("CREATE INDEX " + partial_name + "_item_id ON " + vendor + "." + partial_name + " USING btree(item_id);")
				cur.execute("CREATE INDEX " + partial_name + "_created_at ON " + vendor + "." + partial_name + " USING btree(created_at);")
				
				if (len(trigger) == 0):
					trigger.append("IF ( NEW.created_at >= DATE '" + week['start'].strftime('%Y-%m-%d') + "' AND NEW.created_at < DATE '" + add_days_to_date(week['end'], 1).strftime('%Y-%m-%d') + "' ) THEN INSERT INTO " + vendor + "." + partial_name + " VALUES (NEW.*);")
				else:
					trigger.append("ELSIF ( NEW.created_at >= DATE '" + week['start'].strftime('%Y-%m-%d') + "' AND NEW.created_at < DATE '" + add_days_to_date(week['end'], 1).strftime('%Y-%m-%d') + "' ) THEN INSERT INTO " + vendor + "." + partial_name + " VALUES (NEW.*);")
				
				conn.commit()

			texto = " ".join(trigger)
			cur.execute("CREATE OR REPLACE FUNCTION " + vendor + "." + table + "_trigger() RETURNS TRIGGER AS $$ BEGIN " + texto + "ELSE RAISE EXCEPTION 'Date out of range. Fix the " + vendor + "." + table + "._insert_trigger() function!'; END IF; RETURN NULL; END; $$ LANGUAGE plpgsql;")
			conn.commit()

except psycopg2.DatabaseError as e:
	print ('Error %s' % e)
