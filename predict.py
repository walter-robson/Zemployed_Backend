'''
https://www.ianrothmann.com/pub/psyc_v29_n1_a9.pdf

Big 5 Weights for the Three Categories

Performance
    E = .67
    A = .57
    C = .05
    N = .39
    O = .63

Creativity
    E = .72
    A = .60
    C = .61
    N = .28
    O = .76

Management
    E = .71
    A = .31
    C = .60
    N = .19
    O = .91
'''

import numpy as np
import mysql.connector
import tensorflow
import pandas
import keras

from tensorflow.keras.models import Sequential
from tensorflow.keras.models import load_model
from tensorflow.keras.layers import Dense
from tensorflow.keras.utils import to_categorical
import os
import sys
import logging

def main():
    # Suppress tensorflow warnings
    os.environ['TF_CPP_MIN_LOG_LEVEL'] = '3'
    tensorflow.get_logger().setLevel('ERROR')
    
    # Preferred Weights for Performance
    p = [.67, .57, .05, .39, .63]
    # Preferred Weights for Creativity 
    c = [.72, .60, .61, .28, .76]
    # Preferred Weights for Management
    m = [.71, .31, .60, .19, .91]
    
    # Connect to Database and get user personality scores
    mydb = mysql.connector.connect(
        host='localhost',
        user='wrobson',
        password='DatabasesRCool',
        database='wrobson'
    )
    # Ready user data for prediction
    data = []
    output = []
    job_id = str(sys.argv[2])
    with mydb.cursor() as cursor:
        cursor.execute('SELECT * from user, application WHERE user.id=application.user_id and application.job_id=' + job_id)
        users = cursor.fetchall()
    
    for user in users:
        data.append(list(ui/40 for ui in user[-9:-4]))
        output.append(list(user[1:3] + user[4:8])) 
    
    for user in data:
        if len(list(user)) != 5:
            del user
   
    # Train on a random distribution from min to max (plus or minus 10)
    # of each column for users.
    # Give somewhat of a random element for users
    # Allocate 5 for big 5 score and 1 for result
    # 0 is perforamnce, 1 is creativity, 2 is management
    data = np.array(data)
    df = pandas.DataFrame(data)
    ranges = np.array(
        [[df[0].min(axis=0)-.1, df[0].max(axis=0)+.1],
        [df[1].min(axis=0)-.1, df[1].max(axis=0)+.1],
        [df[2].min(axis=0)-.1, df[2].max(axis=0)+.1],
        [df[3].min(axis=0)-.1, df[3].max(axis=0)+.1],
        [df[4].min(axis=0)-.1, df[4].max(axis=0)+.1]]
    )
    rand_scores = np.random.uniform(low=ranges[:,0], high=ranges[:, 1], size=(5000, ranges.shape[0]))
    
    results = []
    for sample in rand_scores:
        tally = {0:0, 1:0, 2:0}
        for i,val in enumerate(sample):
            p_score = abs(p[i] - val)
            c_score = abs(c[i] - val)
            m_score = abs(m[i] - val)
            if p_score > c_score and p_score > m_score:
                tally[0] += 1
            elif c_score > p_score and c_score > m_score:
                tally[1] += 1
            else:
                tally[2] += 1
        results.append(max(tally, key=tally.get))
    train_results = to_categorical(np.asarray(results))
    ''' 
    # Initialize Model
    model = Sequential()
    model.add(Dense(20, input_dim=5, activation='linear'))
    model.add(Dense(3, activation='softmax'))
    model.compile(loss='categorical_crossentropy', optimizer='adam', metrics=['accuracy'])
    
    # Fit Model
    model.fit(rand_scores, train_results, epochs=10, verbose=1)
    model.save('model.h5')
    '''
    model = load_model('model.h5')
    predictions = np.argmax(model.predict(data), axis=-1)
    
    # Output HTML
    archetype = str(sys.argv[1])
    print('<div class="div-table">')
    print('<h3 style="color:white">')
    if archetype == 'Managers':
        print('<h3 style="color:white">Managers</h3>')
    if archetype == 'Creatives':
        print('<h3 style="color:white">Creatives</h3>')
    if archetype == 'Performers':
        print('<h3 style="color:white">Performers</h3>')
    print('<table class="styled-table table-hover">')
    print('<thead><tr><td>First Name</td><td>Last Name</td><td>School</td><td>Graduation</td><td>GPA</td><td>Major</td></tr></thead>')
    
    # Add archetype to each item
    for i,pred in enumerate(predictions):
        if pred == 0:
            output[i].append('Performers')
        elif pred == 1:
            output[i].append('Creatives')
        else:
            output[i].append('Managers')

    # Table output
    for item in output:
        if str(item[6]) == archetype:
            print('<tr>')
            print('<td>' + str(item[0]) + '</td>')
            print('<td>' + str(item[1]) + '</td>')
            print('<td>' + str(item[2]) + '</td>')
            print('<td>' + str(item[3]) + '</td>')
            print('<td>' + str(item[4]) + '</td>')
            print('<td>' + str(item[5]) + '</td>')
            print('</tr>')

    print('</table>')
    print('</div>')
    print('</body>')
    
if __name__ == '__main__':
    main()
