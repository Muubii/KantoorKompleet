-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema Kantoor Compleet
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `Kantoor Compleet` ;

-- -----------------------------------------------------
-- Schema Kantoor Compleet
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `Kantoor Compleet` ;
USE `Kantoor Compleet` ;

-- -----------------------------------------------------
-- Table `Kantoor Compleet`.`Gebruiker`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Kantoor Compleet`.`Gebruiker` ;

CREATE TABLE IF NOT EXISTS `Kantoor Compleet`.`Gebruiker` (
  `idGebruiker` INT(11) NOT NULL AUTO_INCREMENT,
  `Naam` VARCHAR(45) NULL DEFAULT NULL,
  `Gebruikersnaam` VARCHAR(45) NULL DEFAULT NULL,
  `Wachtwoord` VARCHAR(255) NULL DEFAULT NULL,
  PRIMARY KEY (`idGebruiker`))
ENGINE = InnoDB
AUTO_INCREMENT = 3;


-- -----------------------------------------------------
-- Table `Kantoor Compleet`.`advertentie`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Kantoor Compleet`.`advertentie` ;

CREATE TABLE IF NOT EXISTS `Kantoor Compleet`.`advertentie` (
  `idadvertentie` INT(11) NOT NULL AUTO_INCREMENT,
  `Naam` VARCHAR(45) NOT NULL,
  `Prijs` DECIMAL(10,0) NULL DEFAULT NULL,
  `beschrijving` TEXT NULL DEFAULT NULL,
  `Gebruiker_idGebruiker` INT(11) NOT NULL,
  PRIMARY KEY (`idadvertentie`, `Gebruiker_idGebruiker`),
  INDEX `fk_advertentie_Gebruiker1_idx` (`Gebruiker_idGebruiker` ASC) VISIBLE,
  CONSTRAINT `fk_advertentie_Gebruiker1`
    FOREIGN KEY (`Gebruiker_idGebruiker`)
    REFERENCES `Kantoor Compleet`.`Gebruiker` (`idGebruiker`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Kantoor Compleet`.`biedingen`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Kantoor Compleet`.`biedingen` ;

CREATE TABLE IF NOT EXISTS `Kantoor Compleet`.`biedingen` (
  `idbiedingen` INT(11) NOT NULL AUTO_INCREMENT,
  `advertentie_idadvertentie` INT(11) NOT NULL,
  `prijs` DECIMAL(10,0) NULL DEFAULT NULL,
  PRIMARY KEY (`idbiedingen`, `advertentie_idadvertentie`),
  INDEX `fk_biedingen_advertentie_idx` (`advertentie_idadvertentie` ASC) VISIBLE,
  CONSTRAINT `fk_biedingen_advertentie`
    FOREIGN KEY (`advertentie_idadvertentie`)
    REFERENCES `Kantoor Compleet`.`advertentie` (`idadvertentie`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Kantoor Compleet`.`categorie`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Kantoor Compleet`.`categorie` ;

CREATE TABLE IF NOT EXISTS `Kantoor Compleet`.`categorie` (
  `idcategorie` INT(11) NOT NULL AUTO_INCREMENT,
  `naam` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`idcategorie`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Kantoor Compleet`.`categorieën-advertentie`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Kantoor Compleet`.`categorieën-advertentie` ;

CREATE TABLE IF NOT EXISTS `Kantoor Compleet`.`categorieën-advertentie` (
  `advertentie_idadvertentie` INT(11) NOT NULL,
  `categorie_idcategorie` INT(11) NOT NULL,
  PRIMARY KEY (`advertentie_idadvertentie`, `categorie_idcategorie`),
  INDEX `fk_advertentie_has_categorie_categorie1_idx` (`categorie_idcategorie` ASC) VISIBLE,
  INDEX `fk_advertentie_has_categorie_advertentie1_idx` (`advertentie_idadvertentie` ASC) VISIBLE,
  CONSTRAINT `fk_advertentie_has_categorie_advertentie1`
    FOREIGN KEY (`advertentie_idadvertentie`)
    REFERENCES `Kantoor Compleet`.`advertentie` (`idadvertentie`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_advertentie_has_categorie_categorie1`
    FOREIGN KEY (`categorie_idcategorie`)
    REFERENCES `Kantoor Compleet`.`categorie` (`idcategorie`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Kantoor Compleet`.`geschprek`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Kantoor Compleet`.`geschprek` ;

CREATE TABLE IF NOT EXISTS `Kantoor Compleet`.`geschprek` (
  `idgeschprekk` INT(11) NOT NULL AUTO_INCREMENT,
  `geschprekkcol` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`idgeschprekk`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Kantoor Compleet`.`geschprek-gebruiker`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Kantoor Compleet`.`geschprek-gebruiker` ;

CREATE TABLE IF NOT EXISTS `Kantoor Compleet`.`geschprek-gebruiker` (
  `geschprekk_idgeschprekk` INT(11) NOT NULL,
  `Gebruiker_idGebruiker` INT(11) NOT NULL,
  PRIMARY KEY (`geschprekk_idgeschprekk`, `Gebruiker_idGebruiker`),
  INDEX `fk_geschprekk_has_Gebruiker_Gebruiker1_idx` (`Gebruiker_idGebruiker` ASC) VISIBLE,
  INDEX `fk_geschprekk_has_Gebruiker_geschprekk1_idx` (`geschprekk_idgeschprekk` ASC) VISIBLE,
  CONSTRAINT `fk_geschprekk_has_Gebruiker_Gebruiker1`
    FOREIGN KEY (`Gebruiker_idGebruiker`)
    REFERENCES `Kantoor Compleet`.`Gebruiker` (`idGebruiker`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_geschprekk_has_Gebruiker_geschprekk1`
    FOREIGN KEY (`geschprekk_idgeschprekk`)
    REFERENCES `Kantoor Compleet`.`geschprek` (`idgeschprekk`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
