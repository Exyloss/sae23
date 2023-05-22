# Python program to import JSON open data to Python

import json, requests

def fun():
    headers = {'User-Agent': 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:35.0) Gecko/20100101 Firefox/35.0',
               'Cache-Control': 'no-cache, no-store, must-revalidate', 'Pragma': 'no-cache', 'Expires': '0'}
    url = requests.get("https://api.met.no/weatherapi/locationforecast/2.0/compact?lat=43.88566272770907&lon=-0.5092243304975015", headers=headers)
    text = url.text

    data = json.loads(text)

    units = data["properties"]["meta"]["units"]
    weather = data["properties"]["timeseries"][0]["data"]["instant"]["details"]

    chaine = ""
    for key in weather.keys():
        chaine += "%s = %2.2f %s" %(key, weather[key], units[key])
        chaine += "\n"
    return chaine

