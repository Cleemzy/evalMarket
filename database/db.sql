CREATE DATABASE CASH;
USE CASH;

--VIEW
CREATE VIEW viewGp 
AS SELECT goods.code, goods.designation, goods.up, promotions.nom, goods.stock
FROM goods 
INNER JOIN promotions ON goods.code=promotions.code;  
--TABLES
CREATE TABLE ACHAT(
    code VARCHAR(128) NOT NULL,
    pachat int(11) not null,
    FOREIGN KEY(code) REFERENCES goods(code)
);

create TABLE CHIFFRES(
    heure datetime ,
    motifs VARCHAR(500) NOT NULL,
    montant int
);
CREATE TABLE PROMOTIONS(
    code VARCHAR(128) NOT NULL,
    nom VARCHAR(128) NOT NULL,
    FOREIGN KEY(code) REFERENCES goods(code)
);
CREATE TABLE CASHADMIN(
    pseudo VARCHAR(128) NOT NULL,
    pass VARCHAR (128) NOT NULL
);

CREATE TABLE CASHEMPLOYEE(
    pseudo VARCHAR(128) NOT NULL,
    pass VARCHAR(128) NOT NULL
);

CREATE TABLE GOODS(
    code VARCHAR(128) NOT NULL,
    designation VARCHAR(128) NOT NULL,
    up int(11) NOT NULL,
    stock int(11) NOT NULL,
    PRIMARY KEY (code)
);

--DATA
INSERT INTO PROMOTIONS(code,nom)VALUES('003','25% de reduction');
INSERT INTO PROMOTIONS(code,nom)VALUES('478','2 achetes-3eme 50%');
INSERT INTO PROMOTIONS(code,nom)VALUES('360','5% de reduction');
INSERT INTO PROMOTIONS(code,nom)VALUES('028','1 achete-1 offert');
INSERT INTO PROMOTIONS(code,nom)VALUES('141','Pas de promotion');

INSERT INTO GOODS(code,designation,up,stock) VALUES('003',  'Yaourt 125 ml',980,10);
INSERT INTO GOODS(code,designation,up,stock) VALUES('478','Sauce soja 100ml',1000,25);
INSERT INTO GOODS(code,designation,up,stock) VALUES('360','Farine 5kg',3000,5);
INSERT INTO GOODS(code,designation,up,stock) VALUES('028','dentifrice',2000,100);
INSERT INTO GOODS(code,designation,up,stock) VALUES('141','Margarine',4000,50);

--ACHATS
INSERT INTO ACHAT(code,pachat) VALUES('003',600);
INSERT INTO ACHAT(code,pachat) VALUES('478',800);
INSERT INTO ACHAT(code,pachat) VALUES('360',2500);
INSERT INTO ACHAT(code,pachat) VALUES('028',1500);
INSERT INTO ACHAT(code,pachat) VALUES('141',2000);

--CASH EMPLOYEES AND ADMIN
INSERT INTO CASHEMPLOYEE(pseudo,pass) VALUES('Employee1',SHA1('mdpEmploye1'));
UPDATE CASHADMIN SET PASS='mdpAdmin1' WHERE PSEUDO='Admin1';
INSERT INTO CASHADMIN(pseudo,pass) VALUES('Admin1',SHA1('mdpAdmin1'));

UPDATE PROMOTIONS SET NOM='1 achetes-1 offerts' WHERE CODE='028';

--CHIFFRES D'AFFAIRE
INSERT INTO CHIFFRES(heure,montant)VALUES('2020-07-14 10:00:00',4500);