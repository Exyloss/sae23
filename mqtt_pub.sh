#!/bin/sh

api_key=$(cat weather_key)
api_link="https://api.openweathermap.org/data/2.5/weather?lat=43.8911318&lon=-0.500972&units=metric&lang=fr&appid=$api_key"
mqtt_host="test.mosquitto.org"
topic="bastos"
couldown=120

while true
do
    json_content=$(curl -s -X GET "$api_link")
    cur_date=$(date +%Y-%m-%d)
    cur_hour=$(date +%H:%M)
    temp=$(echo "$json_content" | jq '.main.temp')
    feels_like=$(echo "$json_content" | jq '.main.feels_like')
    temp_min=$(echo "$json_content" | jq '.main.temp_min')
    temp_max=$(echo "$json_content" | jq '.main.temp_max')
    pressure=$(echo "$json_content" | jq '.main.pressure')
    humidity=$(echo "$json_content" | jq '.main.humidity')
    wind_speed=$(echo "$json_content" | jq '.wind.speed')
    wind_deg=$(echo "$json_content" | jq '.wind.deg')
    city=$(echo "$json_content" | jq '.name' | tr -d '"')
    temps=$(echo "$json_content" | jq '.weather[].description' | tr -d '"')
    dic="{\"temp\": $temp, \"feels_like\": $feels_like, \"temp_min\": $temp_min, \"temp_max\": $temp_max, \"pressure\": $pressure, \"humidity\": $humidity, \"wind_speed\": $wind_speed, \"wind_deg\": $wind_deg, \"city\": \"$city\", \"weather\": \"$temps\", \"date\": \"$cur_date\", \"hour\": \"$cur_hour\"}"
    echo "~~~~ Valeurs envoyées ~~~~"
    echo "$dic"
    mosquitto_pub -h "$mqtt_host" -t "$topic" -m "$dic"
    sleep "$couldown"
done
