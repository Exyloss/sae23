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
    id INTEGER PRIMARY KEY AUTOINCREMENT,
	idImage TEXT NOT NULL,
	Image TEXT NOT NULL
);	 
	
INSERT INTO Images (idImage, Image) VALUES('ciel dégagé','Images/ciel-dégagé.jpg');
INSERT INTO Images (idImage, Image) VALUES('couvert','Images/couvert.jpg');
INSERT INTO Images (idImage, Image) VALUES('brume','Images/brume.jpg');
INSERT INTO Images (idImage, Image) VALUES('partiellement nuageux','Images/partielement-nuageux.png');
INSERT INTO Images (idImage, Image) VALUES('peu nuageux','Images/peu-nuageux.jpg');
INSERT INTO Images (idImage, Image) VALUES('nuageux','Images/nuageux.jpg');
INSERT INTO Images (idImage, Image) VALUES('légére pluie','Images/pluie.jpg');
INSERT INTO Images (idImage, Image) VALUES('pluie modéré','Images/pluie.jpg');
INSERT INTO Images (idImage, Image) VALUES('forte pluie','Images/forte-pluie.png');
INSERT INTO Images (idImage, Image) VALUES('très forte pluie','Images/forte-pluie.png');
INSERT INTO Images (idImage, Image) VALUES('orage','Images/orage.jpg');
INSERT INTO Images (idImage, Image) VALUES('orage et pluie fine','Images/orage-et-pluie.jpg');
INSERT INTO Images (idImage, Image) VALUES('orage et forte pluie','Images/orage-et-pluie.jpg');
INSERT INTO Images (idImage, Image) VALUES('orage et pluie','Images/orage-et-pluie.jpg');


COMMIT;
