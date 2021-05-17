import mysql.connector
import pandas as pd
import numpy as np
from scipy.spatial import distance
import sys

# be sure to run 'pip install mysql-connector-python'
# and 'pip install pandas' before executing
# and 'pip install scipy'
# and 'pip install numpy'
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

def main():
	job_id = sys.argv[1]
	
	mydb = get_database("localhost", "wrobson", "DatabasesRCool", "wrobson")
	query = "select user.id, first_name, last_name, phone, school, grad_year, gpa, major, minor, degree, p_e, p_a, p_c, p_n, p_o from application, user, job where application.user_id=user.id and application.job_id=job.id and job_id = " + str(job_id) + ";"
#	query = "select * from user"
	df = get_data(mydb, "user", query) #TODO:update this to be the job selected from the php script, which will be passed in as args to this script
	#print("DataFrame:")
	#print(df)
	objects = []
	instances = []
	for instance in df.to_numpy():
		objects.append(instance[0])
		featureValues = list(instance[1:])
		instances.append(featureValues)
	X = np.array(instances) #get the data into an array
	#print(X)
	C = [] #reduce the data to just the big 5
	for i in X:
		C.append([float(i[9]),float(i[10]),float(i[11]),float(i[12]),float(i[13])])
	#print(C)
	#output_array holds the info we actually output
	output_array = []
	for i in X:
		output_array.append([i[0], i[1], i[3], i[4], i[5], i[6]])

	#now that we have our data in a nice and pretty array, lets do some K means Clustering from scratch! Yes, we could use scipy but that would not be advanced enough
	#for reference the columns go Extroversion, Agreeableness, Conscientiousness, Neuroticsm, and Openness to New Experiences, all columns are from 0-40
	#Extroversion: high scorers are more extroverted, low scorers are introverted
	#Agreeableness: High scorers are more polite, low scorers are more blunt
	#Conscientiousness: High scorers are honest and clean, low scorers are cheats and messy
	#Neuroticism: high scorers are more emotional, low scorers are less emotional
	#Openness to Experience: high scorers are dreamers, low scorers are down to earth

	c0 = [0,0,0,0,0]
	c1 = [0,0,0,0,0]
	c2 = [0,0,0,0,0]
	c3 = [0,0,0,0,0]
	c4 = [0,0,0,0,0]
	#initial centroids, at the maximum of each of the dimentions
	new_c0 = [40,0,0,0,0]
	new_c1 = [0,40,0,0,0]
	new_c2 = [0,0,40,0,0]
	new_c3 = [0,0,0,40,0]
	new_c4 = [0,0,0,0,40]
	
	while (new_c0 != c0) and (new_c1 != c1) and (new_c2 != c2) and (new_c3 != c3) and (new_c4 != c4):
		g0 = []
		g1 = []
		g2 = []
		g3 = []
		g4 = []
		g0e = 0.
		g0a = 0.
		g0c = 0.
		g0n = 0.
		g0o = 0.
		g1e = 0.
		g1a = 0.
		g1c = 0.
		g1n = 0.
		g1o = 0.
		g2e = 0.
		g2a = 0.
		g2c = 0.
		g2n = 0.
		g2o = 0.
		g3e = 0.
		g3a = 0.
		g3c = 0.
		g3n = 0.
		g3o = 0.
		g4e = 0.
		g4a = 0.
		g4c = 0.
		g4n = 0.
		g4o = 0.
		#lets label the groups
		labels = []
		c0 = new_c0
		c1 = new_c1
		c2 = new_c2
		c3 = new_c3
		c4 = new_c4
		for entry in C:
			d0 = distance.euclidean(entry, c0)
			d1 = distance.euclidean(entry, c1)
			d2 = distance.euclidean(entry, c2)
			d3 = distance.euclidean(entry, c3)
			d4 = distance.euclidean(entry, c4)
			
			if (d0 <= d1) and (d0 <= d2) and (d0 <= d3) and (d0 <= d4):
				labels.append(0)
				
			elif (d1 <= d0) and (d1 <= d2) and (d1 <= d3) and (d1 <= d4):
				labels.append(1)
				
			elif (d2 <= d0) and (d2 <= d1) and (d2 <= d3) and (d2 <= d4):
				labels.append(2)
				
			elif (d3 <= d0) and (d3 <= d1) and (d3 <= d2) and (d3 <= d4):
				labels.append(3)
				
			elif (d4 <= d0) and (d4 <= d1) and (d4 <= d2) and (d4 <= d3):
				labels.append(4)
				
			#time to get a new centroid
		i = 0
		while i < len(C):
			if labels[i] == 0:
				g0.append(C[i])
				g0e += float(X[i,9])
				g0a += float(X[i,10])
				g0c += float(X[i,11])
				g0n += float(X[i,12])
				g0o += float(X[i,13])
			if labels[i] == 1:
				g1.append(C[i])
				g1e += float(X[i,9])
				g1a += float(X[i,10])
				g1c += float(X[i,11])
				g1n += float(X[i,12])
				g1o += float(X[i,13])
			if labels[i] == 2:
				g2.append(C[i])
				g2e += float(X[i,9])
				g2a += float(X[i,10])
				g2c += float(X[i,11])
				g2n += float(X[i,12])
				g2o += float(X[i,13])
			if labels[i] == 3:
				g3.append(C[i])
				g3e += float(X[i,9])
				g3a += float(X[i,10])
				g3c += float(X[i,11])
				g3n += float(X[i,12])
				g3o += float(X[i,13])
			if labels[i] == 4:
				g4.append(C[i])
				g4e += float(X[i,9])
				g4a += float(X[i,10])
				g4c += float(X[i,11])
				g4n += float(X[i,12])
				g4o += float(X[i,13])
			i = i + 1
		new_c0 = [(g0e/(len(g0) +.01)),(g0a/(len(g0) + .01)),(g0c/(len(g0) + .01)),(g0n/(len(g0) + .01)),(g0o/(len(g0) + .01))]
		new_c1 = [(g1e/(len(g1) + .01)),(g1a/(len(g1) + .01)),(g1c/(len(g1) + .01)),(g1n/(len(g1) + .01)),(g1o/(len(g1) + .01))]
		new_c2 = [(g2e/(len(g2) + .01)),(g2a/(len(g2) + .01)),(g2c/(len(g2) + .01)),(g2n/(len(g2) + .01)),(g2o/(len(g2) + .01))]
		new_c3 = [(g3e/(len(g3) + .01)),(g3a/(len(g3) + .01)),(g3c/(len(g3) + .01)),(g3n/(len(g3) + .01)),(g3o/(len(g3) + .01))]
		new_c4 = [(g4e/(len(g4) + .01)),(g4a/(len(g4) + .01)),(g4c/(len(g4) + .01)),(g3n/(len(g4) + .01)),(g4o/(len(g4) + .01))]
		

	i = 0;
	group0 = []
	group1 = []
	group2 = []
	group3 = []
	group4 = []
	while i < len(labels):
		if labels[i] == 0:
			group0.append(output_array[i])
		if labels[i] == 1:
			group1.append(output_array[i])
		if labels[i] == 2:
			group2.append(output_array[i])
		if labels[i] == 3:
			group3.append(output_array[i])
		if labels[i] == 4:
			group4.append(output_array[i])
		i += 1
	

	
	print("<h3 style='color:white'>Group 0</h3>") #TODO:Figure out a better name for this
	print('<table class="styled-table table-hover">')
	print("<thead><tr><td>First Name</td><td>Last Name</td><td>School</td><td>Graduation</td><td>GPA</td><td>Major</td></tr></thead>")
	for person in group0:
		print("<tr>")
		for a in person:
			print("<td>", a, "</td>")
		print("</tr>")
	print("</table>")


	print("<h3 style='color:white'>Group 1</h3>")
	print('<table class="styled-table table-hover">')
	print("<thead><tr><td>First Name</td><td>Last Name</td><td>School</td><td>Graduation</td><td>GPA</td><td>Major</td></tr></thead>")
	for person in group1:
		print("<tr>")
		for a in person:
			print("<td>", a, "</td>")
		print("</tr>")
	print("</table>")

	print("<h3 style='color:white'>Group 2</h3>")
	print('<table class="styled-table table-hover">')
	print("<thead><tr><td>First Name</td><td>Last Name</td><td>School</td><td>Graduation</td><td>GPA</td><td>Major</td></tr></thead>")
	for person in group2:
		print("<tr>")
		for a in person:
			print("<td>", a, "</td>")
		print("</tr>")
	print("</table>")

	print("<h3 style='color:white'>Group 3</h3>")
	print('<table class="styled-table table-hover">')
	print("<thead><tr><td>First Name</td><td>Last Name</td><td>School</td><td>Graduation</td><td>GPA</td><td>Major</td></tr></thead>")
	for person in group3:
		print("<tr>")
		for a in person:
			print("<td>", a, "</td>")
		print("</tr>")
	print("</table>")

	print("<h3 style='color:white'>Group 4</h3>")
	print('<table class="styled-table table-hover">')
	print("<thead><tr><td>First Name</td><td>Last Name</td><td>School</td><td>Graduation</td><td>GPA</td><td>Major</td></tr></thead>")
	for person in group4:
		print("<tr>")
		for a in person:
			print("<td>", a, "</td>")
		print("</tr>")
	print("</table>")


if __name__ == "__main__":
	main()
