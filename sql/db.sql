-- TUOTERYHMÄ
DROP DATABASE IF EXISTS kukkakauppa;
CREATE DATABASE kukkakauppa;
USE kukkakauppa;

DROP TABLE IF EXISTS tuoteryhma;
CREATE TABLE tuoteryhma (
    trnro INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    trnimi VARCHAR(255) NOT NULL
);

-- TUOTE
DROP TABLE IF EXISTS tuote;
CREATE TABLE tuote (
    tuotenro INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    tuotenimi VARCHAR(255) NOT NULL,
    tuotekuvaus TEXT,
    trnro INT,
    hinta DECIMAL(4,2),
    kuva_url VARCHAR(255),
    CONSTRAINT `fk_trnro` FOREIGN KEY (trnro) REFERENCES tuoteryhma(trnro)
);

INSERT INTO tuoteryhma (trnimi)
VALUES ("Viherkasvit"), 
("Mehikasvit"), 
("Kaktukset");

INSERT INTO tuote (tuotenimi, tuotekuvaus, trnro, hinta)
VALUES ("Peikonlehti", "Peikonlehti kasvaa kookkaaksi kauniine, vihreine lehtineen. Komeimmillaan lehdet ovat 70x100 cm kokoiset ja niissä voi olla jopa 50 erikokoista reikää.Peikonlehti kasvaa kookkaaksi kauniine, vihreine lehtineen. Komeimmillaan lehdet ovat 70x100 cm kokoiset ja niissä voi olla jopa 50 erikokoista reikää.", 1, 00.00),
()