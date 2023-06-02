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
    hour TEXT NOT NULL
);

DROP TABLE IF EXISTS Champs;

CREATE TABLE Champs (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nom TEXT NOT NULL,
    champ TEXT NOT NULL
);

COMMIT;
