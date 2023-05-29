#!/bin/sh

mqtt_host="test.mosquitto.org"
topic="exylos"

handle_fun() {
    echo "~~~~ Valeur reçue ~~~~"
    cur_date=$(date +%Y-%m-%d)
    cur_hour=$(date +%H:%M)
    temp=$(echo "$1" | jq '.main.temp')
    feels_like=$(echo "$1" | jq '.main.feels_like')
    temp_min=$(echo "$1" | jq '.main.temp_min')
    temp_max=$(echo "$1" | jq '.main.temp_max')
    pressure=$(echo "$1" | jq '.main.pressure')
    humidity=$(echo "$1" | jq '.main.humidity')
    wind_speed=$(echo "$1" | jq '.wind.speed')
    wind_deg=$(echo "$1" | jq '.wind.deg')
    city=$(echo "$1" | jq '.name' | tr -d '"')
    temps=$(echo "$1" | jq '.weather[].description' | tr -d '"')

    values="($temp, $feels_like, $temp_min, $temp_max, $pressure, $humidity, '$city', '$temps', $wind_speed, $wind_deg, '$cur_date', '$cur_hour');"
    echo "$values"
    echo "INSERT INTO Entries (temp, feels_like, temp_min, temp_max, pressure, humidity, city, weather, wind_speed, wind_deg, date, hour) VALUES $values" | sqlite3 bdd.db

}

while true
do
    mosquitto_sub -h "$mqtt_host" -t "$topic" | while read -r rep
    do
        handle_fun "$rep"
    done
done
