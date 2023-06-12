#!/bin/sh

mqtt_host="antoninp.fr"
topic="weather/mdm"

handle_fun() {
    echo "~~~~ Valeur reçue ~~~~"
    temp=$(echo "$1" | jq '.temp')
    feels_like=$(echo "$1" | jq '.feels_like')
    temp_min=$(echo "$1" | jq '.temp_min')
    temp_max=$(echo "$1" | jq '.temp_max')
    pressure=$(echo "$1" | jq '.pressure')
    humidity=$(echo "$1" | jq '.humidity')
    wind_speed=$(echo "$1" | jq '.wind_speed')
    wind_deg=$(echo "$1" | jq '.wind_deg')
    city=$(echo "$1" | jq '.city' | tr -d '"')
    temps=$(echo "$1" | jq '.weather' | tr -d '"' | head -1)
    date=$(echo "$1" | jq '.date' | tr -d '"')
    hour=$(echo "$1" | jq '.hour' | tr -d '"')

    values="($temp, $feels_like, $temp_min, $temp_max, $pressure, $humidity, '$city', '$temps', $wind_speed, $wind_deg, '$date', '$hour');"
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
