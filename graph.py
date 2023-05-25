#!/usr/bin/env python3

import matplotlib.pyplot as plt
import sqlite3

bdd = sqlite3.connect("bdd.db")
cur = bdd.cursor()

def time_to_int(time):
    return int(time.split(':')[0])*60+int(time.split(':')[1])

def int_to_time(time):
    return str(time//60)+":"+str(time%60)

def get_time_by_hour(day: str, column: str, delta: int):
    entries = cur.execute("SELECT * FROM Entries WHERE date='"+day+"';")
    columns = [i[0] for i in cur.description]
    try:
        col = columns.index(column)
    except:
        return False

    values = []
    for i in entries:
        values.append((i[12], i[col]))

    i = 0
    j = 0
    average_val = [[0, []]]
    while i <= 24*60 and j < len(values):
        hour_int = time_to_int(values[j][0])
        if i <= hour_int <= i+delta:
            average_val[-1][1].append(values[j][1])
            average_val[-1][0] = int_to_time(i)
            j += 1
        else:
            i += delta
            if average_val[-1][1] != []:
                temp_tab = average_val[-1][1]
                temp_average = round(sum(temp_tab)/len(temp_tab), 2)
                average_val[-1][1] = temp_average
                average_val.append([0, []])

    if average_val[-1][1] == []:
        average_val.pop()
    elif not isinstance(average_val[-1][1], int):
        temp_tab = average_val[-1][1]
        temp_average = round(sum(temp_tab)/len(temp_tab), 2)
        average_val[-1][1] = temp_average

    hours = [i[0] for i in average_val]
    values = [i[1] for i in average_val]
    plt.plot(hours, values)
    plt.show()

get_time_by_hour("2023-05-26", 'temp', 30)

bdd.close()
