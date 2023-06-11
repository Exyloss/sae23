#!/usr/bin/env python3

import matplotlib.pyplot as plt
import sqlite3
import base64
import argparse

bdd = sqlite3.connect("/home/antonin/travail/sae/sae23/bdd.db")
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
    return {"x": hours, "y": values}

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

def get_time_by_day(unit, column):
    entries = cur.execute("SELECT DISTINCT date FROM Entries WHERE date LIKE '"+unit+"-%';")
    days = []
    data = []
    for i in entries:
        date = i[0]
        moy = get_day_moy(date, column)
        days.append(date)
        data.append(moy)
    return {"x": days, "y": data}


if __name__ == "__main__":
    parser = argparse.ArgumentParser(description="Générateur de graphiques matplotlib")
    parser.add_argument("--file", help="Fichier de sortie", metavar='FICHIER')
    parser.add_argument("--day", help="Jour sélectionné", metavar='DAY')
    parser.add_argument("--month", help="Mois sélectionné", metavar='MONTH')
    parser.add_argument("--year", help="Année sélectionnée", metavar='YEAR')
    parser.add_argument("--champ", help="Champ à plotter", metavar='FIELD')
    parser.add_argument("--delta", help="delta t", metavar='DELTA')
    parser.add_argument("--output", help="type de sortie (matplotlib, base64, dic)", metavar='OUTPUT')
    args = parser.parse_args()
    if ((args.day == None or args.delta == None) and args.month == None and args.year == None) or args.champ == None:
        print("erreur")
        exit(1)
    if args.day != None and args.champ in dic.keys():
        output = get_time_by_hour(args.day, args.champ, int(args.delta))
    else:
        if args.champ in dic.keys():
            if args.month != None:
                output = get_time_by_day(args.month, args.champ)
            else:
                output = get_time_by_day(args.year, args.champ)
    if args.output != None:
        if args.output == "dic":
            print(output)
        elif args.file != None:
            plt.plot(output["x"], output["y"])
            plt.xticks(rotation=90, ha='right')
            plt.savefig(parser.file, format='png', bbox_inches="tight")
            plt.close()
            if args.output == "base64":
                with open(args.file, "rb") as image_file:
                    print(base64.b64encode(image_file.read()).decode('utf-8'))


bdd.close()
