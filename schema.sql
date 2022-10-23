CREATE DATABASE `essensplan_produktiv`;

CREATE TABLE `essensplan_produktiv`.`gerichte` (
  `id` INT(5) NOT NULL AUTO_INCREMENT,
  `gericht` VARCHAR(100) NOT NULL UNIQUE,
  `quelle` VARCHAR(100),
  `dauer` int(3),
  `portionen` int(3),
  `kommentar` VARCHAR(200),
  PRIMARY KEY  (`id`)
);

CREATE TABLE `essensplan_produktiv`.`naehrwerte` (
  `gericht` VARCHAR(100) PRIMARY KEY,
  `kalorien` int(5),
  `kohlenhydrate` int(4),
  `eiweiss` int(4)
);

CREATE TABLE `essensplan_produktiv`.`zutaten` (
  `zutat` VARCHAR(100) PRIMARY KEY,
  `grundmenge` int(5),
  `einheit` VARCHAR(30),
  `supermarkt` VARCHAR(30),
  `reihenfolge` int(5)
);

CREATE TABLE `essensplan_produktiv`.`rezepte` (
  `id` INT(5) NOT NULL AUTO_INCREMENT,
  `gericht` VARCHAR(100) NOT NULL,
  `zutat` VARCHAR(100) NOT NULL,
  `rezeptmenge` int(5),
  `einheit` VARCHAR(20),
  PRIMARY KEY  (`id`)
);

CREATE TABLE `essensplan_produktiv`.`wochenplaene` (
  `id` INT(5) NOT NULL AUTO_INCREMENT,
  `jahr` VARCHAR(100) NOT NULL,
  `kalenderwoche` VARCHAR(100) NOT NULL,
  `wochentag` VARCHAR(100) NOT NULL,
  `gericht` VARCHAR(100),
  PRIMARY KEY  (`id`)
);

CREATE TABLE `essensplan_produktiv`.`einkaufsliste` (
  `id` INT(5) NOT NULL AUTO_INCREMENT,
  `zutat` VARCHAR(100) NOT NULL UNIQUE,
  `menge` int(5),
  `einheit` VARCHAR(30),
  `supermarkt` VARCHAR(30),
  `reihenfolge` int(5),
  PRIMARY KEY  (`id`)
);

/*CREATE TABLE `essensplan_test`.`gerichte` (
  `id` INT(5) NOT NULL AUTO_INCREMENT,
  `gericht` VARCHAR(100) NOT NULL UNIQUE,
  `quelle` VARCHAR(100),
  `dauer` int(3),
  `kommentar` VARCHAR(200),
  PRIMARY KEY  (`id`)
);

CREATE TABLE `essensplan_test`.`naehrwerte` (
  `id` INT(5) NOT NULL AUTO_INCREMENT,
  `gericht` VARCHAR(100) NOT NULL UNIQUE,
  `kalorien` int(5),
  `kohlenhydrate` int(4),
  `eiweiss` int(4),
  `fett` int(4),
  PRIMARY KEY  (`id`)
);

CREATE TABLE `essensplan_test`.`zutaten` (
  `id` INT(5) NOT NULL AUTO_INCREMENT,
  `zutat` VARCHAR(100) NOT NULL UNIQUE,
  `grundmenge` int(5),
  `einheit` VARCHAR(30),
  PRIMARY KEY  (`id`)
);

CREATE TABLE `essensplan_test`.`rezepte` (
  `id` INT(5) NOT NULL AUTO_INCREMENT,
  `gericht` VARCHAR(100) NOT NULL,
  `zutat` VARCHAR(100) NOT NULL,
  `rezeptmenge` int(5),
  `einheit` VARCHAR(20),
  `portionen` int(3),
  PRIMARY KEY  (`id`)
);

CREATE TABLE `essensplan_test`.`wochenplaene` (
  `id` INT(5) NOT NULL AUTO_INCREMENT,
  `jahr` VARCHAR(100) NOT NULL,
  `kalenderwoche` VARCHAR(100) NOT NULL,
  `wochentag` VARCHAR(100) NOT NULL,
  `gericht` int(5),
  PRIMARY KEY  (`id`)
);

CREATE TABLE `essensplan_test`.`einkaufsliste` (
  `id` INT(5) NOT NULL AUTO_INCREMENT,
  `zutat` VARCHAR(100) NOT NULL UNIQUE,
  `menge` int(5),
  `einheit` VARCHAR(30),
  `supermarkt` VARCHAR(30),
  `reihenfolge` int(5),
  PRIMARY KEY  (`id`)
); */
