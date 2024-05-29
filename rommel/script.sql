-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema Kantoor Compleet
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema Kantoor Compleet
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `Kantoor Compleet` DEFAULT CHARACTER SET utf8 ;
USE `Kantoor Compleet` ;

-- -----------------------------------------------------
-- Table `Kantoor Compleet`.`Gebruiker`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Kantoor Compleet`.`Gebruiker` (
  `idGebruiker` INT NOT NULL AUTO_INCREMENT,
  `Naam` VARCHAR(45) NULL,
  `Gebruikersnaam` VARCHAR(45) NULL,
  `Wachtwoord` VARCHAR(45) NULL,
  PRIMARY KEY (`idGebruiker`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Kantoor Compleet`.`advertentie`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Kantoor Compleet`.`advertentie` (
  `idadvertentie` INT NOT NULL AUTO_INCREMENT,
  `Naam` VARCHAR(45) NOT NULL,
  `Prijs` DECIMAL NULL,
  `beschrijving` TEXT NULL,
  `Gebruiker_idGebruiker` INT NOT NULL,
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
CREATE TABLE IF NOT EXISTS `Kantoor Compleet`.`biedingen` (
  `idbiedingen` INT NOT NULL AUTO_INCREMENT,
  `advertentie_idadvertentie` INT NOT NULL,
  `prijs` DECIMAL NULL,
  PRIMARY KEY (`idbiedingen`, `advertentie_idadvertentie`),
  INDEX `fk_biedingen_advertentie_idx` (`advertentie_idadvertentie` ASC) VISIBLE,
  CONSTRAINT `fk_biedingen_advertentie`
    FOREIGN KEY (`advertentie_idadvertentie`)
    REFERENCES `Kantoor Compleet`.`advertentie` (`idadvertentie`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Kantoor Compleet`.`geschprek`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Kantoor Compleet`.`geschprek` (
  `idgeschprekk` INT NOT NULL AUTO_INCREMENT,
  `geschprekkcol` VARCHAR(45) NULL,
  PRIMARY KEY (`idgeschprekk`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Kantoor Compleet`.`geschprek-gebruiker`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Kantoor Compleet`.`geschprek-gebruiker` (
  `geschprekk_idgeschprekk` INT NOT NULL,
  `Gebruiker_idGebruiker` INT NOT NULL,
  PRIMARY KEY (`geschprekk_idgeschprekk`, `Gebruiker_idGebruiker`),
  INDEX `fk_geschprekk_has_Gebruiker_Gebruiker1_idx` (`Gebruiker_idGebruiker` ASC) VISIBLE,
  INDEX `fk_geschprekk_has_Gebruiker_geschprekk1_idx` (`geschprekk_idgeschprekk` ASC) VISIBLE,
  CONSTRAINT `fk_geschprekk_has_Gebruiker_geschprekk1`
    FOREIGN KEY (`geschprekk_idgeschprekk`)
    REFERENCES `Kantoor Compleet`.`geschprek` (`idgeschprekk`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_geschprekk_has_Gebruiker_Gebruiker1`
    FOREIGN KEY (`Gebruiker_idGebruiker`)
    REFERENCES `Kantoor Compleet`.`Gebruiker` (`idGebruiker`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Kantoor Compleet`.`categorie`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Kantoor Compleet`.`categorie` (
  `idcategorie` INT NOT NULL AUTO_INCREMENT,
  `naam` VARCHAR(45) NULL,
  PRIMARY KEY (`idcategorie`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Kantoor Compleet`.`categorieën-advertentie`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Kantoor Compleet`.`categorieën-advertentie` (
  `advertentie_idadvertentie` INT NOT NULL,
  `categorie_idcategorie` INT NOT NULL,
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


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
