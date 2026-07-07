-- Active: 1767770794766@@127.0.0.1@3306@transvoyagescm
DROP DATABASE transvoyagescm;
CREATE DATABASE IF NOT EXISTS transvoyagescm;
use transvoyagescm;

-- Table Utilisateur (fusion de Utilisateur, Client et Admin)
CREATE TABLE utilisateur (
    id_users VARCHAR(46) PRIMARY KEY DEFAULT (UUID()),
    nom_users VARCHAR(100) NOT NULL,
    email_users VARCHAR(100) NOT NULL UNIQUE,
    age INT,
    mot_de_passe VARCHAR(255) NOT NULL,
    telephone VARCHAR(20),
    Role ENUM('client', 'admin_principal', 'admin') NOT NULL
);

-- Table Sous_agence
CREATE TABLE agence (
    id_agence VARCHAR(46) PRIMARY KEY DEFAULT (UUID()),
    ville VARCHAR(100) NOT NULL,
    quartier VARCHAR(100) NOT NULL,
    id_admin VARCHAR(46),
    FOREIGN KEY (id_admin) REFERENCES Utilisateur(id_users)
);

-- Table Chauffeur
CREATE TABLE chauffeur (
    id_chauffeur VARCHAR(46) PRIMARY KEY DEFAULT (UUID()),
    nom_chauffeur VARCHAR(100) NOT NULL,
    telephone VARCHAR(20)
);

-- Table Bus
CREATE TABLE bus (
    id_bus VARCHAR(46) PRIMARY KEY DEFAULT (UUID()),
    nom_bus VARCHAR(100) NOT NULL,
    capacite INT NOT NULL,
    categorie ENUM('VIP', 'Standard') NOT NULL,
    etat ENUM('disponible', 'en_panne', 'en_voyage') NOT NULL
);

-- Table Place
CREATE TABLE place (
    id_place VARCHAR(46) PRIMARY KEY DEFAULT (UUID()),
    numero VARCHAR(10) NOT NULL,
    Disponibilite BOOLEAN DEFAULT TRUE,
    id_bus VARCHAR(46) NOT NULL,
    id_reservation VARCHAR(46) NULL,
    FOREIGN KEY (id_bus) REFERENCES bus(id_bus),
    FOREIGN KEY (id_reservation) REFERENCES reservation(id_reservation)
);

-- Table Trajet
CREATE TABLE trajet (
    id_trajet VARCHAR(46) PRIMARY KEY DEFAULT (UUID()),
    ville_depart VARCHAR(100) NOT NULL,
    ville_arrivee VARCHAR(100) NOT NULL,
    id_admin VARCHAR(46) NOT NULL,
    FOREIGN KEY (id_admin) REFERENCES utilisateur(id_users)
);

-- Table Voyage
CREATE TABLE voyage (
    id_voyage VARCHAR(46) PRIMARY KEY DEFAULT (UUID()),
    nom_voyage VARCHAR(100),
    heure_depart TIME NOT NULL,
    heure_arrivee TIME NOT NULL,
    statut ENUM('ouvert','fermé') NOT NULL,
    categorie ENUM('VIP', 'Standard') NOT NULL,
    prix INT NOT NULL,
    id_Trajet VARCHAR(46) NOT NULL,
    id_bus VARCHAR(46) NOT NULL,
    id_chauffeur VARCHAR(46) NOT NULL,
    id_agence VARCHAR(46) NOT NULL,
    FOREIGN KEY (id_trajet) REFERENCES trajet(id_trajet),
    FOREIGN KEY (id_bus) REFERENCES bus(id_bus),
    FOREIGN KEY (id_chauffeur)REFERENCES chauffeur(id_chauffeur),
    FOREIGN KEY (id_agence) REFERENCES agence(id_agence)
);

-- Table Reservation
CREATE TABLE reservation (
    id_reservation VARCHAR(46) PRIMARY KEY DEFAULT (UUID()),
    statut ENUM('en_attente', 'confirmee', 'echouee', 'annulee') NOT NULL,
    date_reservation DATETIME NOT NULL,
    mode_paiement ENUM('Orange_Money', 'MTN_MOMO') NOT NULL,
    montant DECIMAL(10,2) NOT NULL,
    date_paiement DATETIME,
    id_client VARCHAR(46) NOT NULL,
    id_voyage VARCHAR(46) NOT NULL,
    FOREIGN KEY (id_client) REFERENCES utilisateur(id_users),
    FOREIGN KEY (id_voyage) REFERENCES voyage(id_voyage)
);


-- Table Passager
CREATE TABLE passager (
    id_passager VARCHAR(46) PRIMARY KEY DEFAULT (UUID()),
    nom_passager VARCHAR(100) NOT NULL,
    id_reservation VARCHAR(46) NOT NULL,
    id_place VARCHAR(46) NOT NULL,
    FOREIGN KEY (id_reservation) REFERENCES reservation(id_reservation),
    FOREIGN KEY (id_place) REFERENCES place(id_place)
);


CREATE TABLE place_voyage (
  id_place_voyage VARCHAR(46) PRIMARY KEY DEFAULT (UUID()),
  statut ENUM('libre','en_attente','occupee') DEFAULT 'libre',
  id_place VARCHAR(46) NOT NULL,
  id_voyage VARCHAR(46) NOT NULL,
  id_reservation VARCHAR(46) NULL,
  heure_debut_reservation DATETIME NULL,
  FOREIGN KEY (id_voyage) REFERENCES voyage(id_voyage),
  FOREIGN KEY (id_place) REFERENCES place(id_place),
  FOREIGN KEY (id_reservation) REFERENCES reservation(id_reservation)
);
select * from place_voyage ;
update place_voyage set statut = 'libre', id_reservation = NULL, id_passager = null WHERE statut = 'occupee';
select * from reservation;
DELETE FROM reservation;

