#!usr/bin/env python3

import matplotlib.pyplot as plt
import sqlite3

bdd = sqlite3.connect("bdd.db")
cur = bdd.cursor()
dic = {"temp": 1, "feels_like": 2, "temp_min": 3, "temp_max": 4, "pressure": 5, "humidity": 6, "weather": 8, "wind_speed": 9, "wind_deg": 10}

def time_to_int(time):
    return int(time.split(':')[0])*60+int(time.split(':')[1])

def int_to_time(time):
    return str(time//60)+":"+str(time%60)

def get_time_by_hour(day: str, column: str, delta: int):
    cur_hour = bdd.cursor()
    hour_values = cur_hour.execute("SELECT * FROM Entries WHERE date='"+day+"';")
    col = dic[column]
    values = []
    for i in hour_values:
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

def get_day_moy(day, column):
    cur_moy = bdd.cursor()
    col = dic[column]
    day_values = cur_moy.execute("SELECT * FROM Entries WHERE date='"+day+"';")
    somme = 0
    l = 0
    for i in day_values:
        somme += i[col]
        l += 1
    return round(somme/l, 2)

def get_time_by_day(unit, type_unit, column):
    if type_unit == 'year':
        entries = cur.execute("SELECT DISTINCT date FROM Entries WHERE date LIKE '"+unit+"-%';")
    elif type_unit == 'month':
        entries = cur.execute("SELECT DISTINCT date FROM Entries WHERE date LIKE '%-"+unit+"-%';")
    else:
        return False
    days = []
    data = []
    for i in entries:
        date = i[0]
        moy = get_day_moy(date, column)
        days.append(date)
        data.append(moy)
    plt.plot(days, data)
    plt.show()

#get_time_by_hour("2023-05-28", 'temp', 60)
get_time_by_day('05', 'month', 'temp')


bdd.close()
