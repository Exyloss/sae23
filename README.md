# sae23

Dépendances shell :
 * jq (pour lire le json)
 * mosquitto (pour subscribe/publish)

Dépendances python :
 * paho-mqtt
 * matplotlib

Placer la clef d'API dans le fichier weather_key, toutes les configs du broker sont dans le dossier cfg.

Les scripts pour envoyer et recevoir les données sont mqtt_sub.sh et mqtt_pub.sh.

Le script python graph.py permet de génerer des graphes avec matplotlib ou d'afficher directement le dictionnaire
contenant les données.

Le script php appelle de script graph.py afin d'insérer les données dans le JS.

Nous utilisons la librairie open-source Plotly pour génerer des graphes avec Javascript.