SELECT DISTINCT pv.id_reservation 
            FROM place_voyage pv 
            WHERE pv.id_voyage = '6db1c653-0ea0-ac74-f58a-82ae18c2ea24' and pv.id_reservation IS NOT NULL;

SELECT * from utilisateur WHERE nom_users = 'fabo';
DELETE FROM utilisateur where role_users = 'admin_principal';

UPDATE utilisateur set role_users = 'admin_principal' WHERE nom_users = 'Tamafo';

SELECT * FROM utilisateur WHERE ((role_users = 'admin' and id_users not in (select id_admin from agence where delet = 1)) or role_users = 'admin_principal') and delet = 1;

SELECT DISTINCT r.statut,r.date_reservation,r.heure_reservation,r.mode_paiement,r.montant, v.nom_voyage,v.id_voyage, a.quartier
                 FROM reservation r, voyage v, place_voyage pv, agence a
                 WHERE pv.id_reservation = r.id_reservation
                 and pv.id_voyage = v.id_voyage  
                 and v.id_agence = a.id_agence
                 AND r.id_client = 'cfef7ea2-6404-11f1-9db7-ec21e54d6a2f';

SELECT DISTINCT r.id_reservation,r.statut,r.date_reservation,r.heure_reservation,r.mode_paiement,r.montant, v.nom_voyage,v.id_voyage, a.quartier,
                  (SELECT COUNT(*) FROM place_voyage pv2 WHERE pv2.id_reservation = r.id_reservation) AS nb_places
                 FROM reservation r, voyage v, agence a
                 WHERE r.id_voyage = v.id_voyage 
                 and v.id_agence = a.id_agence
                 AND r.id_client = 'cfef7ea2-6404-11f1-9db7-ec21e54d6a2f';


SELECT p.*, r.date_reservation,r.heure_reservation,r.id_reservation,v.id_voyage
FROM passager p, place_voyage pv, voyage v, reservation r
where p.id_passager = pv.id_passager
and r.id_reservation = pv.id_reservation
and pv.id_voyage = v.id_voyage
and v.id_agence = '4bd1399a-5ffb-11f1-bb9f-ec21e54d6a2f';

SELECT p.*, r.date_reservation
                   FROM passager p, place_voyage pv, voyage v, reservation r
                   where p.id_passager = pv.id_passager
                   and r.id_reservation = pv.id_reservation
                   and pv.id_voyage = v.id_voyage
                   and v.id_agence = '3ea565dd-6018-11f1-bb9f-ec21e54d6a2f';

select a.*,u.nom_users from utilisateur u, agence a where u.id_users = a.id_admin and a.delet = 1;
SELECT * from utilisateur WHERE role_users = 'admin' and delet = 1 ; 
select quartier from agence where id_admin = '1bd4d248-5f4c-11f1-bb9f-ec21e54d6a2f';
select * from agence ;
SELECT DISTINCT r.id_reservation,r.statut,r.date_reservation,r.heure_reservation,r.mode_paiement,r.montant, v.nom_voyage,v.id_voyage, a.quartier,
                  (SELECT COUNT(*) FROM place_voyage pv2 WHERE pv2.id_reservation = r.id_reservation) AS nb_places
                 FROM reservation r, voyage v, place_voyage pv,  agence a
                 WHERE pv.id_reservation = r.id_reservation
                 and pv.id_voyage = v.id_voyage 
                 and v.id_agence = a.id_agence
                AND r.id_client = 'cfef7ea2-6404-11f1-9db7-ec21e54d6a2f';

SELECT COUNT(*) as total_trajet FROM trajet WHERE delet = 1;

 SELECT 
            COUNT(DISTINCT r.id_reservation) AS nb_resas,
            COALESCE(SUM(r.montant), 0) AS ca
        FROM reservation r
        JOIN place_voyage pv ON r.id_reservation = pv.id_reservation
        JOIN voyage v ON v.id_voyage = pv.id_voyage
        WHERE DATE(r.date_reservation) = CURDATE()
        AND r.statut = 'confirmee'
        AND v.id_agence = '4bd1399a-5ffb-11f1-bb9f-ec21e54d6a2f'
        AND r.delet = ;

SELECT * FROM agence;

 SELECT COUNT(DISTINCT r.id_reservation) FROM reservation r
        JOIN place_voyage pv ON r.id_reservation = pv.id_reservation
        JOIN voyage v ON v.id_voyage = pv.id_voyage
        WHERE DATE(r.date_reservation) = CURDATE()
        AND v.id_agence = 
        AND r.delet = 1;

SELECT 
    COALESCE(SUM(r.montant), 0) AS ca_total
FROM reservation r
JOIN voyage v ON v.id_voyage = r.id_voyage
WHERE DATE(r.date_reservation) = CURDATE()
AND r.statut = 'confirmee'
AND v.id_agence = '4bd1399a-5ffb-11f1-bb9f-ec21e54d6a2f'
AND r.delet = 1;

SELECT 
            COUNT(DISTINCT r.id_reservation) AS nb_resas,
            COALESCE(SUM(DISTINCT r.montant), 0) AS ca
        FROM reservation r
        JOIN place_voyage pv ON r.id_reservation = pv.id_reservation
        JOIN voyage v ON v.id_voyage = pv.id_voyage
        WHERE r.statut = 'confirmee'
        AND v.id_agence = '4bd1399a-5ffb-11f1-bb9f-ec21e54d6a2f'
        AND r.delet = 1