#!/bin/sh

mqtt_host="test.mosquitto.org"
topic="exylos"

handle_fun() {
    echo "~~~~ Valeur reçue ~~~~"
    #echo "$1"
    cur_date=$(date +%Y-%m-%d)
    cur_hour=$(date +%H:%M:%S)
    temp=$(echo "$1" | jq '.main.temp')
    feels_like=$(echo "$1" | jq '.main.feels_like')
    temp_min=$(echo "$1" | jq '.main.temp_min')
    temp_max=$(echo "$1" | jq '.main.temp_max')
    pressure=$(echo "$1" | jq '.main.pressure')
    humidity=$(echo "$1" | jq '.main.humidity')
    city=$(echo "$1" | jq '.name' | tr '"' "'")
    temps=$(echo "$1" | jq '.weather[].description' | tr '"' "'")
    echo "($temp, $feels_like, $temp_min, $temp_max, $pressure, $humidity, $city, $temps, $cur_date, $cur_hour);";
    echo "INSERT INTO Entries (temp, feels_like, temp_min, temp_max, pressure, humidity, city, weather, date, hour) VALUES \
        ($temp, $feels_like, $temp_min, $temp_max, $pressure, $humidity, $city, $temps, '$cur_date', '$cur_hour');" | sqlite3 bdd.db

}

while true
do
    mosquitto_sub -h "$mqtt_host" -t "$topic" | while read -r rep
    do
        handle_fun "$rep"
    done
done
