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
    date TEXT NOT NULL,
    hour TEXT NOT NULL
);

COMMIT;
