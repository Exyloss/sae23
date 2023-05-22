#!/bin/sh

mqtt_host="test.mosquitto.org"
topic="exylos"

handle_fun() {
    echo "~~~~ Valeur reçue ~~~~"
    echo "$1"
    cur_date=$(date +%Y-%m-%d)
    cur_hour=$(date +%H:%M:%S)
    temp=$(echo "$1" | jq '.temp')
    feels_like=$(echo "$1" | jq '.feels_like')
    temp_min=$(echo "$1" | jq '.temp_min')
    temp_max=$(echo "$1" | jq '.temp_max')
    pressure=$(echo "$1" | jq '.pressure')
    humidity=$(echo "$1" | jq '.humidity')
    echo "INSERT INTO Entries (temp, feels_like, temp_min, temp_max, pressure, humidity, date, hour) VALUES \
        ($temp, $feels_like, $temp_min, $temp_max, $pressure, $humidity, '$cur_date', '$cur_hour');" | sqlite3 bdd.sqlite

}

while true
do
    mosquitto_sub -h "$mqtt_host" -t "$topic" | while read -r rep
    do
        handle_fun "$rep"
    done
done