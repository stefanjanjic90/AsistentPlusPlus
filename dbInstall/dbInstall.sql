SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

DROP SCHEMA IF EXISTS `mydb` ;
CREATE SCHEMA IF NOT EXISTS `mydb` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `mydb` ;

-- -----------------------------------------------------
-- Table `mydb`.`Katedra`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`Katedra` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`Katedra` (
  `id` INT NOT NULL ,
  `naziv` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Nalog`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`Nalog` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`Nalog` (
  `korisnickoIme` VARCHAR(20) NOT NULL ,
  `ime` VARCHAR(45) NOT NULL ,
  `prezime` VARCHAR(100) NOT NULL ,
  `email` VARCHAR(45) NOT NULL ,
  `telefon` VARCHAR(20) NOT NULL ,
  `lozinka` VARCHAR(32) NOT NULL ,
  `katedra` INT NOT NULL ,
  `jeDezurni` TINYINT(1) NOT NULL ,
  `jeAdministrator` TINYINT(1) NOT NULL ,
  `jeKoordinator` TINYINT(1) NOT NULL ,
  `opterecenje` DECIMAL(3,2) NOT NULL ,
  `status` TINYINT(1) NOT NULL ,
  `napomena` VARCHAR(100) NULL ,
  `koeficijentAngazovanja` FLOAT NOT NULL ,
  PRIMARY KEY (`korisnickoIme`) ,
  INDEX `fk_Nalog_Katedra_idx` (`katedra` ASC) ,
  CONSTRAINT `fk_Nalog_Katedra`
    FOREIGN KEY (`katedra` )
    REFERENCES `mydb`.`Katedra` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Lokacija`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`Lokacija` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`Lokacija` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `opis` VARCHAR(45) NOT NULL ,
  `adresa` VARCHAR(45) NOT NULL ,
  `email` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Sala`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`Sala` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`Sala` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `oznaka` VARCHAR(45) NOT NULL ,
  `kapacitet` INT NOT NULL ,
  `racunariKapacitet` VARCHAR(45) NOT NULL ,
  `lokacija` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_Sala_Lokacija1_idx` (`lokacija` ASC) ,
  CONSTRAINT `fk_Sala_Lokacija1`
    FOREIGN KEY (`lokacija` )
    REFERENCES `mydb`.`Lokacija` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Obaveza`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`Obaveza` ;

CREATE TABLE IF NOT EXISTS `mydb`.`obaveza` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nazivObaveze` VARCHAR(45) NOT NULL,
  `korisnickoImeGlavnogDezurnog` VARCHAR(20) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_Obaveza_Nalog1_idx` (`korisnickoImeGlavnogDezurnog` ASC),
  CONSTRAINT `fk_Obaveza_Nalog1`
    FOREIGN KEY (`korisnickoImeGlavnogDezurnog`)
    REFERENCES `mydb`.`nalog` (`korisnickoIme`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`NajavljenaGrupa`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`NajavljenaGrupa` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`NajavljenaGrupa` (
  `rbrNajave` INT NOT NULL AUTO_INCREMENT ,
  `grupa` INT NOT NULL ,
  `obaveza` INT NOT NULL ,
  `oznaka` VARCHAR(45) NOT NULL ,
  `datum` DATE NULL ,
  `pocetakRezervacije` TIME NULL ,
  `krajRezervacije` TIME NULL ,
  `trajanjeDezurstvaPredmetnogAsistenta` TINYINT NOT NULL ,
  `pocetakDezurstvaPomocnogDezurnog` TIME NULL ,
  `trajanjeDezurstvaPomocnogDezurnog` TINYINT NOT NULL ,
  `radNaRacunarima` TINYINT(1) NOT NULL ,
  `brojDezurnih` TINYINT NOT NULL ,
  `napomenaZaKoordinatora` VARCHAR(45) NULL ,
  `napomenaZaDezurne` VARCHAR(45) NULL ,
  `brojOcekivanihStudenata` INT NULL ,
  `datumNajave` DATE NOT NULL ,
  `status` TINYINT(1) NOT NULL ,
  INDEX `fk_Grupa_Obaveza2_idx` (`obaveza` ASC) ,
  INDEX `key` (`rbrNajave` ASC) ,
  PRIMARY KEY (`rbrNajave`) ,
  CONSTRAINT `fk_Grupa_Obaveza2`
    FOREIGN KEY (`obaveza` )
    REFERENCES `mydb`.`Obaveza` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`predmetniAsistentiNaObavezi`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`predmetniAsistentiNaObavezi` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`predmetniAsistentiNaObavezi` (
  `id` INT NOT NULL AUTO_INCREMENT,  
  `korisnickoIme` VARCHAR(20) NOT NULL ,
  `obaveza` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_asistentiNaObavezi_Obaveza1_idx` (`obaveza` ASC) ,
  CONSTRAINT `fk_asistentiNaObavezi_Nalog1`
    FOREIGN KEY (`korisnickoIme` )
    REFERENCES `mydb`.`Nalog` (`korisnickoIme` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_asistentiNaObavezi_Obaveza1`
    FOREIGN KEY (`obaveza` )
    REFERENCES `mydb`.`Obaveza` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `uc_korisnickoImeObaveza` UNIQUE (`korisnickoIme`,`obaveza`)
  )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`ZakazanaGrupa`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`ZakazanaGrupa` ;
-- izbacena obaeza umesto nje stavljen rbrNajave
CREATE  TABLE IF NOT EXISTS `mydb`.`ZakazanaGrupa` (
  `rbrZakazivanja` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `rbrNajave` int NOT NULL,
  `grupa` INT NOT NULL ,
  `obaveza` INT NOT NULL,
  `oznaka` VARCHAR(45) NOT NULL ,
  `datum` DATE NOT NULL ,
  `pocetakRezervacije` TIME NOT NULL ,
  `krajRezervacije` TIME NOT NULL ,
  `trajanjeDezurstvaPredmetnogAsistenta` TINYINT NOT NULL ,
  `pocetakDezurstvaPomocnogDezurnog` TIME NOT NULL ,
  `trajanjeDezurstvaPomocnogDezurnog` TINYINT NOT NULL ,
  `radNaRacunarima` TINYINT(1) NOT NULL ,
  `brojDezurnih` TINYINT NOT NULL ,
  `napomenaZaDezurne` VARCHAR(45) NULL ,
  `brojOcekivanihStudenata` INT NULL ,
  `brojPrijavljenih` INT NULL ,
  `brojIzaslih` INT NULL ,
  `datumObrade` DATE NOT NULL ,
  `status` TINYINT(1) NOT NULL ,
  PRIMARY KEY (`rbrZakazivanja`) ,
  INDEX `fk_ZakazanaGrupa_NajavljenaGrupa1_idx` (`rbrNajave` ASC) ,
  CONSTRAINT `fk_ZakazanaGrupa_NajavljenaGrupa1`
    FOREIGN KEY (`rbrNajave` )
    REFERENCES `mydb`.`NajavljenaGrupa` (`rbrNajave` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
 CONSTRAINT `fk_ZakazanaGrupa_Obaveza`
    FOREIGN KEY (`obaveza` )
    REFERENCES `mydb`.`Obaveza` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`NajavljenaGrupaSala`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`NajavljenaGrupaSala` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`NajavljenaGrupaSala` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `sala` INT NOT NULL ,
  `rbrNajave` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_NajavljenaGrupaSala_NajavljenaGrupa1_idx` (`rbrNajave` ASC) ,
  CONSTRAINT `fk_NajavljenaGrupaSala_Sala1`
    FOREIGN KEY (`sala` )
    REFERENCES `mydb`.`Sala` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_NajavljenaGrupaSala_NajavljenaGrupa1`
    FOREIGN KEY (`rbrNajave` )
    REFERENCES `mydb`.`NajavljenaGrupa` (`rbrNajave` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `uc_salaRbrNajave` UNIQUE (`sala`, `rbrNajave`)
  )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`ZakazanaGrupaSala`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`ZakazanaGrupaSala` ;


CREATE  TABLE IF NOT EXISTS `mydb`.`ZakazanaGrupaSala` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `sala` INT NOT NULL ,
  `rbrZakazivanja` INT UNSIGNED NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_ZakazanaGrupaSala_ZakazanaGrupa1_idx` (`rbrZakazivanja` ASC) ,
  CONSTRAINT `fk_ZakazanaGrupaSala_Sala1`
    FOREIGN KEY (`sala` )
    REFERENCES `mydb`.`Sala` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ZakazanaGrupaSala_ZakazanaGrupa1`
    FOREIGN KEY (`rbrZakazivanja` )
    REFERENCES `mydb`.`ZakazanaGrupa` (`rbrZakazivanja` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `uc_salaRbrZakazivanja` UNIQUE (`sala`, `rbrZakazivanja`)
	)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`ZakazanaGrupaDezurni`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`ZakazanaGrupaDezurni` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`ZakazanaGrupaDezurni` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `korisnickoIme` VARCHAR(20) NOT NULL ,
  `rbrZakazivanja` INT UNSIGNED NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_ZakazanaGrupaDezurni_Nalog1_idx` (`korisnickoIme` ASC) ,
  INDEX `fk_ZakazanaGrupaDezurni_ZakazanaGrupa1_idx` (`rbrZakazivanja` ASC) ,
  CONSTRAINT `fk_ZakazanaGrupaDezurni_Nalog1`
    FOREIGN KEY (`korisnickoIme` )
    REFERENCES `mydb`.`Nalog` (`korisnickoIme` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ZakazanaGrupaDezurni_ZakazanaGrupa1`
    FOREIGN KEY (`rbrZakazivanja` )
    REFERENCES `mydb`.`ZakazanaGrupa` (`rbrZakazivanja` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `uc_korisnickoImeRbrZakazivanja` UNIQUE (`korisnickoIme`, `rbrZakazivanja`)
  )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`NapomenaGrupaDezurni`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`NapomenaGrupaDezurni` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`NapomenaGrupaDezurni` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `korisnickoImeGlavnogDezurnog` VARCHAR(20) NOT NULL ,
  `napomena` VARCHAR(100) NOT NULL ,
  `datumNapomene` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `vidljivost` TINYINT(1) NULL ,
  `procitano` TINYINT(1) NULL ,
  `zakazanaGrupaDezurniId` INT NOT NULL,
  PRIMARY KEY (`id`) ,
  INDEX `fk_NapomenaGrupaDezurni_ZakazanaGrupaDezurni1_idx` (`zakazanaGrupaDezurniId` ASC) ,
  CONSTRAINT `fk_NapomenaGrupaDezurni_ZakazanaGrupaDezurni1`
    FOREIGN KEY (`zakazanaGrupaDezurniId` )
    REFERENCES `mydb`.`ZakazanaGrupaDezurni` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `uc_korisnickoImeGlavnogDezurnogKorisnickoImeRbrZakazivanja` UNIQUE (`zakazanaGrupaDezurniId`, `korisnickoImeGlavnogDezurnog`)
  )
ENGINE = InnoDB;



-- -----------------------------------------------------
-- Table `mydb`.`NapomenaGrupa`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`NapomenaGrupa` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`NapomenaGrupa` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `korisnickoImeGlavnogDezurnog` VARCHAR(20) NOT NULL ,
  `rbrZakazivanja` INT UNSIGNED NOT NULL ,
  `napomena` VARCHAR(100) NOT NULL ,
  `datumNapomene` DATE NOT NULL ,
  `vidljivost` TINYINT(1) NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_NapomenaGrupa_ZakazanaGrupa1_idx` (`rbrZakazivanja` ASC) ,
  CONSTRAINT `fk_NapomenaGrupa_ZakazanaGrupa1`
    FOREIGN KEY (`rbrZakazivanja` )
    REFERENCES `mydb`.`ZakazanaGrupa` (`rbrZakazivanja` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `uc_korisnickoImeGlavnogDezurnogRbrZakazivanja` UNIQUE (`korisnickoImeGlavnogDezurnog`,`rbrZakazivanja`)
  )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`PonudjeneZamene`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`PonudjeneZamene` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`PonudjeneZamene` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `korisnickoImePrimaoca` VARCHAR(20) NOT NULL ,
  `status` TINYINT(1) NOT NULL ,
  `zakazanaGrupaDezurniId` INT NOT NULL,
  INDEX `fk_PonudjeneZamene_Nalog1_idx` (`korisnickoImePrimaoca` ASC) ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `fk_PonudjeneZamene_Nalog1`
    FOREIGN KEY (`korisnickoImePrimaoca` )
    REFERENCES `mydb`.`Nalog` (`korisnickoIme` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_PonudjeneZamene_ZakazanaGrupaDezurni1`
    FOREIGN KEY (`zakazanaGrupaDezurniId`)
    REFERENCES `mydb`.`ZakazanaGrupaDezurni` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `uc_korisnickoImePosiljaocaKorisnickoImePrimaocaRbrZakazivanja` UNIQUE (`zakazanaGrupaDezurniId`, `korisnickoImePrimaoca`)

	)
ENGINE = InnoDB;

USE `mydb` ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;