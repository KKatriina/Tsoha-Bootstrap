CREATE TABLE Opettaja(
    nimi varchar(50) PRIMARY KEY,
    salasana varchar(50) NOT NULL,
    laitos varchar(50),
    nimike varchar(50)
);

CREATE TABLE Kysely(
    nimi varchar(50) PRIMARY KEY,
    tarkoitus varchar(50)
);

CREATE TABLE Kysymys(
    tunniste SERIAL PRIMARY KEY,
    kysely varchar(50) REFERENCES Kysely(nimi),
    kysymys varchar(400)
);

CREATE TABLE Kurssi(
    tunniste SERIAL PRIMARY KEY,
    nimi varchar(50),
    aika varchar(50),
    tyyppi INTEGER,
    kuvaus varchar(400),
    opettaja varchar(50) REFERENCES Opettaja(nimi)
);

CREATE TABLE Kurssin_kysely(
    tunniste SERIAL PRIMARY KEY,
    kurssi INTEGER REFERENCES Kurssi(tunniste),
    kysely varchar(50) REFERENCES Kysely(nimi),
    paattyminen DATE
);

