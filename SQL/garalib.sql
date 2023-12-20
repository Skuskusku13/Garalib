-- noinspection SqlNoDataSourceInspectionForFile

CREATE DATABASE IF NOT EXISTS gestion_reparation;
USE gestion_reparation;

CREATE TABLE IF NOT EXISTS Utilisateur
(
    idUser INT AUTO_INCREMENT,
    nom    VARCHAR(50),
    email  VARCHAR(50),
    role   VARCHAR(50),
    tel    VARCHAR(50),
    prenom VARCHAR(50),
    panne  VARCHAR(50),
    PRIMARY KEY (idUser)
);

CREATE TABLE IF NOT EXISTS Vehicule
(
    idVehicule      INT AUTO_INCREMENT,
    type            VARCHAR(50),
    immatriculation VARCHAR(50),
    PRIMARY KEY (idVehicule)
);

CREATE TABLE IF NOT EXISTS Technicien
(
    idTechnicien   INT AUTO_INCREMENT,
    prenom         VARCHAR(50),
    tel            VARCHAR(50),
    email          VARCHAR(50),
    codeTechnicien VARCHAR(50),
    qualification  VARCHAR(50),
    PRIMARY KEY (idTechnicien)
);

CREATE TABLE IF NOT EXISTS Reparation
(
    idReparation INT AUTO_INCREMENT,
    idVehicule   INT,
    idTechnicien INT,
    dateArrive   DATE,
    dateFin      DATE,
    resolu       BOOLEAN,
    PRIMARY KEY (idReparation),
    FOREIGN KEY (idVehicule) REFERENCES vehicule (idVehicule),
    FOREIGN KEY (idTechnicien) REFERENCES technicien (idTechnicien)
);

CREATE TABLE IF NOT EXISTS Agenda
(
    idAgenda   INT AUTO_INCREMENT,
    dateOccupe DATE,
    idUser     INT,
    PRIMARY KEY (idAgenda),
    FOREIGN KEY (idUser) REFERENCES utilisateur (idUser)
);