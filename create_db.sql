BEGIN TRANSACTION;

DROP TABLE IF EXISTS Entries;

CREATE TABLE Entries (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    temp REAL NOT NULL,
    feels_like REAL NOT NULL,
    temp_min REAL NOT NULL,
    temp_max REAL NOT NULL,
    pressure INT NOT NULL,
    humidity INT NOT NULL,
    city TEXT NOT NULL,
    weather TEXT NOT NULL,
    wind_speed REAL NOT NULL,
    wind_deg REAL NOT NULL,
    date TEXT NOT NULL,
    hour TEXT NOT NULL,
);

DROP TABLE IF EXISTS Champs;

CREATE TABLE Champs (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nom TEXT NOT NULL,
    champ TEXT NOT NULL
);

DROP TABLE IF EXISTS Images;

CREATE TABLE Images(
	idImage TEXT NOT NULL,
	Image TEXT NOT NULL,
);	 
	
INSERT INTO Images VALUES('ciel dégagé','Images/ciel-dégagé.jpg');
INSERT INTO Images VALUES('couvert','Images/couvert.jpg');
INSERT INTO Images VALUES('brume','Images/brume.jpg');
INSERT INTO Images VALUES('partiellement nuageux','Images/partielement-nuageux.png');
INSERT INTO Images VALUES('peu nuageux','Images/peu-nuageux.jpg');
INSERT INTO Images VALUES('nuageux','Images/nuageux.jpg');
INSERT INTO Images VALUES('légére pluie','Images/pluie.jpg');
INSERT INTO Images VALUES('pluie modéré','Images/pluie.jpg');
INSERT INTO Images VALUES('forte pluie','Images/forte-pluie.png');
INSERT INTO Images VALUES('très forte pluie','Images/forte-pluie.png');
INSERT INTO Images VALUES('orage','Images/orage.jpg');
INSERT INTO Images VALUES('orage et pluie fine','Images/orage-et-pluie.jpg');
INSERT INTO Images VALUES('orage et forte pluie','Images/orage-et-pluie.jpg');
INSERT INTO Images VALUES('orage et pluie','Images/orage-et-pluie.jpg');


COMMIT;
