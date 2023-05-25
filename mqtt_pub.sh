#!/bin/sh

api_key=$(cat weather_key)
api_link="https://api.openweathermap.org/data/2.5/weather?lat=43.8911318&lon=-0.500972&units=metric&lang=fr&appid=$api_key"
mqtt_host="test.mosquitto.org"
topic="exylos"
couldown=120

while true
do
    json_content=$(curl -s -X GET "$api_link")
    echo "~~~~ Valeurs envoyées ~~~~"
    echo "$json_content"
    mosquitto_pub -h "$mqtt_host" -t "$topic" -m "$json_content"
    sleep "$couldown"
done
