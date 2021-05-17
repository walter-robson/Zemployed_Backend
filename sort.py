import mysql.connector
import pandas as pd
import sys
from scipy.spatial import distance


# be sure to run 'pip install mysql-connector-python'
# and 'pip install pandas' before executing
# starter code from realpython.com (https://realpython.com/python-mysql/#connecting-to-an-existing-database, https://realpython.com/pandas-python-explore-dataset/)

def get_database(my_host, my_user, my_password, my_database):
	mydb = mysql.connector.connect(
			host=my_host,
			user=my_user,
			password=my_password,
			database=my_database
	)

	return mydb

def get_data(mydb, table, query):
	column_titles = [] # list of column titles
	data = [] # will be list of lists storing DB data

	with mydb.cursor() as cursor:
		# get column names
		cursor.execute(f'DESC {table}')
		result = cursor.fetchall()
		for row in result:
			title = row[0]
			column_titles.append(title)

		# get data from db
		cursor.execute(query)
		users = cursor.fetchall()
		for row in users:
			data.append(list(row))

		# make dataframe from column names and data
		df = pd.DataFrame(data, columns=column_titles)
		return df

def get_distance(df, gpa, ideal, gpa_weight, personality_weight):	
	distances = []
	for index, row in df.iterrows():
		real = (row['p_e'], row['p_a'], row['p_c'], row['p_n'], row['p_o'])
		personality_dist = distance.euclidean(real, ideal)
		gpa_dist = 1 - min(1.00, row['gpa']/gpa) # complement of percent requested gpa
		dist = gpa_weight*gpa_dist + personality_weight*personality_dist
		distances.append(dist)
	df['distance'] = distances

def sort_by_distance(df):
	return df.sort_values(by='distance')

def print_html(df):
	print('<table class="styled-table table-hover">')
	print('\t<thead><tr><td>First Name</td><td>Last Name</td><td>School</td></tr></thead>')
	for index, row in df.iterrows():
		print(f'\t<tr><td>{row["first_name"]}</td><td>{row["last_name"]}</td><td>{row["school"]}</td></tr>')
	print('</table>')

def main():
	if len(sys.argv) != 10:
		# expects python3 sort.py gpa p_e p_a p_c p_n p_o gpa_weight personality_weight job_id
		print("wrong number of command line arguments, exiting")
		exit(1)
	args = list(map(float, sys.argv[1:]))
	gpa = args[0]
	personality = tuple(args[1:6])
	gpa_weight = args[6]
	personality_weight = args[7]
	job_id = args[8]

		
	mydb = get_database("localhost", "wrobson", "DatabasesRCool", "wrobson")
	query = "select user.id, first_name, last_name, phone, school, grad_year, gpa, major, minor, degree, p_e, p_a, p_c, p_n, p_o from application, user, job where application.user_id=user.id and application.job_id=job.id and job_id = " + str(job_id) + ";"
	df = get_data(mydb, "user", query)
	get_distance(df, gpa, personality, gpa_weight, personality_weight)
	df = sort_by_distance(df)
	print_html(df)

if __name__ == "__main__":
	main()
